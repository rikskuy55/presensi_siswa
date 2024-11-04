@extends('layouts.index')

@section('title', 'Kelola Izin')

@section('judulkonten', 'Kelola Izin')

@section('isikonten')
    <h2 class="text-center mb-4">Daftar Izin Menunggu Persetujuan</h2>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if ($izins->isEmpty())
        <p class="text-center">Tidak ada izin yang menunggu persetujuan.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Tanggal Izin</th>
                        <th>Jenis Izin</th>
                        <th>Keterangan</th>
                        <th>Foto Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($izins as $izin)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $izin->siswa->nama_siswa }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d-m-Y') }}</td>
                            <td class="text-center">{{ ucfirst($izin->jenis_izin) }}</td>
                            <td>{{ $izin->keterangan }}</td>
                            <td class="text-center">
                                @if ($izin->foto_bukti)
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalFoto{{ $izin->id }}">
                                        <img src="{{ asset('storage/' . $izin->foto_bukti) }}" 
                                            alt="Foto Bukti" width="50px" class="img-thumbnail">
                                    </a>

                                    <div class="modal fade" id="modalFoto{{ $izin->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $izin->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLabel{{ $izin->id }}">Foto Bukti</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ asset('storage/' . $izin->foto_bukti) }}" 
                                                        alt="Foto Bukti" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Tidak ada bukti</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <form action="{{ route('izin.approve', $izin->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-check"></i> Approve
                                        </button>
                                    </form>
                            
                                    <form action="{{ route('izin.reject', $izin->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-times"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            </td>                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection

@push('scripts')
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
