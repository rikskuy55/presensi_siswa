<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Presensi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    // Show the form where students take a selfie for daily attendance
    public function showSelfieForm()
    {
        // Ambil pengguna yang terautentikasi
        $user = Auth::user();

        // Pastikan pengguna adalah siswa
        if (!$user || !$user->siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan.'], 404);
        }

        // Dapatkan data siswa
        $siswa = $user->siswa;

        // Konversi nama hari ke bahasa Indonesia
        $hariInggris = now()->format('l'); // Mendapatkan nama hari dalam bahasa Inggris
        $hari = $this->convertHariToIndonesian($hariInggris); // Konversi ke bahasa Indonesia

        // Mengambil jadwal
        $jadwal = DB::table('tbl_jadwal_masuk')
            ->where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hari)
            ->first();

        // Kirim data siswa ke view
        return view('siswa.presensi.presensi-harian.masuk', compact('siswa', 'jadwal'));
    }

    // Handle the selfie submission
    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'image' => 'required|string',
            'lokasi' => 'required|string', // Format "latitude,longitude"
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
            ->whereNotNull('jam_keluar') // Pastikan sudah absen pulang
            ->first();

        if ($presensiPulang) {
            return response()->json(['message' => 'Anda sudah absen hari ini, tidak bisa absen masuk lagi.'], 400);
        }

        // Cek apakah siswa sudah check-in (absen masuk) hari ini
        $existingPresensi = Presensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $tanggal)
            ->where('jenis_presensi', 'harian')
            ->whereNull('jam_keluar')
            ->first();

        if ($existingPresensi) {
            return response()->json(['message' => 'Anda sudah absen masuk hari ini.'], 400);
        }

        // Ambil jadwal masuk berdasarkan kelas dan hari
        $hariInggris = now()->format('l'); // Mendapatkan nama hari dalam bahasa Inggris
        $hari = $this->convertHariToIndonesian($hariInggris); // Konversi ke bahasa Indonesia
        $jadwalMasuk = \App\Models\JadwalMasuk::where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hari)
            ->first();

        if (!$jadwalMasuk) {
            return response()->json(['message' => 'Jadwal tidak ditemukan.'], 404);
        }

        // Periksa apakah jam sekarang sudah melewati jam keluar dalam jadwal
        $jamKeluarJadwal = \Carbon\Carbon::parse($jadwalMasuk->jam_keluar); // Ambil waktu jam_keluar dari jadwal
        $jamSekarang = now(); // Ambil waktu sekarang

        if ($jamSekarang->greaterThan($jamKeluarJadwal)) {
            return response()->json(['message' => 'Waktu absen masuk sudah lewat karena Anda sudah melewati jam keluar.'], 400);
        }

        // Periksa apakah jam saat ini lebih dari jam masuk dalam jadwal
        $jamMasukSekarang = now(); // Ambil waktu sekarang
        $jamMasukJadwal = \Carbon\Carbon::parse($jadwalMasuk->jam_masuk); // Pastikan ini Carbon instance

        $status = 'hadir';
        $tepatWaktu = true;

        // Periksa apakah siswa terlambat
        if ($jamMasukSekarang->greaterThan($jamMasukJadwal)) {
            // $status = 'terlambat'; // Set status menjadi terlambat jika melebihi jam masuk
            $tepatWaktu = false;    // Set tepat_waktu menjadi false
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
        $imageName = $siswa->nisn . '_' . $tanggal . '_masuk.png';

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
        $presensi->jenis_presensi = 'harian';
        $presensi->status = $status; // Menyimpan status ('hadir' atau 'terlambat')
        $presensi->tepat_waktu = $tepatWaktu; // Set true jika tepat waktu, false jika terlambat
        $presensi->jam_masuk = $jamMasukSekarang;
        $presensi->lokasi_masuk = $request->lokasi;
        $presensi->foto_selfie_masuk = 'storage/selfies/' . $imageName; // Simpan path relatif ke file
        $presensi->jadwal_masuk_id = $jadwalMasuk->id;
        $presensi->save();

        // Kirim notifikasi berdasarkan status
        if ($tepatWaktu) {
            return response()->json(['message' => 'Presensi berhasil dicatat! Anda hadir tepat waktu.'], 200);
        } else {
            return response()->json(['message' => 'Presensi berhasil dicatat! Anda terlambat.'], 200);
        }
    }

    public function showKeluarForm()
    {
        // Ambil pengguna yang terautentikasi
        $user = Auth::user();

        // Pastikan pengguna adalah siswa
        if (!$user || !$user->siswa) {
            return response()->json(['message' => 'Siswa tidak ditemukan.'], 404);
        }

        // Dapatkan data siswa
        $siswa = $user->siswa;

        // Konversi nama hari ke bahasa Indonesia
        $hariInggris = now()->format('l'); // Mendapatkan nama hari dalam bahasa Inggris
        $hari = $this->convertHariToIndonesian($hariInggris); // Konversi ke bahasa Indonesia

        // Mengambil jadwal
        $jadwal = DB::table('tbl_jadwal_masuk')
            ->where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hari)
            ->first();

        return view('siswa.presensi.presensi-harian.keluar', compact('siswa', 'jadwal')); // Buat file baru untuk view absen keluar
    }

    public function storeKeluar(Request $request)
    {
        // Validasi request
        $request->validate([
            'image' => 'required|string',
            'lokasi' => 'required|string', // Format "latitude,longitude"
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
            ->where('jenis_presensi', 'harian')
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
        $jadwalMasuk = \App\Models\JadwalMasuk::where('kelas_id', $siswa->kelas_id)
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


    // Fungsi untuk menghitung jarak antara dua koordinat menggunakan rumus Haversine
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
