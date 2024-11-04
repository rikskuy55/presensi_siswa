@extends('siswa.layouts.index')

@section('title', 'Edit Izin')

<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Edit Izin</div>
    <div class="right"></div>
</div>
<!-- * App Header -->

@section('content')
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

    <div class="row" style="margin-top: 70px; padding: 16px; margin-bottom: 70px;">
        <div class="col">
            <form action="{{ route('izin.update', $izin->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="text" class="form-control datepicker" name="tanggal_izin"
                                value="{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d/m/Y') }}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <select class="form-control" name="jenis_izin" required>
                                <option value="">Pilih Alasan</option>
                                <option value="sakit" {{ $izin->jenis_izin == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="izin" {{ $izin->jenis_izin == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="lainnya" {{ $izin->jenis_izin == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <textarea name="keterangan" class="form-control" placeholder="Keterangan" rows="4" required>{{ $izin->keterangan }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="file" class="form-control" name="foto_bukti">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Update Izin</button>
            </form>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        var currYear = (new Date()).getFullYear();

        $(document).ready(function() {
            $(".datepicker").datepicker({
                format: "dd/mm/yyyy"
            });
        });
    </script>
@endpush
