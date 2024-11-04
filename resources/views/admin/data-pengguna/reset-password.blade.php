@extends('layouts.index')

@section('title', 'Reset Password')

@section('judulkonten', 'Reset Password')

@section('isikonten')
    <div class="container">
        <h1>Reset Password Siswa</h1>
        
        <!-- Menampilkan pesan jika ada -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <!-- Form untuk memasukkan email siswa -->
        <form method="POST" action="{{ route('admin.reset-password') }}">
            @csrf
            <div class="form-group">
                <label for="email">Masukkan Email Siswa</label>
                <input type="email" name="email" id="email" class="form-control" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
    </div>
@endsection
