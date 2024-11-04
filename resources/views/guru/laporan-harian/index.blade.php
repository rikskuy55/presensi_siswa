@extends('layouts.index')

@section('title', 'Laporan Presensi')

@section('judulkonten', 'Laporan Presensi')

@section('isikonten')
<h4 class="display-6 display-md-5 display-lg-4 text-center"> 
    Laporan Absensi Siswa Kelas {{ $kelas->nama_kelas ?? 'Tidak Ditemukan' }}
</h4>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <!-- Dropdown Bulan -->
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <select name="bulan" id="bulan" class="form-select">
                                    <option value="">Bulan</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ date("m") == $i ? 'selected' : '' }}>
                                            {{ $namabulan[$i] }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown Tahun -->
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <select name="tahun" id="tahun" class="form-select">
                                    <option value="">Tahun</option>
                                    @foreach ($tahun as $thn)
                                        <option value="{{ $thn }}" {{ date('Y') == $thn ? 'selected' : '' }}>
                                            {{ $thn }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Dropdown Siswa -->
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="nisn">Pilih Siswa</label>
                                <select name="nisn" id="nisn" class="form-select">
                                    <option value="">Pilih Siswa</option>
                                    @foreach ($siswa as $s)
                                        <option value="{{ $s->nisn }}">{{ $s->nama_siswa }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Cetak -->
                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-end">
                            <div class="col-12 col-sm-8 col-md-6">
                                <form action="{{ route('laporan-harian.print-pdf') }}" method="POST" target="_blank">
                                    @csrf
                                    <input type="hidden" id="hidden-bulan" name="bulan">
                                    <input type="hidden" id="hidden-tahun" name="tahun">
                                    <input type="hidden" id="hidden-nisn" name="nisn">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fa fa-print"></i> Cetak
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and Select2 JS & CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 for siswa dropdown
        $('#nisn').select2({
            placeholder: 'Pilih Siswa',
            allowClear: true,
            width: '100%'  // Ensure Select2 adapts to container width
        });

        // Update hidden inputs when dropdowns change
        $('#bulan').on('change', function() {
            $('#hidden-bulan').val($(this).val());
        });

        $('#tahun').on('change', function() {
            $('#hidden-tahun').val($(this).val());
        });

        $('#nisn').on('change', function() {
            $('#hidden-nisn').val($(this).val());
        });

        // Set initial values when page loads
        $('#hidden-bulan').val($('#bulan').val());
        $('#hidden-tahun').val($('#tahun').val());
        $('#hidden-nisn').val($('#nisn').val());
    });
</script>
@endsection
