<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('siswa.profile.profile');    
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('siswa.profile.edit', compact('user'));    
    }
}
