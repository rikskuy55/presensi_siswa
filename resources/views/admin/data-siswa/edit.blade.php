@extends('layouts.index')

@section('title', 'Edit Siswa')

@section('judulkonten', 'Edit Siswa')

@section('isikonten')
    <div class="text-center">
        <h1>Edit Siswa</h1>
    </div>
    <div class="container">
        <form action="{{ route('data-siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                <label for="user_id" class="form-label">User ID</label>
                <select class="form-select" name="user_id" id="user_id" required>
                    <option value="" disabled selected>Pilih Pengguna</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $siswa->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="nisn" class="form-label">NISN</label>
                <input type="text" class="form-control" name="nisn" id="nisn"
                    value="{{ old('nisn', $siswa->nisn) }}" required>
            </div>

            <div class="mb-3">
                <label for="nama_siswa" class="form-label">Nama Siswa</label>
                <input type="text" class="form-control" name="nama_siswa" id="nama_siswa"
                    value="{{ old('nama_siswa', $siswa->nama_siswa) }}" required>
            </div>

            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                    <option value="Laki-laki"
                        {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="Perempuan"
                        {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                    value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" name="alamat" id="alamat"
                    value="{{ old('alamat', $siswa->alamat) }}" required>
            </div>

            <div class="mb-3">
                <label for="kelas_id" class="form-label">Kelas</label>
                <select class="form-select" name="kelas_id" id="kelas_id" required>
                    <option value="" disabled selected>Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}"
                            {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" name="foto" id="foto" accept="image/*" onchange="previewFoto()">
                
                {{-- Menampilkan foto sebelumnya jika ada --}}
                @if ($siswa->foto)
                    <div class="mt-2">
                        <p>Foto Saat Ini:</p>
                        <img src="{{ Storage::url($siswa->foto) }}" alt="Foto Siswa" class="img-fluid" width="150">
                    </div>
                @endif
            
                {{-- Elemen img untuk preview foto baru --}}
                <div class="mt-3">
                    <p>Pratinjau Foto Baru:</p>
                    <img id="preview-foto" style="display: none; max-width: 150px;" />
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('data-siswa.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <br><br><br>

    <script>
        function previewFoto() {
            const fileInput = document.getElementById('foto');
            const previewImage = document.getElementById('preview-foto');
    
            // Cek apakah ada file yang dipilih
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
    
                // Fungsi saat file berhasil dibaca
                reader.onload = function(e) {
                    previewImage.style.display = 'block'; // Menampilkan elemen img
                    previewImage.src = e.target.result; // Menampilkan gambar hasil file upload
                };
    
                // Membaca file sebagai URL Data
                reader.readAsDataURL(fileInput.files[0]);
            } else {
                // Sembunyikan pratinjau jika tidak ada file yang dipilih
                previewImage.style.display = 'none';
                previewImage.src = '';
            }
        }
    </script>
@endsection
