@extends('siswa.layouts.index')

@section('title', 'Absensi Siswa - Izin')

<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Data Izin</div>
    <div class="right"></div>
</div>
<!-- * App Header -->

@section('content')

<div class="fab-button bottom-right" style="margin-bottom: 70px">
    <a href="{{ url('form-izin') }}" class="fab">
        <ion-icon name="add-outline"></ion-icon>
    </a>
</div>

<div class="container" style="margin-top: 75px">
    @if($izins->isEmpty())
        <div class="alert alert-info">Belum ada izin yang diajukan.</div>
    @else
    <div class="table-responsive mt-4">
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="text-center">
                    <th>Tanggal Izin</th>
                    <th>Jenis Izin</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($izins as $izin)
                <tr class="text-center">
                    <td class="text-center">{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d-m-Y') }}</td>
                    <td class="text-center">{{ ucfirst($izin->jenis_izin) }}</td>
                    <td class="text-center">{{ $izin->keterangan }}</td>
                    <td class="text-center">
                        @if($izin->status == 'disetujui')
                            <span class="badge bg-success" style="color: white">Disetujui</span>
                        @elseif($izin->status == 'ditolak')
                            <span class="badge bg-danger" style="color: white">Ditolak</span>
                        @else
                            <span class="badge bg-warning" style="color: white">Menunggu</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($izin->status == 'menunggu')
                            <!-- Tombol Edit -->
                            <a href="{{ route('izin.edit', $izin->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <!-- Tombol Hapus -->
                            <form action="{{ route('izin.destroy', $izin->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus izin ini?')">Hapus</button>
                            </form>
                        @else
                            <span class="text-muted">Tidak dapat diubah</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

@endsection
