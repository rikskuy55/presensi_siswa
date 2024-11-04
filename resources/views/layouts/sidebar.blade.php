{{--  Sidebar  --}}
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        {{--  Logo Header  --}}
        <div class="logo-header" data-background-color="dark">
            <a href="{{ url('dashboard') }}" class="logo">
                <img src="{{ asset('assets/images/logo-header.png') }}" alt="navbar brand" class="navbar-brand"
                    height="35px" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        {{--  End Logo Header  --}}
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                {{-- Dashboard --}}
                <li class="nav-item {{ Request::is('dashboard*') ? 'active' : '' }}">
                    <a href="{{ url('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if (Auth::check() && Auth::user()->role == 'admin')
                    {{-- Data Master Section --}}
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-database"></i>
                        </span>
                        <h4 class="text-section">Data Master</h4>
                    </li>

                    {{-- Data Siswa --}}
                    <li class="nav-item {{ Request::is('siswa*') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#dataSiswa"
                            aria-expanded="{{ Request::is('siswa*') ? 'true' : 'false' }}">
                            <i class="fas fa-users"></i>
                            <p>Data Siswa</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ Request::is('data-siswa*') ? 'show' : '' }}" id="dataSiswa">
                            <ul class="nav nav-collapse">
                                <li class="{{ Request::is('data-siswa/daftar') ? 'active' : '' }}">
                                    <a href="{{ url('data-siswa') }}">
                                        <span class="sub-item">Daftar Siswa</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('data-siswa/tambah') ? 'active' : '' }}">
                                    <a href="{{ url('data-siswa/create') }}">
                                        <span class="sub-item">Tambah Siswa</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- Data Guru --}}
                    <li class="nav-item {{ Request::is('data-guru*') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#dataGuru"
                            aria-expanded="{{ Request::is('data-guru*') ? 'true' : 'false' }}">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <p>Data Guru</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ Request::is('data-guru*') ? 'show' : '' }}" id="dataGuru">
                            <ul class="nav nav-collapse">
                                <li class="{{ Request::is('data-guru/daftar') ? 'active' : '' }}">
                                    <a href="{{ url('data-guru') }}">
                                        <span class="sub-item">Daftar Guru</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('data-guru/tambah') ? 'active' : '' }}">
                                    <a href="{{ url('data-guru/create') }}">
                                        <span class="sub-item">Tambah Guru</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- Data Kelas --}}
                    <li class="nav-item {{ Request::is('data-kelas*') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#dataKelas"
                            aria-expanded="{{ Request::is('data-kelas*') ? 'true' : 'false' }}">
                            <i class="fas fa-school"></i>
                            <p>Data Kelas</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ Request::is('data-kelas*') ? 'show' : '' }}" id="dataKelas">
                            <ul class="nav nav-collapse">
                                <li class="{{ Request::is('data-kelas/daftar') ? 'active' : '' }}">
                                    <a href="{{ url('data-kelas') }}">
                                        <span class="sub-item">Daftar Kelas</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('data-kelas/tambah') ? 'active' : '' }}">
                                    <a href="{{ url('data-kelas/create') }}">
                                        <span class="sub-item">Tambah Kelas</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{--  Kelola Mata Pelajaran  --}}
                    <li class="nav-item {{ Request::is('mapel*') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#kelolaMapel"
                            aria-expanded="{{ Request::is('mapel*') ? 'true' : 'false' }}">
                            <i class="fas fa-book"></i>
                            <p>Mata Pelajaran</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ Request::is('mapel*') ? 'show' : '' }}" id="kelolaMapel">
                            <ul class="nav nav-collapse">
                                <li class="{{ Request::is('mapel/daftar') ? 'active' : '' }}">
                                    <a href="{{ url('mapel') }}">
                                        <span class="sub-item">Daftar Mata Pelajaran</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('mapel/tambah-mapel') ? 'active' : '' }}">
                                    <a href="{{ url('mapel/create') }}">
                                        <span class="sub-item">Tambah Mata Pelajaran</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{--  Kelola Guru Mengajar  --}}
                    <li class="nav-item {{ Request::is('guru-mapel*') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#kelolaMengajar"
                            aria-expanded="{{ Request::is('guru-mapel*') ? 'true' : 'false' }}">
                            <i class="fas fa-calendar"></i>
                            <p>Guru Mapel</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ Request::is('guru-mapel*') ? 'show' : '' }}" id="kelolaMengajar">
                            <ul class="nav nav-collapse">
                                <li class="{{ Request::is('guru-mapel/daftar') ? 'active' : '' }}">
                                    <a href="{{ url('guru-mapel') }}">
                                        <span class="sub-item">Daftar Mengajar</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('guru-mapel/tambah-mengajar') ? 'active' : '' }}">
                                    <a href="{{ url('guru-mapel/create') }}">
                                        <span class="sub-item">Tambah Mengajar</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-database"></i>
                        </span>
                        <h4 class="text-section">Jadwal</h4>
                    </li>
                    {{--  Kelola Jadwal Guru Mengajar  --}}
                    <li class="nav-item {{ Request::is('jadwal-mapel*') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#kelolaJadwalMengajar"
                            aria-expanded="{{ Request::is('jadwal-mapel*') ? 'true' : 'false' }}">
                            <i class="fas fa-calendar-alt"></i>
                            <p>Jadwal Guru Mapel</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ Request::is('jadwal-mapel*') ? 'show' : '' }}"
                            id="kelolaJadwalMengajar">
                            <ul class="nav nav-collapse">
                                <li class="{{ Request::is('jadwal-mapel/daftar') ? 'active' : '' }}">
                                    <a href="{{ url('jadwal-mapel') }}">
                                        <span class="sub-item">Daftar Jadwal Mapel</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('jadwal-mapel/tambah-jadwal') ? 'active' : '' }}">
                                    <a href="{{ url('jadwal-mapel/create') }}">
                                        <span class="sub-item">Tambah Jadwal Mapel</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- Absensi --}}
                    <li class="nav-item {{ Request::is('jadwal-masuk*') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#kelolaJadwalMasuk"
                            aria-expanded="{{ Request::is('jadwal-masuk*') ? 'true' : 'false' }}">
                            <i class="fas fa-clipboard-list"></i>
                            <p>Jadwal Masuk Sekolah</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ Request::is('jadwal-masuk*') ? 'show' : '' }}"
                            id="kelolaJadwalMasuk">
                            <ul class="nav nav-collapse">
                                <li class="{{ Request::is('jadwal-masuk/daftar') ? 'active' : '' }}">
                                    <a href="{{ url('jadwal-masuk') }}">
                                        <span class="sub-item">Daftar Jadwal Masuk</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('jadwal-masuk/tambah-jadwal') ? 'active' : '' }}">
                                    <a href="{{ url('jadwal-masuk/create') }}">
                                        <span class="sub-item">Tambah Jadwal Masuk</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if (
                    (Auth::check() && Auth::user()->role == 'admin') ||
                        Auth::user()->role == 'guru' ||
                        Auth::user()->role == 'kepala_sekolah')
                    @if (Auth::check())
                        {{-- Monitoring Absensi Section --}}
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-eye"></i>
                            </span>
                            <h4 class="text-section">Presensi & Monitoring</h4>
                        </li>

                        {{-- Kelola Izin --}}
                        @if (Auth::user()->role == 'admin' || (Auth::user()->role == 'guru' && Auth::user()->guru->kelasWali))
                            <li class="nav-item {{ Request::is('izin*') ? 'active' : '' }}">
                                <a href="{{ url('izin-siswa') }}">
                                    <i class="fas fa-user-check"></i>
                                    <p>Kelola Izin Siswa</p>
                                </a>
                            </li>
                        @endif

                        {{-- Monitoring Absensi Harian (Kelas Saya) --}}
                        @if (Auth::user()->role == 'guru' && Auth::user()->guru->kelasWali)
                            <li class="nav-item {{ Request::is('monitoring-absensi/harian/kelas') ? 'active' : '' }}">
                                <a href="{{ route('monitoring-absensi.harian.kelas') }}">
                                    <i class="fas fa-calendar"></i>
                                    <p>Monitoring Absensi Harian (Kelas Saya)</p>
                                </a>
                            </li>
                        @endif

                        {{-- Monitoring Absensi Pelajaran --}}
                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'guru')
                            <li class="nav-item {{ Request::is('monitoring-pelajaran') ? 'active' : '' }}">
                                <a href="{{ url('monitoring-pelajaran') }}">
                                    <i class="fas fa-book-open"></i>
                                    <p>Monitoring Absensi Pelajaran</p>
                                </a>
                            </li>
                        @endif

                        {{-- Laporan Absensi Harian Siswa --}}
                        @if (Auth::user()->role == 'guru' && Auth::user()->guru->kelasWali)
                            <li class="nav-item {{ Request::is('laporan-harian/siswa') ? 'active' : '' }}">
                                <a href="{{ route('laporan-harian.wali-kelas') }}">
                                    <i class="fas fa-file-alt"></i>
                                    <p>Laporan Absensi Harian Siswa</p>
                                </a>
                            </li>
                        @elseif (Auth::user()->role == 'admin')
                            <li class="nav-item {{ Request::is('laporan-harian') ? 'active' : '' }}">
                                <a href="#">
                                    <i class="fas fa-file-alt"></i>
                                    <p>Laporan Absensi Harian</p>
                                </a>
                            </li>
                        @endif

                        {{-- Laporan Absensi Harian Kelas --}}
                        @if (Auth::user()->role == 'guru' && Auth::user()->guru->kelasWali)
                            <li class="nav-item {{ Request::is('laporan-harian/kelas') ? 'active' : '' }}">
                                <a href="{{ route('laporan-harian.kelas') }}">
                                    <i class="fas fa-file-alt"></i>
                                    <p>Laporan Absensi Harian Kelas</p>
                                </a>
                            </li>
                        @endif

                        {{-- Laporan Absensi Mata Pelajaran --}}
                        @if (Auth::user()->role == 'guru')
                            <li class="nav-item {{ Request::is('laporan/mapel*') ? 'active' : '' }}">
                                <a href="{{ url('laporan-mapel') }}">
                                    <i class="fas fa-file-alt"></i>
                                    <p>Laporan Absensi Mata Pelajaran</p>
                                </a>
                            </li>
                        @endif
                    @endif
                @endif

                @if ((Auth::check() && Auth::user()->role == 'admin') || Auth::user()->role == 'kepala_sekolah')
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-eye"></i>
                        </span>
                        <h4 class="text-section">Pengguna & Log</h4>
                    </li>
                    {{-- Kelola Pengguna --}}
                    <li class="nav-item {{ Request::is('pengguna*') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#kelolaPengguna"
                            aria-expanded="{{ Request::is('pengguna*') ? 'true' : 'false' }}">
                            <i class="fas fa-users-cog"></i>
                            <p>Kelola Pengguna</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ Request::is('pengguna*') ? 'show' : '' }}" id="kelolaPengguna">
                            <ul class="nav nav-collapse">
                                <li class="{{ Request::is('pengguna/daftar') ? 'active' : '' }}">
                                    <a href="{{ url('pengguna') }}">
                                        <span class="sub-item">Daftar Pengguna</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('pengguna/reset-password') ? 'active' : '' }}">
                                    <a href="{{ url('reset-password') }}">
                                        <span class="sub-item">Reset Password</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- Log Aktivitas --}}
                    <li class="nav-item {{ Request::is('log-aktivitas*') ? 'active' : '' }}">
                        <a href="{{ url('log-aktivitas') }}">
                            <i class="fas fa-history"></i>
                            <p>Log Aktivitas</p>
                        </a>
                    </li>

                    {{-- Pengaturan --}}
                    <li class="nav-item {{ Request::is('pengaturan*') ? 'active' : '' }}">
                        <a href="{{ url('pengaturan') }}">
                            <i class="fas fa-cogs"></i>
                            <p>Pengaturan</p>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</div>
{{--  End Sidebar  --}}
