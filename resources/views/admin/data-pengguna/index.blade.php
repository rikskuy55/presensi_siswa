@extends('layouts.index')

@section('title', 'Data Pengguna')

@section('judulkonten', 'Data Pengguna')

@section('isikonten')
    <div class="text-center">
        <h1>Daftar Pengguna</h1>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('pengguna.create') }}" class="btn btn-success btn-round me-3">
            <i class="fa fa-plus"></i> Tambah Pengguna
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
        /* Ubah warna baris ganjil menjadi hitam */
        table.dataTable.stripe tbody tr.odd {
            background-color: #000 !important;
            /* Warna hitam */
            color: #fff;
            /* Warna teks putih */
        }

        /* Baris genap dengan abu-abu gelap */
        table.dataTable.stripe tbody tr.even {
            background-color: #333 !important;
            /* Warna abu-abu gelap */
            color: #fff;
            /* Warna teks putih */
        }

        /* Ubah warna header tabel */
        table thead th {
            background-color: #6fabf8 !important;
            color: #fff;
        }

        /* Menambahkan garis putih antar kolom */
        table.dataTable td,
        table.dataTable th {
            border: 1px solid #fff;
            /* Warna border putih */
        }

        /* Mengatur padding agar konten tabel terlihat lebih rapi */
        table.dataTable td,
        table.dataTable th {
            padding: 8px 12px;
        }
    </style>

    <style>
        /* Atur lebar kolom berdasarkan kebutuhan */
        .col-no {
            width: 5%;
            /* Misalnya, kolom No cukup kecil */
        }

        .col-nama {
            width: 10%;
            /* Kolom Nama lebih besar */
        }

        .col-username {
            width: 10%;
            /* Kolom Username lebih besar */
        }

        .col-email {
            width: 25%;
            /* Kolom Email lebih besar */
        }

        .col-role {
            width: 10%;
            /* Kolom Role */
        }

        .col-foto {
            width: 10%;
            /* Kolom Foto */
        }

        .col-aksi {
            width: 15%;
            /* Kolom Aksi cukup besar */
        }
    </style>

    <div class="table-responsive mt-4">
        <table id="tabel-data" class="table table-striped table-bordered">
            <thead>
                <tr class="text-center">
                    <th class="col-no">No</th>
                    <th class="col-nama">Nama</th>
                    <th class="col-username">Username</th>
                    <th class="col-email">Email</th>
                    <th class="col-role">Role</th>
                    <th class="col-foto">Foto</th>
                    <th class="col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center col-no">{{ $loop->iteration }}</td>
                        <td class="col-nama">{{ $user->name }}</td>
                        <td class="col-username">{{ $user->username }}</td>
                        <td class="col-email">{{ $user->email }}</td>
                        <td class="col-role">{{ $user->role }}</td>
                        <td class="text-center col-foto">
                            @if ($user->foto)
                                <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Pengguna" width="50"
                                    height="50">
                            @else
                                <span>Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="text-center col-aksi">
                            <a href="{{ route('pengguna.edit', $user->id) }}" class="btn btn-primary">
                                <i class="fas fa-user-edit"></i>
                            </a>

                            <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST"
                                class="d-inline form-hapus">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" data-bs-toggle="tooltip"
                                    title="Hapus Pengguna">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </form>

                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#infoModal{{ $user->id }}">
                                <i class="fas fa-info-circle"></i>
                            </button>

                        </td>
                    </tr>

                    <!-- Modal untuk informasi pengguna -->
                    <div class="modal fade" id="infoModal{{ $user->id }}" tabindex="-1"
                        aria-labelledby="infoModalLabel{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg"
                            style="position: fixed; top: 15%; right: 10px; height: auto; width: 400px; margin: 0;">
                            <div class="modal-content" style="height: 100%; border-radius: 10px; overflow: hidden;">
                                <div class="modal-header" style="background-color: #007bff; color: white;">
                                    <div class="w-100 text-center">
                                        <h3 class="modal-title" id="infoModalLabel{{ $user->id }}">Informasi Pengguna
                                        </h3>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="padding: 20px;">
                                    <div class="text-center mb-3">
                                        @if ($user->foto)
                                            <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Pengguna"
                                                class="img-fluid rounded-circle" width="150" height="150">
                                        @else
                                            <img src="{{ asset('assets/images/smkn1cmh.png') }}" alt="Default Image"
                                                class="img-fluid rounded-circle" width="150" height="150" />
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <strong>Nama</strong>
                                        <input type="text" class="form-control" id="username" name="username"
                                            value="{{ $user->name }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Username</strong>
                                        <input type="text" class="form-control" id="username" name="username"
                                            value="{{ $user->username }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Email</strong>
                                        <input type="text" class="form-control" id="username" name="username"
                                            value="{{ $user->email }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Role</strong>
                                        <input type="text" class="form-control" id="username" name="username"
                                            value="{{ $user->role }}" disabled>
                                    </div>
                                </div>
                                <div class="modal-footer" style="border-top: none;">
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

            // Konfirmasi penghapusan data pengguna
            $('.btn-hapus').on('submit', function() {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: 'Data Pengguna akan dihapus secara permanen!',
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
