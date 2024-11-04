@extends('layouts.index')

@section('title', 'Pengaturan Akun')

@section('judulkonten', 'Pengaturan Akun')

@section('isikonten')
<div class="container">
    <h2>Pengaturan Akun</h2>
    
    <form action="#" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
        </div>

        {{-- Email --}}
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
        </div>

        {{-- Ubah Kata Sandi --}}
        <div class="form-group">
            <label for="password">Kata Sandi Baru</label>
            <input type="password" class="form-control" id="password" name="password">
            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah kata sandi.</small>
        </div>

        {{-- Foto Profil --}}
        <div class="form-group">
            <label for="profile_picture">Foto Profil</label>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
