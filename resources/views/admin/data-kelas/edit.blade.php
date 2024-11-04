@extends('layouts.index')

@section('title', 'Edit Kelas')

@section('judulkonten', 'Edit Kelas')

@section('isikonten')
    <div class="container">
        <form action="{{ route('data-kelas.update', $kelas->id) }}" method="POST">
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
                <label for="nama_kelas" class="form-label">Nama Kelas</label>
                <input type="text" class="form-control" name="nama_kelas" value="{{ $kelas->nama_kelas }}" required>
            </div>

            <div class="mb-3">
                <label for="jurusan" class="form-label">Jurusan</label>
                <input type="text" class="form-control" name="jurusan" value="{{ $kelas->jurusan }}" required>
            </div>

            <div class="mb-3">
                <label for="wali_kelas_id" class="form-label">Wali Kelas</label>
                <select name="wali_kelas_id" class="form-control" required>
                    <option value="" disabled selected>Pilih Wali Kelas</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ $kelas->wali_kelas_id == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama_guru }} ({{ $guru->nip }})
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('data-kelas.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <br><br><br>
@endsection
