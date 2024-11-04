<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/smkn1cmh.png') }}">
    <title>SMK Negeri 1 Cimahi - Login</title>

    {{--  <!-- Fonts and icons -->  --}}
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    {{--  <!-- Nucleo Icons -->  --}}
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />

    {{--  <!-- Font Awesome Icons -->  --}}
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    {{--  <!-- Material Icons -->  --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    {{--  <!-- CSS Files -->  --}}
    <link id="pagestyle" href="assets/css/login/material-dashboard.css" rel="stylesheet" />
</head>

<body class="bg-gray-200">
    <main class="main-content mt-0">
        <div class="page-header align-items-center justify-content-center min-vh-100 d-flex"
            style="background-image: url('{{ asset('assets/images/snow.jpg') }}'); background-size: cover;">
            <div class="container" style="margin-top: -180px;">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-8 col-12">
                        <div class="text-center">
                            <img src="{{ asset('assets/images/smkn1cmh.png') }}" alt="Logo SMKN 1 Cimahi"
                                style="width: 200px; height: auto;">
                            <h4 class="text-white font-weight-bolder mt-1 mb-0" style="font-size: 40pt">ABSENSI SISWA
                            </h4><br>
                        </div>
                        <div class="card z-index-0 fadeIn3 fadeInBottom mt-1">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mb-0">Login Akun</h4>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form method="POST" action="{{ route('login') }}" class="text-start">
                                        @csrf
                                        <div class="input-group input-group-outline my-3">
                                            <label class="form-label">Email atau Username</label>
                                            <input type="text" name="login" class="form-control"
                                                value="{{ old('login') }}">
                                        </div>
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" id="password" name="password" class="form-control">
                                            <button type="button" id="togglePassword" style="background: none; border: none;">
                                                <i class="fa fa-lock" id="togglePasswordIcon"></i>
                                            </button>
                                        </div>
                                        
                                        
                                        <div class="form-check form-switch d-flex align-items-center mb-3">
                                            <input class="form-check-input" type="checkbox" id="rememberMe"
                                                name="remember">
                                            <label class="form-check-label mb-0 ms-2" for="rememberMe">Remember
                                                me</label>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn bg-gradient-primary w-100 my-4 mb-2">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>

    <script>
        const passwordField = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');
    
        togglePasswordButton.addEventListener('click', function() {
            // Toggle the type attribute
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
    
            // Toggle the icon
            togglePasswordIcon.classList.toggle('fa-lock');
            togglePasswordIcon.classList.toggle('fa-unlock-alt');
        });
    </script>
    

    <script src="assets/js/login/core/popper.min.js"></script>
    <script src="assets/js/login/core/bootstrap.min.js"></script>
    <script src="assets/js/login/plugins/perfect-scrollbar.min.js"></script>
    <script src="assets/js/login/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    {{--  <!-- Github buttons -->  --}}
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    {{--  <!-- Control Center por Material Dashboard: parallax effects, scripts por the example pages etc -->  --}}
    <script src="assets/js/login/material-dashboard.min.js?v=3.0.0"></script>
</body>

</html>
