@extends('layouts.index')

@section('title', 'Tambah Siswa')

@section('judulkonten', 'Tambah Siswa')

@section('isikonten')

    <div class="container">

        <form action="{{ route('data-siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Pilihan untuk memilih pengguna yang ada atau membuat pengguna baru --}}
            <div class="mb-3">
                <label for="user_id" class="form-label">Pengguna</label>
                <select name="user_id" class="form-control" required>
                    <option value="">Pilih Pengguna</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->username }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="nisn" class="form-label">NISN</label>
                <input type="text" class="form-control" name="nisn" id="nisn" value="{{ old('nisn') }}" required>
                @error('nisn')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_siswa" class="form-label">Nama Siswa</label>
                <input type="text" class="form-control" name="nama_siswa" id="nama_siswa" value="{{ old('nama_siswa') }}"
                    required>
                @error('nama_siswa')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                    <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                    value="{{ old('tanggal_lahir') }}" required>
                @error('tanggal_lahir')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" name="alamat" id="alamat" value="{{ old('alamat') }}"
                    required>
                @error('alamat')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="kelas_id" class="form-label">Kelas</label>
                <select class="form-select" name="kelas_id" id="kelas_id" required>
                    <option value="" disabled selected>Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" accept="image/*" onchange="previewImage(event)">
            </div>
            <div class="form-group">
                <img id="fotoPreview" src="#" alt="Preview Foto" style="display: none; max-width: 100%; margin-top: 10px;" width="150" height="150">
            </div>

            {{--  <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" name="foto" id="foto" accept="image/*" onchange="previewImage(event)">
                @error('foto')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <img id="fotoPreview" src="#" alt="Preview Foto" style="display: none; max-width: 100%; margin-top: 10px;" width="150" height="150">
            </div>  --}}

            {{--  <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('data-siswa.index') }}" class="btn btn-light">Kembali</a>  --}}

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('data-siswa.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
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
    <br><br><br>
@endsection
