<?php

namespace App\Http\Controllers;

use App\Models\JadwalMapel;
use App\Models\JadwalMasuk;
use App\Models\MataPelajaran;
use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PresensiPelajaranController extends Controller
{
    public function absensiMulai($mapel_id)
    {
        // Ambil data mata pelajaran berdasarkan $mapel_id
        $mataPelajaran = MataPelajaran::find($mapel_id);

        // Ambil jadwal sesuai dengan mata pelajaran (gunakan relasi)
        $jadwal = JadwalMapel::whereHas('guruMapel', function ($query) use ($mapel_id) {
            $query->where('mapel_id', $mapel_id);
        })->first();

        // dd($jadwal);

        return view('siswa.presensi.presensi-mapel.mulai', compact('mataPelajaran', 'jadwal', 'mapel_id')); // Tambahkan $mapel_id ke compact
    }

    public function storeMulai(Request $request)
    {
        // Validasi request
        $request->validate([
            'image' => 'required|string',
            'lokasi' => 'required|string', // Format "latitude,longitude"
            'mapel_id' => 'required|integer|exists:tbl_mata_pelajaran,id' // Validasi ID mata pelajaran
        ]);
    
        // Ambil pengguna yang terautentikasi
        $user = Auth::user();
    
        if (!$user || !$user->siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan.'], 404);
        }
    
        $siswa = $user->siswa;
        $tanggal = now()->format('Y-m-d');
    
        // Cek apakah siswa sudah absen pulang pada hari ini
        $presensiPulang = Presensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $tanggal)
            ->where('jenis_presensi', 'pelajaran')
            ->whereNotNull('jam_keluar') // Pastikan sudah absen pulang
            ->first();
    
        if ($presensiPulang) {
            return response()->json(['message' => 'Anda sudah absen hari ini, tidak bisa absen masuk lagi.'], 400);
        }

        // Cek apakah siswa sudah check-in (absen masuk) hari ini
        $existingPresensi = Presensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $tanggal)
            ->where('jenis_presensi', 'pelajaran')
            ->whereNull('jam_keluar')
            ->first();

        if ($existingPresensi) {
            return response()->json(['message' => 'Anda sudah absen mulai hari ini.'], 400);
        }

        // Ambil jadwal mapel berdasarkan kelas dan hari
        $hariInggris = now()->format('l'); // Mendapatkan nama hari dalam bahasa Inggris
        $hari = $this->convertHariToIndonesian($hariInggris); // Konversi ke bahasa Indonesia
        $jadwalMapel = \App\Models\JadwalMapel::whereHas('guruMapel', function ($query) use ($siswa) {
            $query->where('kelas_id', $siswa->kelas_id);
        })
            ->where('hari', $hari)
            ->whereHas('guruMapel.mataPelajaran', function ($query) use ($request) {
                $query->where('id', $request->mapel_id); // Pastikan ID mata pelajaran sesuai
            })
            ->first();
    
        if (!$jadwalMapel) {
            return response()->json(['message' => 'Jadwal tidak ditemukan.'], 404);
        }
    
        // Ambil waktu sekarang
        $jamSekarang = now();
    
        // Cek apakah jam sekarang sudah melewati jam_selesai dalam jadwal
        $jamSelesaiJadwal = \Carbon\Carbon::parse($jadwalMapel->jam_selesai); // Ambil waktu jam_selesai dari jadwal
    
        if ($jamSekarang->greaterThan($jamSelesaiJadwal)) {
            return response()->json(['message' => 'Waktu absen masuk sudah lewat karena Anda sudah melewati jam selesai.'], 400);
        }
    
        // Periksa apakah jam saat ini lebih dari jam_mulai dalam jadwal
        $jamMulaiJadwal = \Carbon\Carbon::parse($jadwalMapel->jam_mulai); // Ambil waktu jam_mulai dari jadwal
    
        if ($jamSekarang->lessThan($jamMulaiJadwal)) {
            return response()->json(['message' => 'Waktu absen belum dimulai.'], 400);
        }
    
        $status = 'hadir';
        $tepatWaktu = true;
    
        // Periksa apakah siswa terlambat
        if ($jamSekarang->greaterThan($jamMulaiJadwal)) {
            $tepatWaktu = false; // Set tepat_waktu menjadi false
        }
    
        // Ambil lokasi dari request
        list($userLatitude, $userLongitude) = explode(',', $request->lokasi);
        $distance = $this->calculateDistance($userLatitude, $userLongitude, -6.902189, 107.538401);
    
        if ($distance > 200) {
            return response()->json(['message' => 'Anda berada di luar radius sekolah.'], 400);
        }
    
        // Simpan foto selfie
        $image = str_replace('data:image/jpeg;base64,', '', $request->image);
        $image = str_replace(' ', '+', $image);
        $imageName = $siswa->nisn . '_' . $tanggal . '_mapel_' . $request->mapel_id . '.png';
    
        // Tentukan directory penyimpanan
        $directory = public_path('storage/selfies');
    
        // Buat directory jika belum ada
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true); // Membuat folder dengan permission full akses
        }
    
        // Simpan file ke directory
        $imagePath = $directory . '/' . $imageName;
        file_put_contents($imagePath, base64_decode($image));
    
        // Simpan data ke tbl_presensi
        $presensi = new Presensi();
        $presensi->siswa_id = $siswa->id;
        $presensi->tanggal = $tanggal;
        $presensi->jenis_presensi = 'pelajaran'; // Set jenis presensi sebagai mapel
        $presensi->status = $status; // Menyimpan status ('hadir' atau 'terlambat')
        $presensi->tepat_waktu = $tepatWaktu; // Set true jika tepat waktu, false jika terlambat
        $presensi->jam_masuk = $jamSekarang; // Menyimpan waktu absen masuk
        $presensi->lokasi_masuk = $request->lokasi;
        $presensi->foto_selfie_masuk = 'storage/selfies/' . $imageName; // Simpan path relatif ke file
        $presensi->jadwal_mapel_id = $jadwalMapel->id; // Menyimpan ID jadwal mapel yang valid
        $presensi->jam_keluar = null; // Kolom jam_keluar tidak diisi saat absen masuk
        $presensi->jadwal_masuk_id = null; // Set nilai ini jika diperlukan
        $presensi->save();
    
        // Kirim notifikasi berdasarkan status
        if ($tepatWaktu) {
            return response()->json(['message' => 'Presensi berhasil dicatat! Anda hadir tepat waktu.'], 200);
        } else {
            return response()->json(['message' => 'Presensi berhasil dicatat! Anda terlambat.'], 200);
        }
    }
    

    public function absensiSelesai($mapel_id)
    {
        // Ambil data mata pelajaran berdasarkan $mapel_id
        $mataPelajaran = MataPelajaran::find($mapel_id);

        // Ambil jadwal sesuai dengan mata pelajaran (gunakan relasi)
        $jadwal = JadwalMapel::whereHas('guruMapel', function ($query) use ($mapel_id) {
            $query->where('mapel_id', $mapel_id);
        })->first();

        // Logika untuk absensi selesai
        return view('siswa.presensi.presensi-mapel.selesai', compact('mataPelajaran', 'jadwal', 'mapel_id')); // Pass $mapel_id ke view
    }

    public function storeSelesai(Request $request)
    {
        // Validasi request
        $request->validate([
            'image' => 'required|string',
            'lokasi' => 'required|string', // Format "latitude,longitude"
            'mapel_id' => 'required|integer|exists:tbl_mata_pelajaran,id' // Validasi ID mata pelajaran
        ]);
    
        // Ambil pengguna yang terautentikasi
        $user = Auth::user();
    
        if (!$user || !$user->siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan.'], 404);
        }
    
        $siswa = $user->siswa;
        $tanggal = now()->format('Y-m-d'); // Pastikan timezone yang benar digunakan
    
        // Cek apakah siswa sudah check-in hari ini
        $presensiMasuk = Presensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $tanggal)
            ->where('jenis_presensi', 'pelajaran')
            ->whereNotNull('jam_masuk') // Cek apakah jam_masuk sudah terisi
            ->first();
    
        if (!$presensiMasuk) {
            return response()->json(['message' => 'Anda belum melakukan absensi masuk hari ini.'], 400);
        }
    
        // Cek apakah siswa sudah check-out hari ini
        if ($presensiMasuk->jam_keluar) {
            return response()->json(['message' => 'Anda sudah pulang hari ini.'], 400);
        }
    
        // Ambil jadwal keluar berdasarkan kelas dan hari
        $hariInggris = now()->format('l'); // Mendapatkan nama hari dalam bahasa Inggris
        $hari = $this->convertHariToIndonesian($hariInggris); // Konversi ke bahasa Indonesia
        $jadwalMasuk = JadwalMasuk::where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hari)
            ->first();
    
        if (!$jadwalMasuk) {
            return response()->json(['message' => 'Jadwal tidak ditemukan.'], 404);
        }
    
        // Periksa apakah jam sekarang sama atau lebih dari jam_keluar dalam jadwal
        $jamKeluarJadwal = \Carbon\Carbon::parse($jadwalMasuk->jam_keluar); // Ambil waktu jam_keluar dari jadwal
        $jamSekarang = now(); // Ambil waktu sekarang
    
        if ($jamSekarang->lessThan($jamKeluarJadwal)) {
            return response()->json(['message' => 'Anda belum bisa absen pulang. Jam sekarang belum mencapai waktu keluar.'], 400);
        }
    
        // Ambil lokasi dari request
        list($userLatitude, $userLongitude) = explode(',', $request->lokasi);
    
        // Hitung jarak ke sekolah
        $distance = $this->calculateDistance($userLatitude, $userLongitude, -6.902189, 107.538401);
    
        if ($distance > 200) {
            return response()->json(['message' => 'Anda berada di luar radius sekolah.'], 400);
        }
    
        // Simpan foto selfie
        $image = str_replace('data:image/jpeg;base64,', '', $request->image);
        $image = str_replace(' ', '+', $image);
        $imageName = $siswa->nisn . '_' . $tanggal . '_keluar.png';
    
        // Tentukan directory penyimpanan
        $directory = public_path('storage/selfies');
    
        // Buat directory jika belum ada
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);  // Membuat folder dengan permission full akses
        }
    
        // Simpan file ke directory
        $imagePath = $directory . '/' . $imageName;
        file_put_contents($imagePath, base64_decode($image));
    
        // Update data presensi untuk jam keluar, lokasi keluar, dan foto keluar
        $presensiMasuk->jam_keluar = $jamSekarang; // Atur jam keluar
        $presensiMasuk->lokasi_keluar = $request->lokasi;
        $presensiMasuk->foto_selfie_keluar = 'storage/selfies/' . $imageName; // Simpan path relatif ke file
        $presensiMasuk->save();
    
        return response()->json(['message' => 'Presensi pulang berhasil dicatat!'], 200);
    }    
    
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius Bumi dalam meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c; // Jarak dalam meter

        return $distance;
    }

    private function convertHariToIndonesian($dayInEnglish)
    {
        $days = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        return $days[$dayInEnglish] ?? $dayInEnglish;
    }
}
