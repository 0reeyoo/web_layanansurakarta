@extends('layouts.admin')

@section('content')
@if(session('success'))
    <div class="mb-4 bg-emerald-100 text-emerald-700 px-4 py-3 rounded">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
@endif

<div class="bg-white rounded-xl border overflow-x-auto">
    <div class="p-4 border-b"><h3 class="font-bold">Manajemen Pengguna</h3></div>
    <table class="w-full text-sm">
        <thead class="bg-slate-50">
            <tr>
                <th class="p-3 text-left">Nama</th>
                <th class="p-3 text-left">Email</th>
                <th class="p-3 text-left">Role</th>
                <th class="p-3 text-left">Terdaftar</th>
                <th class="p-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr class="border-t">
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">{{ $user->role ?? 'warga' }}</td>
                    <td class="p-3">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="p-3">
                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td class="p-3 text-slate-500" colspan="5">Belum ada pengguna.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $users->links() }}</div>
</div>
@endsection
