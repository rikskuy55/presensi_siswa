@extends('layouts.index')

@section('title', 'Data Kelas')

@section('judulkonten', 'Data Kelas')

@section('isikonten')
<div class="text-center">
    <h1>Daftar Kelas</h1>
</div>

<div class="d-flex justify-content-end mt-3">
    <a href="{{ route('data-kelas.create') }}" class="btn btn-success btn-round me-3">
        <i class="fa fa-plus"></i> Tambah Kelas
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

@if (session('error'))
    <script>
        Swal.fire({
            title: 'Gagal!',
            text: `{{ session('error') }}`,
            icon: 'error',
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
</style>

<div class="table-responsive mt-4">
    <table id="tabel-data" class="table table-striped table-bordered">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Nama Kelas</th>
                <th>Jurusan</th>
                <th>Wali Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kelass as $kelas)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $kelas->nama_kelas }}</td>
                    <td>{{ $kelas->jurusan }}</td>
                    <td>{{ $kelas->guruWaliKelas ? $kelas->guruWaliKelas->nama_guru : 'Tidak Ada' }}</td>
                    <td class="text-center">
                        <a href="{{ route('data-kelas.edit', $kelas->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('data-kelas.destroy', $kelas->id) }}" method="POST" class="d-inline form-hapus">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" data-bs-toggle="tooltip" title="Hapus Kelas">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </form>

                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#infoModal{{ $kelas->id }}">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </td>
                </tr>

                <!-- Modal untuk informasi kelas -->
                <div class="modal fade" id="infoModal{{ $kelas->id }}" tabindex="-1" aria-labelledby="infoModalLabel{{ $kelas->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg" style="position: fixed; top: 0; right: 10px; height: auto; width: 400px; margin: 0;">
                        <div class="modal-content" style="height: 100%; border-radius: 10px; overflow: hidden;">
                            <div class="modal-header bg-primary text-white">
                                <h3 class="modal-title" id="infoModalLabel{{ $kelas->id }}">Informasi Kelas</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <strong>Nama Kelas:</strong>
                                    <input type="text" class="form-control" value="{{ $kelas->nama_kelas }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <strong>Jurusan:</strong>
                                    <input type="text" class="form-control" value="{{ $kelas->jurusan }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <strong>Wali Kelas:</strong>
                                    <input type="text" class="form-control" value="{{ $kelas->guruWaliKelas ? $kelas->guruWaliKelas->nama_guru : 'Tidak Ada' }}" disabled>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
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

        $('.form-hapus').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'Data Kelas akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.off('submit').submit();
                }
            });
        });
    });
</script>
@endsection
