@extends('layouts.index')

@section('title', 'Edit Guru')

@section('judulkonten', 'Edit Guru')

@section('isikonten')
<div class="container">
    <form action="{{ route('data-guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data">
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
                    <option value="{{ $user->id }}" {{ $guru->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->id }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" class="form-control" name="nip" id="nip" value="{{ old('nip', $guru->nip) }}" required>
        </div>

        <div class="mb-3">
            <label for="nama_guru" class="form-label">Nama Guru</label>
            <input type="text" class="form-control" name="nama_guru" id="nama_guru" value="{{ $guru->nama_guru }}" required>
        </div>

        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                <option value="Laki-Laki" {{ $guru->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                <option value="Perempuan" {{ $guru->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{ $guru->tanggal_lahir }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat" required>{{ $guru->alamat }}</textarea>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control" name="foto" id="foto" accept="image/*" onchange="previewFoto()">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>

            {{-- Menampilkan foto sebelumnya jika ada --}}
            @if ($guru->foto)
                <div class="mt-2">
                    <p>Foto Saat Ini:</p>
                    <img src="{{ Storage::url($guru->foto) }}" alt="Foto Sebelumnya" id="foto-sebelumnya" class="img-fluid" width="150">
                </div>
            @endif

            {{-- Pratinjau foto baru jika ada unggahan --}}
            <div class="mt-3">
                <p>Pratinjau Foto Baru:</p>
                <img id="preview-foto" style="display: none; max-width: 150px;" />
            </div>
        </div>

        <div class="mb-3">
            <label for="spesialisasi" class="form-label">Spesialisasi</label>
            <input type="text" class="form-control" name="spesialisasi" id="spesialisasi" value="{{ $guru->spesialisasi }}">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('data-guru.index') }}" class="btn btn-secondary">Kembali</a>
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
                previewImage.style.display = 'block'; // Menampilkan elemen img untuk pratinjau
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
