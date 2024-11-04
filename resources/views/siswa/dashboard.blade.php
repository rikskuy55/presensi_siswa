<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Absensi Siswa</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="{{ asset('assets/images/smkn1cmh.png') }}" sizes="32x32">
    <link rel="stylesheet" href="{{ asset('assets/css/siswa/assets/css/style.css') }}">
    <link rel="manifest" href="{{ asset('assets/css/siswa/__manifest.json') }}">

    <style>
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .card {
            transition: transform 0.2s ease, background-color 0.2s ease;
            /* Tambahkan transisi untuk efek yang halus */
        }

        .card:hover {
            transform: scale(1.01);
            /* Slightly enlarge the card on hover */
            cursor: pointer;
            /* Change the cursor to pointer */
            background-color: #f0f8ff;
            /* Ganti dengan warna latar belakang yang diinginkan */
            border: 2px solid #1e90ff;
            /* Ganti dengan warna border yang diinginkan */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            /* Tambahkan efek bayangan untuk tampilan lebih menarik */
        }


        .gradasigreen {
            background: linear-gradient(to right, #00c853, #58ff88);
            color: white;
        }

        .gradasired {
            background: linear-gradient(to right, #ff5252, #ff7569);
            color: white;
        }

        .gradasiyellow {
            background: linear-gradient(to right, #ffeb3b, #fff176);
            color: black;
        }

        .gradasiblue {
            background: linear-gradient(to right, #2196f3, #6bbcff);
            color: white;
        }

        .gradasipurple {
            background: linear-gradient(to right, #7b1fa2, #e75eff);
            color: white;
        }

        .presencecontent {
            display: flex;
            align-items: center;
        }

        .iconpresence {
            font-size: 24px;
            margin-right: 10px;
        }

        .presencetitle {
            font-size: 16px;
            font-weight: bold;
        }

        .current-time-display {
            position: absolute;
            bottom: 0;
            /* Posisi bawah */
            right: 0;
            /* Posisi kanan */
            padding: 10px;
            /* Padding untuk spasi */
        }

        #current-time {
            text-align: right;
            /* Teks rata kanan */
            color: #FFFFFF;
            /* Warna teks */
            font-size: 14px;
            /* Ukuran teks */
            font-weight: bold;
            /* Tebalkan teks */
        }
    </style>
</head>

<body style="background-color:#e9ecef;">

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section" id="user-section">
            <div id="user-detail" style="position: relative;">
                <div class="avatar">
                    @if (auth()->user()->foto)
                        <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="User Image"
                            class="avatar-img rounded-circle imaged w64 rounded" style="height: 64px" />
                    @else
                        <img src="{{ asset('assets/images/smkn1cmh.png') }}" alt="Default Image"
                            class="avatar-img rounded-circle imaged w64 rounded" />
                    @endif
                </div>
                <div id="user-info">
                    <h2 id="user-name">{{ auth()->user()->siswa->nama_siswa }}</h2>
                    <span id="user-role">{{ auth()->user()->siswa->kelas->nama_kelas }}</span>
                </div>
                <div class="current-time-display">
                    <h4 id="current-time"></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="{{ url('profile') }}" class="green" style="font-size: 40px;">
                                <ion-icon name="person-circle"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="{{ url('izin') }}" class="danger" style="font-size: 40px;">
                                <ion-icon name="calendar-outline"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Izin</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="{{ url('histori') }}" class="warning" style="font-size: 40px;">
                                <ion-icon name="time-outline"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    {{--  <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="{{ url('location') }}" class="orange" style="font-size: 40px;">
                                <ion-icon name="location-outline"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Lokasi</span>
                        </div>
                    </div>  --}}
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <!-- Gunakan form dengan method POST untuk logout -->
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link"
                                    style="font-size: 40px; border: none; background: none; padding: 0;">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                </button>
                            </form>
                        </div>
                        <div class="menu-name">
                            Logout
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section mt-2" id="presence-section">
        <!-- Absensi Harian -->
        <div class="todaypresence">

            {{--  <div id="rekappresensi" style="margin-bottom: 20px;">
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>  --}}


            <h4 class="section-title">Absensi Harian</h4>
            <div class="row">
                <div class="col-6">
                    <a href="{{ url('absensi-harian-masuk') }}" class="card gradasigreen text-decoration-none">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <ion-icon name="camera"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Absen Masuk</h4>
                                    {{--  <span style="color: white;">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</span>  --}}

                                    <span>{{ $presensihariini && $presensihariini->jam_masuk ? $presensihariini->jam_masuk : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ url('absensi-harian-keluar') }}" class="card gradasired text-decoration-none">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <ion-icon name="camera"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Absen Pulang</h4>
                                    <span>{{ $presensihariini && $presensihariini->jam_keluar ? $presensihariini->jam_keluar : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="subjectpresence mt-3">
            <h4 class="section-title">Absensi Mata Pelajaran</h4>
            <div class="row">
                @if ($jadwalMapel->isEmpty())
                    <div class="col-12">
                        <div class="alert alert-warning">Tidak ada jadwal mata pelajaran untuk hari ini.</div>
                    </div>
                @else
                    @foreach ($jadwalMapel as $jadwal)
                        <div class="col-12 col-md-6 mt-2">
                            @php
                                $color = app('App\Http\Controllers\DashboardController')->getColor(
                                    $jadwal->nama_mata_pelajaran,
                                );
                            @endphp
                            <div class="card" style="background-color: {{ $color }};">
                                <div class="card-body">
                                    <div class="presencecontent d-flex align-items-center">
                                        <div class="iconpresence" style="color: white;">
                                            <ion-icon name="book" style="color: white;"></ion-icon>
                                        </div>
                                        <div class="presencedetail ml-3">
                                            <h4 class="presencetitle">{{ $jadwal->nama_mata_pelajaran }}</h4>
                                            <span style="color: white;">{{ $jadwal->jam_mulai }} -
                                                {{ $jadwal->jam_selesai }}</span>
                                            <div>
                                                <a href="{{ url('absensi-mapel-mulai', ['mapel_id' => $jadwal->mapel_id]) }}"
                                                    class="btn btn-sm btn-success mt-2">Absen Mulai</a>
                                                <a href="{{ url('absensi-mapel-selesai', ['mapel_id' => $jadwal->mapel_id]) }}"
                                                    class="btn btn-sm btn-danger mt-2">Absen Selesai</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <br>
        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Histori
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content mt-2" style="margin-bottom:100px;">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                <ul class="listview image-listview" style="padding: 10px">
                    @foreach ($historibulanini as $d)
                        <li>
                            <div class="item">
                                <div class="in">
                                    <div>{{ \Carbon\Carbon::parse($d->tanggal)->format('d-m-Y') }}</div>
                                    <div>
                                        <!-- Tampilkan jenis presensi: harian atau pelajaran -->
                                        <strong>Jenis Presensi: </strong> 
                                        @if($d->jenis_presensi == 'harian')
                                            Harian
                                        @else
                                            Pelajaran
                                        @endif
                                    </div>
                                    <div>
                                        <!-- Tampilkan status absen: masuk/keluar untuk harian, mulai/selesai untuk pelajaran -->
                                        <strong>Status Absen: </strong> 
                                        @if($d->jenis_presensi == 'harian')
                                            @if($d->status == 'masuk')
                                                Masuk
                                            @elseif($d->status == 'keluar')
                                                Keluar
                                            @endif
                                        @elseif($d->jenis_presensi == 'pelajaran')
                                            @if($d->status == 'mulai')
                                                Mulai
                                            @elseif($d->status == 'selesai')
                                                Selesai
                                            @endif
                                        @endif
                                    </div>
                                    <!-- Tampilkan badge status presensi -->
                                    <span class="badge badge-danger">{{ $d->status }}</span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- * App Capsule -->

    <!-- App Bottom Menu -->
    <div class="appBottomMenu">
        <a href="{{ url('dashboard') }}" class="item {{ request()->is('dashboard') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="grid-outline" role="img" class="md hydrated"
                    aria-label="grid-outline"></ion-icon>
                <strong>Dashboard</strong>
            </div>
        </a>
        <a href="{{ url('izin') }}" class="item {{ request()->is('izin') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="calendar-outline" role="img" class="md hydrated"
                    aria-label="calendar outline"></ion-icon>
                <strong>Izin</strong>
            </div>
        </a>
        <a href="{{ url('histori') }}" class="item {{ request()->is('histori') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="time-outline" role="img" class="md hydrated"
                    aria-label="time-outline"></ion-icon>
                <strong>Histori</strong>
            </div>
        </a>
        <a href="{{ url('profile') }}" class="item {{ request()->is('profile') ? 'active' : '' }}">
            <div class="col">
                <ion-icon name="person-circle" role="img" class="md hydrated"
                    aria-label="person-circle"></ion-icon>
                <strong>Profile</strong>
            </div>
        </a>
    </div>
    <!-- * App Bottom Menu -->


    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap-->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('assets/css/siswa/assets/js/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <!-- jQuery Circle Progress -->
    <script src="assets/js/plugins/jquery-circle-progress/circle-progress.min.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <!-- Base Js File -->
    <script src="assets/js/base.js"></script>

    <script>
        function updateTime() {
            var now = new Date();
            var dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var day = dayNames[now.getDay()];
            var hours = String(now.getHours()).padStart(2, '0');
            var minutes = String(now.getMinutes()).padStart(2, '0');
            var seconds = String(now.getSeconds()).padStart(2, '0'); // Tambahkan detik
            var currentTime = day + ', ' + hours + ':' + minutes + ':' + seconds; // Tambahkan detik ke tampilan

            document.getElementById('current-time').textContent = currentTime;
        }

        setInterval(updateTime, 1000); // Memperbarui setiap detik


        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            var chart = am4core.create("chartdiv", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            chart.legend = new am4charts.Legend();

            chart.data = [{
                    country: "Hadir",
                    litres: 501.9
                },
                {
                    country: "Sakit",
                    litres: 301.9
                },
                {
                    country: "Izin",
                    litres: 201.1
                },
                {
                    country: "Terlambat",
                    litres: 165.8
                },
            ];

            var series = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.value = "litres";
            series.dataFields.category = "country";
            series.alignLabels = false;
            series.labels.template.text = "{value.percent.formatNumber('#.0')}%";
            series.labels.template.radius = am4core.percent(-40);
            series.labels.template.fill = am4core.color("white");
            series.colors.list = [
                am4core.color("#1171ba"),
                am4core.color("#fca903"),
                am4core.color("#37db63"),
                am4core.color("#ba113b"),
            ];
        }); // end am4core.ready()

        // Mengambil lokasi GPS
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    </script>

</body>

</html>
