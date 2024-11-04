<!DOCTYPE html>
<html>
<head>
    <title>Laporan Presensi Siswa</title>
    <link rel="icon" href="{{ storage_path('app/public/selfies/smkn1cmh.png') }}" type="image/x-icon" />

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
        /* Layout container for photo and biodata */
        .layout-container {
            display: flex;
            align-items: flex-start; /* Align the items at the top */
            margin-bottom: 20px;
        }
        .photo-container {
            width: 20%; /* Photo takes 20% width */
            text-align: center;
            margin-right: 20px; /* Adds space between photo and biodata */
        }
        .corrected-photo {
            width: 150px;
            height: 120px;
            object-fit: cover;
            border: 1px solid black;
            transform: rotate(-90deg); /* Adjust if necessary */
        }
        .biodata-table {
            width: 75%; /* Biodata takes 75% width */
            border: none;
        }
        .biodata-table td {
            padding: 5px;
            border: none;
        }
        .biodata-label {
            width: 25%; /* Label width */
            font-weight: bold;
        }
        .biodata-value {
            width: 75%; /* Value width */
        }
    </style>
</head>
<body>
    <h3 style="text-align: center;">LAPORAN PRESENSI SISWA PERIODE BULAN {{ $namabulan[$bulan] }} TAHUN {{ $tahun }}</h3>
    <h3 style="text-align: center;">SMK NEGERI 1 CIMAHI</h3>

    <div class="layout-container">
        <table class="biodata-table">
            <tr>
                <td rowspan="8">
                    @if($siswa->foto)
                    <img src="{{ public_path('storage/' . $siswa->foto) }}" alt="Foto Siswa" class="corrected-photo">
                    @else
                        <p>Foto tidak tersedia</p>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="biodata-label">NISN</td>
                <td class="biodata-value">: {{ $siswa->nisn }}</td>
            </tr>
            <tr>
                <td class="biodata-label">Nama Lengkap</td>
                <td class="biodata-value">: {{ $siswa->nama_siswa }}</td>
            </tr>
            <tr>
                <td class="biodata-label">Kelas</td>
                <td class="biodata-value">: {{ $siswa->kelas->nama_kelas }}</td>
            </tr>
            <tr>
                <td class="biodata-label">Jenis Kelamin</td>
                <td class="biodata-value">: {{ $siswa->jenis_kelamin }}</td>
            </tr>
            <tr>
                <td class="biodata-label">Tanggal Lahir</td>
                <td class="biodata-value">: {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td class="biodata-label">Alamat</td>
                <td class="biodata-value">: {{ $siswa->alamat }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Tanggal</th>
                <th style="text-align: center;">Status Kehadiran</th>
                <th style="text-align: center;">Jam Masuk</th>
                <th style="text-align: center;">Lokasi Masuk</th>
                <th style="text-align: center;">Foto Masuk</th>
                <th style="text-align: center;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($presensi as $p)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td style="text-align: center;">{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                    <td style="text-align: center;">{{ $p->status }}</td>
                    <td style="text-align: center;">{{ $p->jam_masuk ?? '-' }}</td>
                    <td style="text-align: center;">{{ $p->lokasi_masuk ?? '-' }}</td>
                    <td style="text-align: center;">
                        @if($p->foto_selfie_masuk)
                            <img src="{{ public_path('' . $p->foto_selfie_masuk) }}" alt="Foto Masuk" width="50px" height="40px">
                        @else
                            -
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if($p->status === 'alpa')
                            -
                        @else
                            {{ $p->tepat_waktu ? 'Tepat Waktu' : 'Terlambat' }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data presensi untuk bulan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
