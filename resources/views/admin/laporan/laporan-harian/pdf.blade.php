<!DOCTYPE html>
<html>
<head>
    <title>Laporan Harian</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Laporan Presensi Harian</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Lokasi</th>
                <th>Foto Selfie</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presensiHarian as $index => $presensi)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $presensi->siswa->nama_siswa }}</td>
                <td>{{ $presensi->tanggal }}</td>
                <td>{{ $presensi->jam_masuk }}</td>
                <td>{{ $presensi->jam_keluar }}</td>
                <td>{{ $presensi->lokasi }}</td>
                <td>{{ $presensi->foto_selfie }}</td>
                <td>{{ $presensi->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
