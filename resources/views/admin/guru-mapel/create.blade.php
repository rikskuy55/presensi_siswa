@extends('layouts.index')

@section('title', 'Tambah Guru Mapel')

@section('judulkonten', 'Tambah Guru Mapel')

@section('isikonten')
<div class="container">
    <form action="{{ route('guru-mapel.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="guru_id" class="form-label">Guru</label>
            <select name="guru_id" class="form-control" required>
                <option value="" disabled selected>Pilih Guru</option>
                @foreach($gurus as $guru)
                    <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="mapel_id" class="form-label">Mata Pelajaran</label>
            <select name="mapel_id" class="form-control" required>
                <option value="" disabled selected>Pilih Mata Pelajaran</option>
                @foreach($mapels as $mapel)
                    <option value="{{ $mapel->id }}">{{ $mapel->nama_mata_pelajaran }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="kelas_id" class="form-label">Kelas</label>
            <select name="kelas_id" class="form-control" required>
                <option value="" disabled selected>Pilih Kelas</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('guru-mapel.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
</div>
<br><br><br>
@endsection
