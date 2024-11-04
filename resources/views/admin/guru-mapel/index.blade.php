@extends('layouts.index')

@section('title', 'Guru Mapel')

@section('judulkonten', 'Data Guru Mapel')

@section('isikonten')
    <div class="text-center">
        <h1>Daftar Guru Mapel</h1>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('guru-mapel.create') }}" class="btn btn-success btn-round me-3">
            <i class="fa fa-plus"></i> Tambah Guru Mapel
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
                    <th>Guru</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($guruMapels as $guruMapel)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $guruMapel->guru ? $guruMapel->guru->nama_guru : 'N/A' }}</td>
                        <td>{{ $guruMapel->mataPelajaran ? $guruMapel->mataPelajaran->nama_mata_pelajaran : 'N/A' }}</td>
                        <td>{{ $guruMapel->kelas ? $guruMapel->kelas->nama_kelas : 'N/A' }}</td>
                        <td class="text-center">
                            <a href="{{ route('guru-mapel.edit', $guruMapel->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('guru-mapel.destroy', $guruMapel->id) }}" method="POST"
                                class="d-inline form-hapus">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>

                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#infoModal{{ $guruMapel->id }}">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </td>
                    </tr>


                    <!-- Modal untuk informasi guru mapel -->
                    <div class="modal fade" id="infoModal{{ $guruMapel->id }}" tabindex="-1"
                        aria-labelledby="infoModalLabel{{ $guruMapel->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg"
                            style="position: fixed; top: 0; right: 10px; height: auto; width: 400px; margin: 0;">
                            <div class="modal-content" style="height: 100%; border-radius: 10px; overflow: hidden;">
                                <div class="modal-header" style="background-color: #007bff; color: white;">
                                    <h3 class="modal-title" id="infoModalLabel{{ $guruMapel->id }}">Informasi Guru Mapel
                                    </h3>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <strong>Nama Guru</strong>
                                        <input type="text" class="form-control"
                                            value="{{ $guruMapel->guru->nama_guru }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Mata Pelajaran</strong>
                                        <input type="text" class="form-control"
                                            value="{{ $guruMapel->mataPelajaran ? $guruMapel->mataPelajaran->nama_mata_pelajaran : 'N/A' }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Kelas</strong>
                                        <input type="text" class="form-control"
                                            value="{{ $guruMapel->kelas->nama_kelas }}" disabled>
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
                    text: 'Data Guru Mapel akan dihapus secara permanen!',
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
