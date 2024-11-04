@extends('siswa.layouts.index')

@section('title', 'Absensi Siswa - Profile')

<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Profile</div>
    <div class="right"></div>
</div>
<!-- * App Header -->

@section('content')
    <style>
        .profile-container {
            background-color: #54A6FF;
            border-radius: 10px;
            padding: 20px;
        }

        .profile-header {
            display: flex;
            flex-direction: column; /* Arrange elements vertically */
            align-items: center; /* Center align items horizontally */
            justify-content: center; /* Center align items vertically */
            text-align: center;
        }

        .profile-picture {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }

        .profile-info {
            flex-grow: 1;
            margin-left: 10px;
            content: center; /* Center align items vertically */

        }

        .edit-profile-btn {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
        }

        .profile-details {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            color: #ffffff
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            color: #ffffff
            border: 1px solid #ccc;
        }
    </style>

    <div class="row" style="margin-top: 70px; padding: 16px; margin-bottom: 70px;">
        <div class="col">
            <div class="profile-container">
                <div class="profile-header">
                    @if (auth()->user()->siswa && auth()->user()->siswa->foto)
                        <img src="{{ asset('storage/' . auth()->user()->siswa->foto) }}" alt="User Image"
                            class="avatar-img rounded-circle imaged w128 rounded" style="height: 128px" />
                    @else
                        <img src="{{ asset('assets/images/smkn1cmh.png') }}" alt="Default Image"
                            class="avatar-img rounded-circle imaged w64 rounded" />
                    @endif
                    <div class="profile-info">
                        <h2 id="user-name" style="margin-top: 20px;">{{ auth()->user()->siswa->nama_siswa }}</h2>
                        <h3 id="user-role">{{ auth()->user()->siswa->kelas->nama_kelas }}</h3>
                        </div>
                    <a href="{{ url('profile/edit') }}" class="edit-profile-btn">Pengaturan Akun</a>
                </div>

                <!-- Personal Details -->
                <div class="profile-details">
                    <div class="form-group">
                        <label>NISN</label>
                        <input type="text" value="{{ auth()->user()->siswa->nisn }}" readonly class="form-control text-white font-weight-semibold">
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" value="{{ auth()->user()->siswa->nama_siswa }}"  class="form-control text-white font-weight-semibold">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <input type="text" value="{{ auth()->user()->siswa->jenis_kelamin }}" readonly class="form-control text-white font-weight-semibold">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="text" value="{{ \Carbon\Carbon::parse(auth()->user()->siswa->tanggal_lahir)->format('d-m-Y') }}" readonly class="form-control text-white font-weight-semibold">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" value="{{ auth()->user()->siswa->alamat }}" readonly class="form-control text-white font-weight-semibold">
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" value="{{ auth()->user()->siswa->kelas->nama_kelas }}" readonly class="form-control text-white font-weight-semibold">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
