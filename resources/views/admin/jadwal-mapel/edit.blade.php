@extends('layouts.index')

@section('title', 'Edit Jadwal Mengajar')

@section('judulkonten', 'Edit Jadwal Mengajar')

@section('isikonten')
    <div class="container">
        <form action="{{ route('jadwal-mapel.update', $jadwalMapel->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Tambahkan ini untuk mengindikasikan bahwa ini adalah permintaan update --}}

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
                        <option value="{{ $guruMapel->id }}" {{ $jadwalMapel->guru_mapel_id == $guruMapel->id ? 'selected' : '' }}>
                            {{ $guruMapel->kelas->nama_kelas }} - {{ $guruMapel->guru->nama_guru }} - {{ $guruMapel->mataPelajaran->nama_mata_pelajaran }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="hari" class="form-label">Hari</label>
                <select name="hari" class="form-control" required>
                    <option value="" disabled selected>Pilih Hari</option>
                    <option value="Senin" {{ $jadwalMapel->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                    <option value="Selasa" {{ $jadwalMapel->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                    <option value="Rabu" {{ $jadwalMapel->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                    <option value="Kamis" {{ $jadwalMapel->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                    <option value="Jumat" {{ $jadwalMapel->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                <input type="time" class="form-control" name="jam_mulai" value="{{ $jadwalMapel->jam_mulai }}" required>
            </div>

            <div class="mb-3">
                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                <input type="time" class="form-control" name="jam_selesai" value="{{ $jadwalMapel->jam_selesai }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('jadwal-mapel.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
