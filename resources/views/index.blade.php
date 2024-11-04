<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/smkn1cmh.png') }}">
    <title>SMK Negeri 1 Cimahi</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/lanpage/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-light shadow sticky-top p-0" style="background: #0479c7;">
        <a href="#" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0" style="color: white"><i></i>ABSENSI SISWA</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="#" class="nav-item nav-link active">Home</a>
                <a href="#" class="nav-item nav-link">Tentang</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Lainnya</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="404.html" class="dropdown-item">Halaman 404</a>
                    </div>
                </div>
                <a href="#" class="nav-item nav-link">Kontak</a>
            </div>
            <a href="login" style="font-size: 14pt" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Login<i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid w-100" src="{{ asset('assets/images/pemandangan.jpg') }}" style="object-fit: cover; width: 100%; height: 800px;" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(190, 190, 190, 0.3);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-white text-uppercase mb-3 animated slideInDown">Sistem Absensi Terbaik</h5>
                                <h1 class="display-3 text-white animated slideInDown">Platform Absensi Siswa Terintegrasi</h1>
                                <p class="fs-5 text-white mb-4 pb-2">Sistem ini membantu mengelola absensi siswa dengan mudah dan efisien, menggunakan teknologi RFID untuk pencatatan otomatis kehadiran.</p>
                                <a href="login" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">LOGIN</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 350px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" src="{{ asset('assets/images/smkn1cmh.png') }}" alt="" style="object-fit: contain;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">Tentang Kami</h6>
                    <h1 class="mb-4">Selamat Datang di Sistem Absensi SMKN 1 Cimahi</h1>
                    <p class="mb-4">Sistem absensi berbasis RFID ini dirancang khusus untuk mempermudah pengelolaan kehadiran siswa. Dengan teknologi modern, pencatatan absensi kini menjadi lebih cepat, akurat, dan efisien.</p>
                    <p class="mb-4">Siswa hanya perlu menempelkan kartu RFID pada perangkat untuk mencatat kehadiran secara otomatis. Sistem ini juga dilengkapi dengan fitur validasi waktu untuk memastikan siswa hadir tepat waktu.</p>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Absensi Otomatis</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Rekap Data Terintegrasi</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Laporan Kehadiran Real-time</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Notifikasi Ketepatan Waktu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
    <!-- Footer Start -->
    <div class="container-fluid text-light footer pt-5 mt-5 wow fadeIn" style="background-color: rgba(0, 79, 131)" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6 text-center">
                    <h4 class="text-light mb-3">Tautan Cepat</h4>
                    <a class="btn btn-link" href="">Tentang Kami</a>
                    <a class="btn btn-link" href="">Hubungi Kami</a>
                    <a class="btn btn-link" href="">Kebijakan Privasi</a>
                    <a class="btn btn-link" href="">Syarat & Ketentuan</a>
                    <a class="btn btn-link" href="">Bantuan</a>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <h4 class="text-light mb-3">Kontak</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Jl. Mahar Martanegara No.48, Utama, Kec. Cimahi Sel., Kota Cimahi, Jawa Barat 40533</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>022-6629683</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@smkn1-cmi.sch.id</p>
                    <div class="d-flex justify-content-center pt-2">
                        <a class="btn btn-outline-light btn-social" href="https://www.smkn1-cmi.sch.id/" target="_blank"><i class="fa fa-globe"></i></a>
                        <a class="btn btn-outline-light btn-social" href="https://www.instagram.com/smkn1cmi/" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-outline-light btn-social" href="https://www.facebook.com/SMKNegeri1cimahi" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href="https://www.youtube.com/@SMKNEGERI1CIMAHIOFFICIAL" target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->
    

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('assets/js/lanpage/main.js') }} "></script>
</body>

</html>