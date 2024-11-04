@extends('layouts.index')

@section('title', 'Data Mata Pelajaran')

@section('judulkonten', 'Data Mata Pelajaran')

@section('isikonten')
    <div class="text-center">
        <h1>Daftar Mata Pelajaran</h1>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('mapel.create') }}" class="btn btn-success btn-round me-3">
            <i class="fa fa-plus"></i> Tambah Mata Pelajaran
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

        table.dataTable td, table.dataTable th {
            border: 1px solid #fff;
            padding: 8px 12px;
        }

        .col-no {
            width: 5%;
        }

        .col-nama {
            width: 20%;
        }

        .col-aksi {
            width: 15%;
        }
    </style>

    <div class="table-responsive mt-4">
        <table id="tabel-data" class="table table-striped table-bordered">
            <thead>
                <tr class="text-center">
                    <th class="col-no">No</th>
                    <th class="col-nama">Nama Mata Pelajaran</th>
                    <th class="col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mapel as $m)
                    <tr>
                        <td class="text-center col-no">{{ $loop->iteration }}</td>
                        <td class="col-nama">{{ $m->nama_mata_pelajaran }}</td> <!-- Ganti dari nama_mapel menjadi nama_mata_pelajaran -->
                        <td class="text-center col-aksi">
                            <a href="{{ route('mapel.edit', $m->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
            
                            <form action="{{ route('mapel.destroy', $m->id) }}" method="POST" class="d-inline form-hapus">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" data-bs-toggle="tooltip" title="Hapus Mata Pelajaran">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </form>
            
                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#infoModal{{ $m->id }}">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </td>
                    </tr>
            
                    <!-- Modal untuk informasi mata pelajaran -->
                    <div class="modal fade" id="infoModal{{ $m->id }}" tabindex="-1" aria-labelledby="infoModalLabel{{ $m->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg" style="position: fixed; top: 0; right: 10px; height: auto; width: 400px; margin: 0;">
                            <div class="modal-content" style="height: 100%; border-radius: 10px; overflow: hidden;">
                                <div class="modal-header" style="background-color: #007bff; color: white;">
                                    <div class="w-100 text-center">
                                        <h3 class="modal-title" id="infoModalLabel{{ $m->id }}">Informasi Mata Pelajaran</h3>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="padding: 20px;">
                                    <div class="mb-3">
                                        <strong>Nama Mata Pelajaran</strong>
                                        <input type="text" class="form-control" value="{{ $m->nama_mata_pelajaran }}" disabled>
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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.min.js"></script>

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
                    text: 'Mata pelajaran ini akan dihapus secara permanen!',
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
                            data: form.serialize(),
                            success: function(response) {
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
                                    text: 'Terjadi kesalahan saat menghapus mata pelajaran.',
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
