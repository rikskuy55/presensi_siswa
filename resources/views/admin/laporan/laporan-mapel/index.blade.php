@extends('layouts.index')

@section('title', 'Laporan Mata Pelajaran')

@section('judulkonten', 'Laporan Mata Pelajaran')

@section('isikonten')
<div class="d-flex justify-content-end mt-3">
    <a href="{{ route('laporan-mapel.pdf') }}" class="btn btn-success btn-round me-3">
        <i class="fa fa-print"></i> Cetak Laporan
    </a>
</div>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Tanggal</th>
            <th>Mata Pelajaran</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($presensiMapel as $index => $presensi)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $presensi->siswa->nama_siswa }}</td>
            <td>{{ $presensi->tanggal }}</td>
            <td>{{ $presensi->mataPelajaran ? $presensi->mataPelajaran->nama_mata_pelajaran : 'Tidak Ada Mata Pelajaran' }}</td>
            <td>{{ $presensi->jam_masuk }}</td>
            <td>{{ $presensi->jam_keluar }}</td>
            <td>{{ $presensi->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
