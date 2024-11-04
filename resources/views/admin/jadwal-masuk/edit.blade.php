@extends('layouts.index')

@section('title', 'Edit Jadwal Masuk Sekolah')

@section('judulkonten', 'Edit Jadwal Masuk Sekolah')

@section('isikonten')
    <div class="container">
        <form action="{{ route('jadwal-masuk.update', $jadwalMasuk->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Use PUT method for updating --}}

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Dropdown for selecting Class --}}
            <div class="mb-3">
                <label for="kelas_id" class="form-label">Kelas</label>
                <select name="kelas_id" class="form-control" required>
                    <option value="" disabled selected>Pilih Kelas</option>
                    @foreach($kelas as $kelasItem)
                        <option value="{{ $kelasItem->id }}" {{ $jadwalMasuk->kelas_id == $kelasItem->id ? 'selected' : '' }}>
                            {{ $kelasItem->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Dropdown for selecting Day --}}
            <div class="mb-3">
                <label for="hari" class="form-label">Hari</label>
                <select name="hari" class="form-control" required>
                    <option value="" disabled selected>Pilih Hari</option>
                    <option value="Senin" {{ $jadwalMasuk->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                    <option value="Selasa" {{ $jadwalMasuk->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                    <option value="Rabu" {{ $jadwalMasuk->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                    <option value="Kamis" {{ $jadwalMasuk->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                    <option value="Jumat" {{ $jadwalMasuk->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                </select>
            </div>

            {{-- Input for start time (Jam Masuk) --}}
            <div class="mb-3">
                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                <input type="time" class="form-control" name="jam_masuk" value="{{ $jadwalMasuk->jam_masuk }}" required>
            </div>

            {{-- Input for end time (Jam Keluar) --}}
            <div class="mb-3">
                <label for="jam_keluar" class="form-label">Jam Keluar</label>
                <input type="time" class="form-control" name="jam_keluar" value="{{ $jadwalMasuk->jam_keluar }}" required>
            </div>

            {{-- Submit button --}}
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('jadwal-masuk.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
