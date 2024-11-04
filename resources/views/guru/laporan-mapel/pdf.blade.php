<!DOCTYPE html>
<html>
<head>
    <title>Laporan Presensi Mata Pelajaran</title>
    <style>
        /* Basic styling for the PDF */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h3 {
            margin: 5px 0;
        }
        .biodata-table, .presensi-table {
            margin-top: 10px;
            width: 100%;
        }
        .biodata-table th, .biodata-table td {
            border: none;
            padding: 4px;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <h3>LAPORAN PRESENSI MATA PELAJARAN</h3>
        <h3>SMK NEGERI 1 CIMAHI</h3>
        <p>Periode: Bulan {{ $namabulan[$bulan] }} Tahun {{ $tahun }}</p>
    </div>

    <!-- Biodata Section -->
    <table class="biodata-table">
        <tr>
            <th>NISN</th>
            <td>{{ $siswa->nisn }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $siswa->nama_siswa }}</td>
        </tr>
        <tr>
            <th>Kelas</th>
            <td>{{ $kelas->nama_kelas }}</td>
        </tr>
        <tr>
            <th>Mata Pelajaran</th>
            <td>{{ $mapel->nama_mata_pelajaran }}</td>
        </tr>
    </table>

    <!-- Tabel Presensi Section -->
    <table class="presensi-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Status Kehadiran</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Lokasi Masuk</th>
                <th>Lokasi Keluar</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($presensi as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ ucfirst($p->status) }}</td>
                    <td>{{ $p->jam_masuk ?? '-' }}</td>
                    <td>{{ $p->jam_keluar ?? '-' }}</td>
                    <td>{{ $p->lokasi_masuk ?? '-' }}</td>
                    <td>{{ $p->lokasi_keluar ?? '-' }}</td>
                    <td>
                        @if($p->status === 'hadir')
                            {{ $p->tepat_waktu ? 'Tepat Waktu' : 'Terlambat' }}
                        @elseif($p->status === 'izin' || $p->status === 'sakit')
                            Izin
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data presensi untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="text-align: right; margin-top: 40px;">
        <p>Cimahi, {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
        <p>Wali Kelas</p>
        <br><br><br>
        <p>{{ $kelas->waliKelas->nama_guru }}</p>
    </div>
</body>
</html>
