<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi Harian Kelas {{ $kelas->nama_kelas }}</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h3 style="text-align: center;">LAPORAN PRESENSI Kelas {{ $kelas->nama_kelas }}</h3>
    <h4 style="text-align: center;">Periode: {{ $periode }}</h4>
    <h3 style="text-align: center;">SMK NEGERI 1 CIMAHI</h3>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Jam Masuk</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswa as $index => $s)
                @php $presensiSiswa = $presensi[$s->id] ?? []; @endphp
                @foreach ($presensiSiswa as $absen)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $s->nama_siswa }}</td>
                        <td>{{ $s->nisn }}</td>
                        <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $absen->status }}</td>
                        <td>{{ $absen->jam_masuk ?? '-' }}</td>
                        <td>{{ $absen->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
