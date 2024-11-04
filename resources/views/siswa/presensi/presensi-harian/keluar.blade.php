@extends('siswa.layouts.index')

@section('title', 'Absensi Harian - Pulang')

<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Absen Pulang</div>
    <div class="right"></div>
</div>
<!-- * App Header -->

@section('content')

    <div class="container mt-5">
        <div class="row" style="margin-top: 70px; padding: 16px;">
            <div class="col text-center">
                <div id="currentDateTime" class="alert"
                    style="background-color: #00bcd4; color: white; font-size: 16px; font-weight: bold; border-radius: 5px; padding: 10px;">
                    <!-- Tanggal, Hari, Jam -->
                </div>
                @if ($jadwal)
                    <div class="alert alert-warning">
                        <ion-icon name="time-outline" style="font-size: 20px;"></ion-icon>
                        <span style="color: black; font-size: 16px;">
                            Jam keluar: <strong>{{ $jadwal->jam_keluar }}</strong><br>
                            Pastikan Anda absen pulang sebelum waktu ini. Keterlambatan akan tercatat.
                        </span>
                    </div>
                @else
                    <div class="alert alert-danger">
                        <ion-icon name="alert-circle-outline" style="font-size: 20px;"></ion-icon>
                        <span style="color: black; font-size: 16px;">
                            Jadwal tidak ditemukan untuk hari ini.<br>
                            Harap hubungi pihak sekolah untuk informasi lebih lanjut.
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <input type="hidden" id="lokasi">

        <div class="row justify-content-center mt-3">
            <div class="col-12 col-md-8">
                <div class="webcam-capture mb-3" style="border: 2px solid #ccc; border-radius: 10px;">
                    <!-- Video Stream WebCam akan muncul di sini -->
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <button id="takekeluar"
                    class="btn btn-danger btn-block d-flex justify-content-center align-items-center py-2"
                    style="border-radius: 50px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <ion-icon name="camera-outline" style="font-size: 24px;"></ion-icon>
                    <span class="ml-2" style="font-size: 18px;">Absen Pulang</span>
                </button>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-10">
                <div id="map" style="height: 300px; border-radius: 10px;"></div>
            </div>
        </div>
    </div>

@endsection


@push('myscript')
    <script>
        // Fungsi untuk menampilkan tanggal, hari, dan waktu
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const dateString = now.toLocaleDateString('id-ID', options);
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            document.getElementById('currentDateTime').textContent = `${dateString} | ${timeString}`;
        }

        // Update waktu setiap detik
        setInterval(updateDateTime, 1000);
        updateDateTime(); // Panggil sekali untuk langsung menampilkan waktu

        Webcam.set({
            height: 480,
            width: 640,
            image_format: 'jpeg',
            jpeg_quality: 80
        });

        Webcam.attach('.webcam-capture');

        var lokasi = document.getElementById('lokasi');

        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        } else {
            alert("Geolocation tidak didukung oleh browser ini.");
        }

        var map; // Declare the map variable outside for global access

        function successCallback(position) {
            // Set the user's location in the input field
            lokasi.value = position.coords.latitude + "," + position.coords.longitude;

            if (map) {
                map.remove(); // Remove the existing map
            }

            // Initialize the map at the user's location
            map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 19);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

            // School polygon coordinates
            var latlngs = [
                [-6.902534230186778, 107.53790211370267], // Bottom-left
                [-6.902440034311311, 107.53917720866878], // Bottom-right
                [-6.901060061959771, 107.5396569989362], // Top-right
                [-6.900769938719598, 107.53823010603753] // Top-left
            ];

            // Create the polygon
            var polygon = L.polygon(latlngs, {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5
            }).addTo(map);

            var schoolLat = -6.902189;
            var schoolLng = 107.538401;
            var radius = 200; // 200 meters

            var distance = calculateDistance(position.coords.latitude, position.coords.longitude, schoolLat, schoolLng);

            if (distance > radius) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Anda berada di luar radius sekolah!',
                });
            }
        }

        function errorCallback(error) {
            console.log(error);
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            var R = 6371000; // Radius of the earth in meters
            var dLat = deg2rad(lat2 - lat1);
            var dLon = deg2rad(lon2 - lon1);
            var a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var distance = R * c; // Distance in meters
            return distance;
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }

        document.getElementById("takekeluar").addEventListener("click", function() {
            Webcam.snap(function(data_uri) {
                let image = data_uri;

                $.ajax({
                    type: 'POST',
                    url: "{{ route('siswa.submit-absensi-keluar') }}",
                    data: {
                        image: image,
                        lokasi: lokasi.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/dashboard';
                            }
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON.message,
                        });
                    }
                });
            });
        });
    </script>
@endpush
