@extends('layouts.index')

@section('title', 'Monitoring Presensi')

@section('judulkonten', 'Monitoring Presensi Pelajaran')

@section('isikonten')
    <h4>Monitoring Presensi Pelajaran</h4>

    <div class="row mt-3">
        <!-- Dropdown for selecting class -->
        <div class="col-md-3 mb-3">
            <label for="kelas_id">Pilih Kelas</label>
            <select id="kelas_id" name="kelas_id" class="form-control" required>
                <option value="" disabled selected>Pilih Kelas</option>
                @foreach ($kelas->unique('id') as $kelasItem)
                    <option value="{{ $kelasItem->id }}">{{ $kelasItem->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        <!-- Dropdown for selecting subject -->
        <div class="col-md-3 mb-3">
            <label for="mapel_id">Pilih Mata Pelajaran</label>
            <select id="mapel_id" name="mapel_id" class="form-control" required>
                <option value="" disabled selected>Pilih Mata Pelajaran</option>
            </select>
        </div>

        <!-- Date Picker -->
        <div class="col-md-3 mb-3">
            <label for="tanggal">Pilih Tanggal Presensi</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fa fa-calendar"></i>
                </span>
                <input type="text" id="tanggal" name="tanggal" class="form-control" placeholder="Pilih Tanggal" autocomplete="off">
            </div>
        </div>

        <!-- Search Box -->
        <div class="col-md-3 mb-3">
            <label for="search-box">Cari Nama atau NISN</label>
            <input type="text" id="search-box" class="form-control" placeholder="Cari Nama atau NISN">
        </div>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <a href="#" class="btn btn-success btn-round">
            <i class="fa fa-print"></i> Cetak Laporan
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr class="text-center">
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Status Kehadiran</th>
                    <th>Jam Masuk</th>
                    <th>Lokasi Masuk</th>
                    <th>Foto Masuk</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody id="loadpresensi">
                <!-- Data will be loaded here via AJAX -->
            </tbody>
        </table>
    </div>

    <style>
        .table th, .table td {
            padding: 12px;
            vertical-align: middle;
        }

        .absen-belum {
            background-color: #ffcccc;
            color: #ff0000;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .absen-sudah {
            background-color: #ccffcc;
            color: #008000;
            padding: 2px 6px;
            border-radius: 4px;
        }
    </style>

    {{-- Include Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/l10n/id.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr.localize(flatpickr.l10ns.id);
            flatpickr("#tanggal", {
                locale: "id",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "l, d-m-Y",
                allowInput: true,
                onChange: function(selectedDates, dateStr) {
                    const kelasId = $('#kelas_id').val();
                    const mapelId = $('#mapel_id').val();
                    if (kelasId && mapelId && dateStr) {
                        loadAttendanceData(dateStr, '', kelasId, mapelId);
                    }
                }
            });

            // Trigger on search box input to filter displayed data
            $('#search-box').on('input', function() {
                const searchQuery = $(this).val().toLowerCase();
                filterBySearch(searchQuery);
            });

            // Populate subjects dropdown on class selection
            $('#kelas_id').on('change', function() {
                const kelasId = $(this).val();
                $('#mapel_id').empty().append('<option value="" disabled selected>Pilih Mata Pelajaran</option>');

                if (kelasId) {
                    $.ajax({
                        url: '/get-mata-pelajaran',
                        type: 'GET',
                        data: { kelas_id: kelasId },
                        success: function(data) {
                            $.each(data, function(index, mapel) {
                                $('#mapel_id').append(`<option value="${mapel.mata_pelajaran_id}">${mapel.nama_mata_pelajaran}</option>`);
                            });
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            alert('Gagal mengambil data mata pelajaran.');
                        }
                    });
                }
            });

            $('#mapel_id').on('change', function() {
                const date = $('#tanggal').val();
                const kelasId = $('#kelas_id').val();
                const mapelId = $(this).val();
                if (kelasId && mapelId && date) {
                    loadAttendanceData(date, '', kelasId, mapelId);
                }
            });
        });

        function loadAttendanceData(date, query = '', kelas_id = '', mapel_id = '') {
            if (!kelas_id || !date || !mapel_id) return;

            $.ajax({
                url: "{{ route('get.subject.attendance') }}",
                type: "POST",
                data: {
                    tanggal: date,
                    search: query,
                    kelas_id: kelas_id,
                    mapel_id: mapel_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $("#loadpresensi").empty();
                    if (response.length > 0) {
                        $.each(response, function(index, presensi) {
                            let formattedDate = formatDate(presensi.tanggal);
                            let jamMasukContent = presensi.jam_masuk !== '-' ? 
                                `<span class="absen-sudah">${presensi.jam_masuk}</span>` : 
                                `<span class="absen-belum">-</span>`;
                            let fotoMasukContent = presensi.foto_selfie_masuk ? 
                                `<img src="{{ asset('') }}${presensi.foto_selfie_masuk}" alt="Foto Masuk" width="50">` : 
                                '-';
                            let lokasiMasukContent = presensi.lokasi_masuk || '-';
                            
                            let row = `
                                <tr class="text-center presensi-row">
                                    <td>${index + 1}</td>
                                    <td>${formattedDate}</td>
                                    <td class="nisn">${presensi.nisn}</td>
                                    <td class="nama">${presensi.nama_siswa}</td>
                                    <td>${presensi.status}</td>
                                    <td>${jamMasukContent}</td>
                                    <td>${lokasiMasukContent}</td>
                                    <td>${fotoMasukContent}</td>
                                    <td>${presensi.keterangan}</td>
                                </tr>`;
                            $("#loadpresensi").append(row);
                        });
                    } else {
                        $("#loadpresensi").append(
                            `<tr><td colspan="9" class="text-center">Tidak ada data untuk tanggal yang dipilih.</td></tr>`
                        );
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert("Gagal memuat data presensi. Pastikan semua pilihan diisi dengan benar.");
                }
            });
        }

        // Function to filter rows by Nama or NISN
        function filterBySearch(query) {
            $('#loadpresensi .presensi-row').each(function() {
                const nama = $(this).find('.nama').text().toLowerCase();
                const nisn = $(this).find('.nisn').text().toLowerCase();
                if (nama.includes(query) || nisn.includes(query)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Format date to dd-mm-YYYY
        function formatDate(dateStr) {
            if (!dateStr || dateStr === '-') return '-';
            
            const date = new Date(dateStr);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }
    </script>
@endsection
