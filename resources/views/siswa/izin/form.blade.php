@extends('siswa.layouts.index')

@section('title', 'Absensi Siswa - Form Izin')

<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form Izin</div>
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

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row" style="margin-top: 70px; padding: 16px; margin-bottom: 70px;">
        <div class="col">
            <form action="{{ route('izin.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Input Tanggal Izin -->
                <div class="form-group mb-3">
                    <label for="tanggal_izin">Tanggal Izin</label>
                    <input type="text" class="form-control datepicker" id="tanggal_izin" 
                           name="tanggal_izin" placeholder="Tanggal Izin" required>
                </div>

                <!-- Dropdown Jenis Izin -->
                <div class="form-group mb-3">
                    <label for="jenis_izin">Jenis Izin</label>
                    <select class="form-control" id="jenis_izin" name="jenis_izin" required>
                        <option value="">Pilih Alasan</option>
                        <option value="sakit">Sakit</option>
                        <option value="izin">Izin</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- Textarea Keterangan -->
                <div class="form-group mb-3">
                    <label for="keterangan">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" class="form-control" 
                              placeholder="Berikan keterangan izin..." rows="4" required></textarea>
                </div>

                <!-- Upload Foto Bukti -->
                <div class="form-group mb-3">
                    <label for="foto_bukti">Foto Bukti (opsional)</label>
                    <input type="file" class="form-control" id="foto_bukti" name="foto_bukti" 
                           accept="image/*" onchange="validateFileSize()">
                    <small class="text-muted">Maksimal ukuran file: 2 MB</small>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-block">Ajukan Izin</button>
            </form>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(document).ready(function() {
            $(".datepicker").datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                todayHighlight: true,
            });
        });

        // Validasi ukuran file bukti
        function validateFileSize() {
            const input = document.getElementById('foto_bukti');
            const file = input.files[0];
            if (file && file.size > 2 * 1024 * 1024) { // 2 MB
                alert('Ukuran file terlalu besar! Maksimal 2 MB.');
                input.value = ''; // Reset input file
            }
        }
    </script>
@endpush
