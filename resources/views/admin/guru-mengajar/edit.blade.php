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
                @error('nisn')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_siswa" class="form-label">Nama Siswa</label>
                <input type="text" class="form-control" name="nama_siswa" id="nama_siswa"
                    value="{{ old('nama_siswa', $siswa->nama_siswa) }}" required>
                @error('nama_siswa')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                    <option value="Laki-laki"
                        {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="Perempuan"
                        {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>
                @error('jenis_kelamin')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                    value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" required>
                @error('tanggal_lahir')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" name="alamat" id="alamat"
                    value="{{ old('alamat', $siswa->alamat) }}" required>
                @error('alamat')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="kelas_id" class="form-label">Kelas</label>
                <select class="form-select" name="kelas_id" id="kelas_id" required>
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}"
                            {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                @if ($siswa->foto)
                    <img src="{{ Storage::url($siswa->foto) }}" alt="Foto Siswa" class="img-fluid mt-2" width="150">
                @endif
                @error('foto')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('data-siswa.index') }}" class="btn btn-light">Kembali</a>
        </form>
    </div>
    <br><br><br>
@endsection
