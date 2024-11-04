@extends('layouts.index')

@section('title', 'Edit Mata Pelajaran')

@section('judulkonten', 'Edit Mata Pelajaran')

@section('isikonten')
    <div class="container">
        <form action="{{ route('mapel.update', $mapel->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_mata_pelajaran" class="form-label">Nama Mata Pelajaran</label>
                <input type="text" class="form-control" id="nama_mata_pelajaran" name="nama_mata_pelajaran" value="{{ $mapel->nama_mata_pelajaran }}" required>
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

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('mapel.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <br><br><br>
@endsection
