@extends('layouts.index')

@section('title', 'Tambah Guru')

@section('judulkonten', 'Tambah Guru')

@section('isikonten')
    <div class="container">
        <form action="{{ route('data-guru.store') }}" method="POST" enctype="multipart/form-data">
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

            {{-- Pilihan untuk membuat pengguna baru atau mengaitkan pengguna yang ada --}}
            <div class="mb-3">
                <label for="user_id" class="form-label">Pengguna</label>
                <select name="user_id" class="form-control" required>
                    <option value="" disabled selected>Pilih Pengguna</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->username }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control" name="nip" required>
            </div>

            <div class="mb-3">
                <label for="nama_guru" class="form-label">Nama Guru</label>
                <input type="text" class="form-control" name="nama_guru" required>
            </div>

            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" required>
                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                    <option value="Laki-Laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tanggal_lahir" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" name="alamat" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" id="foto" accept="image/*" onchange="previewImage(event)">
            </div>
            <div class="form-group">
                <img id="fotoPreview" src="#" alt="Preview Foto" style="display: none; max-width: 100%; margin-top: 10px;" width="150" height="150">
            </div>

            <div class="mb-3">
                <label for="spesialisasi" class="form-label">Spesialisasi</label>
                <input type="text" class="form-control" name="spesialisasi" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('data-guru.index') }}" class="btn btn-secondary">Kembali</a>
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
