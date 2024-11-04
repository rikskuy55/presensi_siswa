@extends('layouts.index')

@section('title', 'Data Guru')

@section('judulkonten', 'Data Guru')

@section('isikonten')
<div class="text-center">
    <h1>Daftar Guru</h1>
</div>

<div class="d-flex justify-content-end mt-3">
    <a href="{{ route('data-guru.create') }}" class="btn btn-success btn-round me-3">
        <i class="fa fa-plus"></i> Tambah Guru
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

@if (session('info'))
    <script>
        Swal.fire({
            title: 'Informasi',
            text: `{{ session('info') }}`,
            icon: 'info',
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
                <th>NIP</th>
                <th>Nama Guru</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Foto</th>
                <th>Spesialisasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gurus as $guru)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $guru->nip }}</td>
                    <td>{{ $guru->nama_guru }}</td>
                    <td>{{ $guru->jenis_kelamin }}</td>
                    <td>{{ \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d-m-Y') }}</td>
                    <td>{{ $guru->alamat }}</td>
                    <td class="text-center">
                        @if ($guru->foto)
                            <img src="{{ asset('storage/' . $guru->foto) }}" alt="Foto Guru" width="50" height="50">
                        @else
                            <span>Tidak ada foto</span>
                        @endif
                    </td>
                    <td>{{ $guru->spesialisasi }}</td>
                    <td class="text-center">
                        <a href="{{ route('data-guru.edit', $guru->id) }}" class="btn btn-primary">
                            <i class="fas fa-user-edit"></i>
                        </a>

                        <form action="{{ route('data-guru.destroy', $guru->id) }}" method="POST" class="d-inline form-hapus">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" data-bs-toggle="tooltip" title="Hapus Guru">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </form>

                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#infoModal{{ $guru->id }}">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </td>
                </tr>

                <!-- Modal untuk informasi guru -->
                <div class="modal fade" id="infoModal{{ $guru->id }}" tabindex="-1" aria-labelledby="infoModalLabel{{ $guru->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg" style="position: fixed; top: 0; right: 10px; height: auto; width: 400px; margin: 0;">
                        <div class="modal-content" style="height: 100%; border-radius: 10px; overflow: hidden;">
                            <div class="modal-header" style="background-color: #007bff; color: white;">
                                <h3 class="modal-title" id="infoModalLabel{{ $guru->id }}">Informasi Guru</h3>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-3">
                                    @if ($guru->foto)
                                        <img src="{{ asset('storage/' . $guru->foto) }}" alt="Foto Guru" class="img-fluid rounded-circle" width="150" height="150">
                                    @else
                                        <img src="{{ asset('assets/images/smkn1cmh.png') }}" alt="Default Image" class="img-fluid rounded-circle" width="150" height="150"/>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <strong>NIP</strong>
                                    <input type="text" class="form-control" value="{{ $guru->nip }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <strong>Nama Guru</strong>
                                    <input type="text" class="form-control" value="{{ $guru->nama_guru }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <strong>Jenis Kelamin</strong>
                                    <input type="text" class="form-control" value="{{ $guru->jenis_kelamin }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <strong>Tanggal Lahir</strong>
                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d-m-Y') }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <strong>Alamat</strong>
                                    <input type="text" class="form-control" value="{{ $guru->alamat }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <strong>Spesialisasi</strong>
                                    <input type="text" class="form-control" value="{{ $guru->spesialisasi }}" disabled>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
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
                text: 'Data Guru akan dihapus secara permanen!',
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

