@extends('layouts.admin')

@section('content')
@php
    $statusClass = match($pengaduan->status) {
        'Menunggu' => 'bg-amber-100 text-amber-700',
        'Diproses' => 'bg-sky-100 text-sky-700',
        'Selesai' => 'bg-emerald-100 text-emerald-700',
        default => 'bg-slate-100 text-slate-700',
    };
    $updateStatusRoute = match (optional(auth()->user())->dinas_role) {
        'PUPR' => route('admin-pupr.pengaduan.updateStatus', $pengaduan->id),
        'DLH' => route('admin-dlh.pengaduan.updateStatus', $pengaduan->id),
        'PERHUBUNGAN' => route('admin-perhubungan.pengaduan.updateStatus', $pengaduan->id),
        default => route('admin.pengaduan.updateStatus', $pengaduan->id),
    };
@endphp

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Pengaduan #{{ $pengaduan->id }}</p>
            <h3 class="text-2xl font-extrabold text-navy-900">Detail Laporan Pengaduan</h3>
            <p class="text-sm text-slate-500 mt-1">Lokasi, foto bukti, dan informasi pelapor.</p>
        </div>
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border text-slate-700 hover:bg-slate-50">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-5">
                    <h4 class="text-lg font-bold text-navy-900">Informasi Kejadian</h4>
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusClass }}">{{ $pengaduan->status }}</span>
                </div>

                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="bg-slate-50 rounded-xl p-4">
                        <dt class="text-slate-500 mb-1">Pelapor</dt>
                        <dd class="font-bold text-navy-900">{{ $pengaduan->nama_pelapor }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <dt class="text-slate-500 mb-1">NIK / KTP</dt>
                        <dd class="font-bold text-navy-900">{{ $pengaduan->ktp }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <dt class="text-slate-500 mb-1">No. Telepon</dt>
                        <dd class="font-bold text-navy-900">{{ $pengaduan->no_telp ?: '-' }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <dt class="text-slate-500 mb-1">Kategori</dt>
                        <dd class="font-bold text-navy-900">{{ $pengaduan->kategori }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 md:col-span-2">
                        <dt class="text-slate-500 mb-1">Alamat Pelapor</dt>
                        <dd class="font-bold text-navy-900">{{ $pengaduan->alamat_pelapor ?: '-' }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <dt class="text-slate-500 mb-1">Tanggal Kejadian</dt>
                        <dd class="font-bold text-navy-900">{{ optional($pengaduan->tanggal_kejadian)->translatedFormat('d F Y') }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <dt class="text-slate-500 mb-1">Koordinat</dt>
                        <dd class="font-bold text-navy-900">{{ $pengaduan->latitude && $pengaduan->longitude ? $pengaduan->latitude . ', ' . $pengaduan->longitude : '-' }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 md:col-span-2">
                        <dt class="text-slate-500 mb-1">Deskripsi Laporan</dt>
                        <dd class="text-navy-900 whitespace-pre-line leading-relaxed">{{ $pengaduan->deskripsi }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h4 class="text-lg font-bold text-navy-900 mb-4">Lokasi Kejadian</h4>
                @if($pengaduan->latitude && $pengaduan->longitude)
                    <div class="rounded-xl overflow-hidden border border-slate-200">
                        <iframe
                            width="100%"
                            height="360"
                            loading="lazy"
                            src="https://maps.google.com/maps?q={{ $pengaduan->latitude }},{{ $pengaduan->longitude }}&hl=id&z=15&output=embed">
                        </iframe>
                    </div>
                @else
                    <div class="rounded-xl bg-slate-50 border border-dashed border-slate-300 p-10 text-center text-slate-500">
                        Data lokasi tidak tersedia untuk laporan ini.
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h4 class="text-lg font-bold text-navy-900 mb-4">Foto Bukti</h4>
                @if($pengaduan->foto_bukti)
                    <a href="{{ asset('storage/' . $pengaduan->foto_bukti) }}" target="_blank" class="block">
                        <img src="{{ asset('storage/' . $pengaduan->foto_bukti) }}" alt="Foto Bukti" class="w-full rounded-xl border border-slate-200">
                    </a>
                    <p class="text-xs text-slate-500 mt-2">Klik gambar untuk membuka ukuran penuh.</p>
                @else
                    <div class="rounded-xl bg-slate-50 border border-dashed border-slate-300 p-10 text-center text-slate-500">
                        Tidak ada lampiran gambar.
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h4 class="text-lg font-bold text-navy-900 mb-3">Update Status</h4>
                <form action="{{ $updateStatusRoute }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <select name="status" class="w-full border border-slate-300 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy-300">
                        <option value="Menunggu" @selected($pengaduan->status == 'Menunggu')>Menunggu</option>
                        <option value="Diproses" @selected($pengaduan->status == 'Diproses')>Diproses</option>
                        <option value="Selesai" @selected($pengaduan->status == 'Selesai')>Selesai</option>
                    </select>
                    <div>
                        <label class="text-xs font-semibold text-slate-600 block mb-1">Bukti Penyelesaian (Opsional)</label>
                        <input type="file" name="bukti_selesai" accept="image/*" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm">
                    </div>
                    <button type="submit" class="w-full bg-navy-700 text-white font-bold py-2.5 rounded-xl hover:bg-navy-800">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
