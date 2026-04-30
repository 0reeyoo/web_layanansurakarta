<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where(function ($query) {
            $query->where('role', 'warga')
                ->orWhereNull('role');
        })->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->with('error', 'Akun admin tidak ditampilkan dan tidak bisa dihapus dari menu ini.');
        }

        if ((string) $user->id === (string) auth()->id()) {
            return back()->with('error', 'Akun admin yang sedang login tidak bisa dihapus.');
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
