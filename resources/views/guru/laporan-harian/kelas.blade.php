@extends('layouts.index')

@section('title', 'Laporan Presensi Harian Kelas')

@section('judulkonten', 'Laporan Presensi Harian Kelas')

@section('isikonten')
<h4 class="display-6 text-center">Laporan Absensi Harian Kelas {{ $kelas->nama_kelas }}</h4>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('laporan-harian.kelas-print') }}" method="POST" target="_blank">
                        @csrf
                        <!-- Pilih Periode -->
                        <div class="form-group mb-3">
                            <label for="periode">Pilih Periode</label>
                            <select name="periode" id="periode" class="form-select">
                                <option value="">Pilih Periode</option>
                                <option value="per_tanggal">Per Tanggal</option>
                                <option value="rentang_tanggal">Rentang Tanggal</option>
                                <option value="per_bulan">Per Bulan</option>
                            </select>
                        </div>

                        <!-- Input Tanggal -->
                        <div class="form-group mb-3" id="tanggal-group" style="display: none;">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control">
                        </div>

                        <!-- Input Rentang Tanggal -->
                        <div class="form-group mb-3" id="rentang-group" style="display: none;">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control mb-2">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control">
                        </div>

                        <!-- Input Bulan dan Tahun -->
                        <div id="bulan-tahun-group" style="display: none;">
                            <div class="form-group mb-3">
                                <label for="bulan">Bulan</label>
                                <select name="bulan" id="bulan" class="form-select">
                                    <option value="">Pilih Bulan</option>
                                    @foreach ($namabulan as $index => $nama)
                                        @if($index > 0)
                                            <option value="{{ $index }}">{{ $nama }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tahun">Tahun</label>
                                <select name="tahun" id="tahun" class="form-select">
                                    <option value="">Pilih Tahun</option>
                                    @foreach ($tahun as $thn)
                                        <option value="{{ $thn }}">{{ $thn }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Tombol Cetak -->
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-print"></i> Cetak Laporan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#periode').on('change', function() {
            let selected = $(this).val();
            $('#tanggal-group, #rentang-group, #bulan-tahun-group').hide();

            if (selected === 'per_tanggal') {
                $('#tanggal-group').show();
            } else if (selected === 'rentang_tanggal') {
                $('#rentang-group').show();
            } else if (selected === 'per_bulan') {
                $('#bulan-tahun-group').show();
            }
        });
    });
</script>
@endsection
