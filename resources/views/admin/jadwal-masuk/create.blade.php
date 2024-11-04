@extends('layouts.index')

@section('title', 'Tambah Jadwal Masuk Sekolah')

@section('judulkonten', 'Tambah Jadwal Masuk Sekolah')

@section('isikonten')
    <div class="container">
        <form action="{{ route('jadwal-masuk.store') }}" method="POST">
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

            {{-- Pilihan Kelas --}}
            <div class="mb-3">
                <label for="kelas_id" class="form-label">Kelas</label>
                <select name="kelas_id" class="form-control" required>
                    <option value="" disabled selected>Pilih Kelas</option>
                    @foreach($kelas as $kelasItem)
                        <option value="{{ $kelasItem->id }}">
                            {{ $kelasItem->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label for="hari" class="form-label">Hari</label>
                <select name="hari" class="form-control" required>
                    <option value="" disabled selected>Pilih Hari</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                <input type="time" class="form-control" name="jam_masuk" required>
            </div>

            <div class="mb-3">
                <label for="jam_keluar" class="form-label">Jam Keluar</label>
                <input type="time" class="form-control" name="jam_keluar" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('jadwal-masuk.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
