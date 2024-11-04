@extends('layouts.index')

@section('title', 'Tambah Mata Pelajaran')

@section('judulkonten', 'Tambah Mata Pelajaran')

@section('isikonten')
    <div class="container">
        <form action="{{ route('mapel.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nama_mata_pelajaran" class="form-label">Nama Mata Pelajaran</label>
                <input type="text" class="form-control" id="nama_mata_pelajaran" name="nama_mata_pelajaran" required>
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

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('mapel.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
