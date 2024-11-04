@extends('layouts.index')

@section('title', 'Laporan Harian')

@section('judulkonten', 'Laporan Harian')

@section('isikonten')
    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('laporan-harian.pdf') }}" class="btn btn-success btn-round me-3">
            <i class="fa fa-print"></i> Cetak Laporan
        </a>
    </div>
    <div class="table-responsive mt-4">
        <table id="tabel-data" class="table table-striped table-bordered">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Lokasi Masuk</th>
                    <th>Lokasi Keluar</th>
                    <th>Foto Selfie Masuk</th>
                    <th>Foto Selfie Keluar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presensiHarian as $index => $presensi)
                    <tr class="text-center">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $presensi->siswa->nama_siswa }}</td>
                        <td>{{ $presensi->siswa->kelas ? $presensi->siswa->kelas->nama_kelas : 'Kelas tidak ditemukan' }}</td>
                        <td>{{ $presensi->tanggal }}</td>
                        <td>{{ $presensi->status }}</td>
                        <td>{{ $presensi->jam_masuk }}</td>
                        <td>{{ $presensi->jam_keluar }}</td>
                        <td>{{ $presensi->lokasi_masuk }}</td>
                        <td>{{ $presensi->lokasi_keluar }}</td>
                        <td>{{ $presensi->foto_selfie_masuk }}</td>
                        <td>{{ $presensi->foto_selfie_keluar }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Tambahkan CSS DataTables dan Bootstrap -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://stack  path.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.min.js"></script>


    <!-- Tambahkan jQuery dan DataTables JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#tabel-data').DataTable({
                "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Semua"]
                ],
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Tidak ada entri yang tersedia",
                    "infoFiltered": "(disaring dari _MAX_ total entri)",
                    "search": "",
                    "searchPlaceholder": "Cari...",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });
    </script>
@endsection
