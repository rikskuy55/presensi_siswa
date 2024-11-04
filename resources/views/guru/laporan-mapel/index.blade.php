@extends('layouts.index')

@section('title', 'Laporan Presensi Mata Pelajaran')

@section('judulkonten', 'Laporan Presensi Mata Pelajaran')

@section('isikonten')
<h4 class="display-6 text-center">Laporan Absensi Mata Pelajaran</h4>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <!-- Dropdown Kelas -->
                    <div class="form-group mb-2">
                        <label for="kelas">Kelas</label>
                        <select name="kelas" id="kelas" class="form-select">
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dropdown Bulan -->
                    <div class="form-group mb-2">
                        <label for="bulan">Bulan</label>
                        <select name="bulan" id="bulan" class="form-select">
                            <option value="">Pilih Bulan</option>
                            @foreach ($namabulan as $index => $nama)
                                <option value="{{ $index }}">{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dropdown Tahun -->
                    <div class="form-group mb-2">
                        <label for="tahun">Tahun</label>
                        <select name="tahun" id="tahun" class="form-select">
                            <option value="">Pilih Tahun</option>
                            @foreach ($tahun as $thn)
                                <option value="{{ $thn }}">{{ $thn }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dropdown Siswa -->
                    <div class="form-group mb-2">
                        <label for="nisn">Pilih Siswa</label>
                        <select name="nisn" id="nisn" class="form-select">
                            <option value="">Pilih Siswa</option>
                            <!-- Options siswa akan ditampilkan berdasarkan kelas yang dipilih -->
                        </select>
                    </div>

                    <!-- Dropdown Mata Pelajaran -->
                    <div class="form-group mb-2">
                        <label for="mapel">Mata Pelajaran</label>
                        <select name="mapel" id="mapel" class="form-select">
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach ($mapel as $m)
                                <option value="{{ $m->id }}">{{ $m->nama_mata_pelajaran }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tombol Cetak -->
                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-end">
                            <form action="{{ route('laporan-mapel.print-pdf') }}" method="POST" target="_blank">
                                @csrf
                                <input type="hidden" id="hidden-bulan" name="bulan">
                                <input type="hidden" id="hidden-tahun" name="tahun">
                                <input type="hidden" id="hidden-nisn" name="nisn">
                                <input type="hidden" id="hidden-kelas" name="kelas_id">
                                <input type="hidden" id="hidden-mapel" name="mapel_id">
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

<script>
    $(document).ready(function() {
        $('#kelas').on('change', function() {
            const kelasId = $(this).val();
            if (kelasId) {
                // Fetch siswa berdasarkan kelas yang dipilih (sesuaikan dengan endpoint yang ada)
                $.get(`/kelas/${kelasId}/siswa`, function(data) {
                    let options = '<option value="">Pilih Siswa</option>';
                    data.forEach(function(siswa) {
                        options += `<option value="${siswa.nisn}">${siswa.nama_siswa}</option>`;
                    });
                    $('#nisn').html(options);
                });
            }
        });

        // Update hidden inputs
        $('#bulan, #tahun, #nisn, #kelas, #mapel').on('change', function() {
            $(`#hidden-${this.id}`).val($(this).val());
        });
    });
</script>
@endsection
