@extends('layouts.index')

@section('title', 'Edit Pengguna')

@section('judulkonten', 'Edit Pengguna')

@section('isikonten')
    <div class="container">
        <h2>Edit Pengguna</h2>
        <form action="{{ route('pengguna.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
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
                <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label for="no_telp" class="form-label">No. Telepon (Opsional)</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{ $user->no_telp }}">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password (Opsional)</label>
                <div class="input-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Masukkan Password">
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">
                        <i id="passwordIcon" class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <small class="form-text text-muted">Password harus minimal 8 karakter.</small>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Peran</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="siswa" {{ $user->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="kepala_sekolah" {{ $user->role == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="is_active" class="form-label">Status Aktif</label>
                <select class="form-control" id="is_active" name="is_active" required>
                    <option value="1" {{ $user->is_active == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $user->is_active == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto (Opsional)</label>
                <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" accept="image/*" onchange="previewImage(event)">
                @error('foto')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <small class="form-text text-muted">Ukuran maksimal foto adalah 2MB. Format yang diizinkan: jpeg, png, jpg, gif.</small>

                @if ($user->foto)
                    <div class="mt-3">
                        <p>Foto Saat Ini:</p>
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Saat Ini" width="150">
                    </div>
                @endif

                <div class="mt-3">
                    <p>Pratinjau Foto Baru:</p>
                    <img id="fotoPreview" style="display: none; max-width: 150px; margin-top: 10px;">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script>
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

        function previewImage(event) {
            const imagePreview = document.getElementById('fotoPreview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.style.display = 'block'; 
                imagePreview.src = e.target.result;  
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <br><br><br>

@endsection
