@extends('siswa.layouts.index')

@section('title', 'Absensi Siswa - Pengaturan Akun')

<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Pengaturan Akun</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@section('content')

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                showConfirmButton: 'OK',
                timer: 3500
            });
        </script>
    @endif

    <style>
        .profile-container {
            background-color: #54A6FF;
            border-radius: 10px;
            padding: 20px;
        }

        .profile-header {
            display: flex;
            flex-direction: column;
            /* Arrange elements vertically */
            align-items: center;
            /* Center align items horizontally */
            justify-content: center;
            /* Center align items vertically */
            text-align: center;
        }

        .profile-picture {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }

        .profile-info {
            flex-grow: 1;
            margin-left: 10px;
            content: center;
            /* Center align items vertically */

        }

        .edit-profile-btn {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
        }

        .profile-details {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            color: #ffffff
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            color: #ffffff border: 1px solid #ccc;
        }
        .text-white {
            color: #ffffff;
        }
        
        .font-weight-semibold {
            font-weight: 600; /* Semibold */
        }
        
        .form-group label {
            font-weight: 600; /* Semibold */
            color: #ffffff;
        }
        
        .form-group input {
            color: #ffffff;
            font-weight: 600; /* Semibold */
            border: 1px solid #ccc;
            background-color: #333; /* Optional: give it a darker background to match white text */
            border-radius: 5px;
        }
        
        .form-group input[readonly] {
            background-color: #555; /* Optional: give it a different style for readonly inputs */
            border-radius: 5px;
        }
        
    </style>


    <div class="row" style="margin-top: 70px; padding: 16px; margin-bottom: 70px;">
        <div class="col">
            <div class="profile-container">
                <div class="profile-header">
                    @if (auth()->user()->siswa && auth()->user()->siswa->foto)
                        <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="User Image"
                            class="avatar-img rounded-circle imaged w128 rounded" style="height: 128px" />
                    @else
                        <img src="{{ asset('assets/images/smkn1cmh.png') }}" alt="Default Image"
                            class="avatar-img rounded-circle imaged w64 rounded" />
                    @endif
                    <div class="profile-info">
                        <h2 id="user-name" style="margin-top: 20px;">{{ auth()->user()->siswa->nama_siswa }}</h2>
                        <h3 id="user-role">{{ auth()->user()->siswa->kelas->nama_kelas }}</h3>
                    </div>
                </div>

                <!-- Personal Details -->
                <div class="profile-details">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="username" class="form-label text-white font-weight-semibold">Username</label>
                            <input type="text" class="form-control text-white font-weight-semibold" id="username" name="username"
                                value="{{ old('username', auth()->user()->username) }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label text-white font-weight-semibold">Email</label>
                            <input type="text" class="form-control text-white font-weight-semibold" value="{{ auth()->user()->email }}" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="no_telp" class="form-label text-white font-weight-semibold">No. Telepon (Opsional)</label>
                            <input type="text" class="form-control text-white font-weight-semibold" id="no_telp" name="no_telp"
                                value="{{ old('no_telp', auth()->user()->no_telp) }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="form-label text-white font-weight-semibold">Password (Opsional)</label>
                            <input type="password" class="form-control text-white font-weight-semibold @error('password') is-invalid @enderror"
                                name="password" id="password" placeholder="Masukkan Password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Password harus minimal 8 karakter.</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="foto" class="form-label text-white font-weight-semibold">Foto (Opsional)</label>
                            <input type="file" class="form-control text-white font-weight-semibold @error('foto') is-invalid @enderror"
                                name="foto" id="foto" accept="image/*" onchange="previewImage(event)">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Ukuran maksimal foto adalah 2MB. Format yang diizinkan: jpeg, png, jpg, gif.</small>
                        </div>
                        

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage(event) {
            const imagePreview = document.getElementById('fotoPreview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // Tampilkan gambar preview
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '#'; // Atur ulang jika tidak ada file
                imagePreview.style.display = 'none'; // Sembunyikan gambar preview
            }
        }
    </script>

@endsection
