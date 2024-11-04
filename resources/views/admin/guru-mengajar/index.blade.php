@extends('layouts.index')

@section('title', 'Data Siswa')

@section('judulkonten', 'Data Siswa')

@section('isikonten')
<div class="text-center">
    <h1>Daftar Siswa</h1>
</div>

<div class="d-flex justify-content-end mt-3">
    <a href="{{ route('data-siswa.create') }}" class="btn btn-success btn-round me-3">
        <i class="fa fa-plus"></i> Tambah Siswa
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
                <th>NISN</th>
                <th>Nama Siswa</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Kelas</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswas as $siswa)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $siswa->nisn }}</td>
                    <td>{{ $siswa->nama_siswa }}</td>
                    <td>{{ $siswa->jenis_kelamin }}</td>
                    <td>{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') }}</td>
                    <td>{{ $siswa->alamat }}</td>
                    <td>{{ $siswa->kelas->nama_kelas ?? 'Tidak ada kelas' }}</td>
                    <td class="text-center">
                        @if ($siswa->foto)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto Siswa" width="50">
                        @else
                            <span>Tidak ada foto</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('data-siswa.edit', $siswa->id) }}" class="btn btn-primary">
                            <i class="fas fa-user-edit"></i>
                        </a>

                        <form action="{{ route('data-siswa.destroy', $siswa->id) }}" method="POST" class="d-inline form-hapus">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" data-bs-toggle="tooltip" title="Hapus Siswa">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </form>

                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#infoModal{{ $siswa->id }}">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </td>
                </tr>

                <!-- Modal untuk informasi siswa -->
                <div class="modal fade" id="infoModal{{ $siswa->id }}" tabindex="-1" aria-labelledby="infoModalLabel{{ $siswa->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #007bff; color: white;">
                                <h3 class="modal-title" id="infoModalLabel{{ $siswa->id }}">Informasi Siswa</h3>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-3">
                                    @if ($siswa->foto)
                                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto Siswa" class="img-fluid rounded-circle" width="150" height="150">
                                    @else
                                    <img src="{{ asset('assets/images/smkn1cmh.png') }}" alt="Default Image" class="img-fluid rounded-circle" width="150" height="150"/>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <strong>NISN</strong>
                                    <input type="text" class="form-control" value="{{ $siswa->nisn }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <strong>Nama Siswa</strong>
                                    <input type="text" class="form-control" value="{{ $siswa->nama_siswa }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <strong>Jenis Kelamin</strong>
                                    <input type="text" class="form-control" value="{{ $siswa->jenis_kelamin }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <strong>Tanggal Lahir</strong>
                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <strong>Alamat</strong>
                                    <input type="text" class="form-control" value="{{ $siswa->alamat }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <strong>Kelas</strong>
                                    <input type="text" class="form-control" value="{{ $siswa->kelas->nama_kelas ?? 'Tidak ada kelas' }}" disabled>
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
                "info": "Menampilkan _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada entri yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total entri)",
                "search": "Pencarian:",
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
            const form = this;
            Swal.fire({
                title: 'Anda yakin?',
                text: "Data ini akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
