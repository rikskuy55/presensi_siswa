@extends('layouts.index')

@section('title', 'Tambah Jadwal Mengajar')

@section('judulkonten', 'Tambah Jadwal Mengajar')

@section('isikonten')
    <div class="container">
        <form action="{{ route('jadwal-mapel.store') }}" method="POST">
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

            {{-- Pilihan Guru Mata Pelajaran --}}
            <div class="mb-3">
                <label for="guru_mapel_id" class="form-label">Guru Mata Pelajaran</label>
                <select name="guru_mapel_id" class="form-control" required>
                    <option value="" disabled selected>Pilih Guru Mata Pelajaran</option>
                    @foreach($guruMapels as $guruMapel)
                        <option value="{{ $guruMapel->id }}">
                            {{ $guruMapel->kelas->nama_kelas }} - {{ $guruMapel->guru->nama_guru }} - {{ $guruMapel->mataPelajaran->nama_mata_pelajaran }}
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
                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                <input type="time" class="form-control" name="jam_mulai" required>
            </div>

            <div class="mb-3">
                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                <input type="time" class="form-control" name="jam_selesai" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('jadwal-mapel.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
