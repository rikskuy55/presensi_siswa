@extends('layouts.index')

@section('title', 'Jadwal Masuk Sekolah')

@section('judulkonten', 'Data Jadwal Masuk Sekolah')

@section('isikonten')
<div class="text-center">
    <h1>Daftar Jadwal Masuk Sekolah</h1>
</div>

    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('jadwal-masuk.create') }}" class="btn btn-success btn-round me-3">
            <i class="fa fa-plus"></i> Tambah Jadwal
        </a>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: `{{ session('success') }}`,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <style>
        table.dataTable.stripe tbody tr.odd {
            background-color: #000 !important;
            color: #fff;
        }
    
        table.dataTable.stripe tbody tr.even {
            background-color: #333 !important;
            color: #fff;
        }
    
        table thead th {
            background-color: #6fabf8 !important;
            color: #fff;
        }
    
        table.dataTable td,
        table.dataTable th {
            border: 1px solid #fff;
            padding: 8px 12px;
        }
    </style>

    <div class="table-responsive mt-4">
        <table id="tabel-data" class="table table-striped table-bordered">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Hari</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwalMasuks as $jadwalMasuk)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $jadwalMasuk->kelas ? $jadwalMasuk->kelas->nama_kelas : 'Kelas tidak ditemukan' }}</td>
                        <td>{{ $jadwalMasuk->hari }}</td>
                        <td>{{ $jadwalMasuk->jam_masuk }}</td>
                        <td>{{ $jadwalMasuk->jam_keluar }}</td>
                        <td class="text-center">
                            <a href="{{ route('jadwal-masuk.edit', $jadwalMasuk->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('jadwal-masuk.destroy', $jadwalMasuk->id) }}" method="POST"
                                class="d-inline form-hapus">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    <!-- Tambahkan CSS DataTables dan Bootstrap -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">
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

            // Script untuk menghapus data pengguna dengan AJAX
            $('.form-hapus').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action'); // Ambil URL form

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: 'Jadwal Masuk Sekolah akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: form.serialize(), // Kirim data dari form
                            success: function(response) {
                                // Hapus baris dari DataTable
                                table.row(form.parents('tr')).remove().draw();

                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat menghapus jadwal.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
