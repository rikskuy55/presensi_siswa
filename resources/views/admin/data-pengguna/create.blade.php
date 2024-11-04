@extends('layouts.index')

@section('title', 'Tambah Pengguna')

@section('judulkonten', 'Tambah Pengguna')

@section('isikonten')
    <div class="container">
        <form action="{{ route('pengguna.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="password" id="password" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">
                        <i id="passwordIcon" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label for="no_telp" class="form-label">No Telepon</label>
                <input type="text" class="form-control" name="no_telp">
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" class="form-control" required>
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="guru">Guru</option>
                    <option value="siswa">Siswa</option>
                    <option value="kepala_sekolah">Kepala Sekolah</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="is_active" class="form-label">Status Aktif</label>
                <select name="is_active" class="form-control" required>
                    <option value="" disabled selected>Pilih Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" accept="image/*" onchange="previewImage(event)">
            </div>
            <div class="form-group">
                <img id="fotoPreview" src="#" alt="Preview Foto" style="display: none; max-width: 100%; margin-top: 10px;"  width="150" height="150">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    
    <script>
        // Fungsi untuk menampilkan atau menyembunyikan password
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Fungsi untuk pratinjau foto yang diunggah
        function previewImage(event) {
            const imagePreview = document.getElementById('fotoPreview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // Tampilkan gambar pratinjau
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '#'; // Atur ulang jika tidak ada file
                imagePreview.style.display = 'none'; // Sembunyikan gambar pratinjau
            }
        }
    </script>

    <!-- Tambahkan font-awesome untuk ikon mata -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <br><br><br>

@endsection
