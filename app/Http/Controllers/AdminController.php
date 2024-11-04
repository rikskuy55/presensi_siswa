<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak ditemukan dalam sistem.',
        ]);

        // Generate password baru
        $newPassword = Str::random(8); // Contoh password acak
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($newPassword);
        $user->save();

        // Kirim password baru ke email siswa (opsional)
        // Mail::to($user->email)->send(new NewPasswordMail($newPassword));

        return back()->with('status', 'Password berhasil direset untuk email: ' . $user->email . '. Password baru: ' . $newPassword);
    }
}
