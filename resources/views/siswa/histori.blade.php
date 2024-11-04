@extends('siswa.layouts.index')

@section('title', 'Absensi Siswa - Histori')

<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Histori Presensi Siswa</div>
    <div class="right"></div>
</div>
<!-- * App Header -->

@section('content')
    <div class="container" style="margin-top: 70px; padding: 16px; margin-bottom: 70px;">
        <div class="col">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="">Bulan</option>
                            @foreach ($namabulan as $key => $value)
                                <option value="{{ $key }}" {{ date('m') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="">Tahun</option>
                            @for ($tahun = $tahunmulai; $tahun <= $tahunsekarang; $tahun++)
                                <option value="{{ $tahun }}" {{ date('Y') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" id="getdata">
                            <ion-icon name="search-outline"></ion-icon> Search
                        </button>
                    </div>
                </div>
            </div>
            <div class="row mt-3" id="result">
                <!-- Hasil pencarian presensi akan muncul di sini -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="presensi-table" style="display: none;">
                        <thead>
                            <tr class="text-center">
                                <th>Tanggal</th>
                                <th>Jenis Presensi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <p class="text-center" id="no-data" style="display: none;">Tidak ada data presensi untuk bulan dan tahun yang dipilih.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
<script>
    $(document).ready(function() {
        $("#getdata").click(function() {
            var bulan = $("#bulan").val();
            var tahun = $("#tahun").val();

            if (!bulan || !tahun) {
                alert('Silakan pilih bulan dan tahun.');
                return;
            }

            $.ajax({
                url: "{{ route('histori.get') }}",
                method: "GET",
                data: { bulan: bulan, tahun: tahun },
                dataType: "json", // Pastikan ini untuk menangani response JSON
                success: function(response) {
                    if (response.length > 0) {
                        renderTable(response);
                    } else {
                        showNoDataMessage();
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText); // Log error untuk debugging
                    alert('Terjadi kesalahan, coba lagi.');
                }
            });
        });

        function renderTable(data) {
            var tableBody = $("#presensi-table tbody");
            tableBody.empty(); // Hapus data sebelumnya

            data.forEach(function(item) {
                var row = `<tr>
                    <td>${new Date(item.tanggal).toLocaleDateString('id-ID')}</td>
                    <td>${item.jenis_presensi.charAt(0).toUpperCase() + item.jenis_presensi.slice(1)}</td>
                    <td>${item.status.charAt(0).toUpperCase() + item.status.slice(1)}</td>
                </tr>`;
                tableBody.append(row);
            });

            $("#no-data").hide();
            $("#presensi-table").show();
        }

        function showNoDataMessage() {
            $("#presensi-table").hide();
            $("#no-data").show();
        }
    });
</script>

@endpush
