@extends('layouts.index')

@section('title', 'Monitoring Presensi')

@section('judulkonten', 'Monitoring Presensi')

@section('isikonten')
    <h4>Monitoring Presensi Kelas {{ $kelas->nama_kelas ?? 'Tidak Ditemukan' }}</h4>

    <div class="d-flex justify-content-between mt-3">
        <div class="input-icon mb-3 position-relative">
            <span class="input-icon-addon" id="calendar-icon" style="cursor: pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icon-tabler-calendar-event">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 5a 2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                    <path d="M16 3v4" />
                    <path d="M8 3v4" />
                    <path d="M4 11h16" />
                    <path d="M8 15h2v2h-2z" />
                </svg>
            </span>
            <input type="text" id="tanggal" name="tanggal" class="form-control" placeholder=" Pilih Tanggal Presensi"
                autocomplete="off">
        </div>

        <!-- Search Box -->
        <div class="input-icon mb-3 position-relative">
            <input type="text" id="search-box" class="form-control" placeholder="Cari Nama atau NISN">
        </div>

        <div class="d-flex justify-content-end mt-3">
            <a href="#" class="btn btn-success btn-round me-3">
                <i class="fa fa-print"></i> Cetak Laporan
            </a>
        </div>
    </div>
    <br>

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
                <!-- Data akan dimuat melalui AJAX -->
            </tbody>
        </table>
    </div>

    <style>
        .table th,
        .table td {
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
        // Fungsi untuk memformat tanggal menjadi dd-mm-YYYY
        function formatDate(dateStr) {
            const date = new Date(dateStr);
            const day = String(date.getDate()).padStart(2, '0'); // Pad leading zero
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Pad leading zero (Bulan dimulai dari 0)
            const year = date.getFullYear();
            return `${day}-${month}-${year}`; // Format dd-mm-YYYY
        }

        document.addEventListener("DOMContentLoaded", function() {
            flatpickr.localize(flatpickr.l10ns.id);
            flatpickr("#tanggal", {
                locale: "id",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "l, d-m-Y",
                allowInput: true,
                onChange: function(selectedDates, dateStr) {
                    loadAttendanceData(dateStr, $('#search-box').val());
                }
            });

            // Event on search box input change
            $('#search-box').on('input', function() {
                loadAttendanceData($('#tanggal').val(), $(this).val());
            });
        });

        function loadAttendanceData(date, query = '') {
            $.ajax({
                url: "{{ route('get.daily.attendance') }}",
                type: "POST",
                data: {
                    tanggal: date,
                    search: query,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $("#loadpresensi").empty();

                    if (response.length > 0) {
                        $.each(response, function(index, presensi) {
                            let formattedDate = formatDate(presensi.tanggal); // Format tanggal

                            let jamMasukContent = presensi.jam_masuk !== '-' ?
                                `<span class="absen-sudah">${presensi.jam_masuk}</span>` :
                                `<span class="absen-belum">-</span>`;
                            let fotoMasukContent = presensi.foto_selfie_masuk ?
                                `<img src="{{ asset('') }}${presensi.foto_selfie_masuk}" alt="Foto Masuk" width="50">` :
                                '-';
                            let lokasiMasukContent = presensi.lokasi_masuk || '-';

                            let row = `
                        <tr class="text-center">
                            <td>${index + 1}</td>
                            <td>${formattedDate}</td>
                            <td>${presensi.nisn}</td>
                            <td>${presensi.nama_siswa}</td>
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
                }
            });
        }
    </script>
@endsection
