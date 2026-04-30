@extends('layouts.app')

@section('content')
<div class="relative -mx-4 sm:-mx-6 lg:-mx-8 -mt-10 mb-12 text-center">
    @php
        $slides = collect($galeriSlides ?? [])->filter(fn($item) => !empty($item->gambar))->values();

        $hour = date('H');
        if ($hour >= 5 && $hour < 11) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($hour >= 15 && $hour < 19) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }
        $name = Auth::check() ? Auth::user()->name : 'Tamu';
    @endphp

    <div class="relative overflow-hidden min-h-[440px] flex items-center justify-center">
        @if($slides->isNotEmpty())
            <div id="hero-slides" class="absolute inset-0">
                @foreach($slides as $index => $slide)
                    <div class="hero-slide absolute inset-0 bg-center bg-cover transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                         style="background-image: url('{{ asset('storage/' . $slide->gambar) }}');"></div>
                @endforeach
            </div>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-[#1e3a8a] via-[#1d4ed8] to-[#0f172a]"></div>
        @endif

        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/45 to-black/60"></div>

        <div class="relative z-10 px-6 py-12 max-w-4xl mx-auto">
            <h2 class="text-3xl md:text-5xl font-extrabold mb-2 text-white leading-tight drop-shadow">
                {{ $greeting }}, {{ $name }}!
            </h2>
            <p class="text-blue-200 text-xl font-bold mb-6 drop-shadow-sm">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            <p class="text-slate-100 max-w-2xl mx-auto leading-relaxed mb-10 text-lg">
                Sampaikan laporan kerusakan fasilitas publik secara akurat demi pelayanan kota yang lebih cepat dan transparan.
            </p>

            <div class="flex justify-center mb-6">
                <a href="{{ route('pengaduan.create') }}" class="bg-[#2563eb] hover:bg-blue-700 text-white font-semibold py-4 px-10 rounded-xl shadow-lg shadow-blue-900/30 transition-all duration-300 transform hover:-translate-y-1 flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="text-lg">Buat Pengaduan</span>
                </a>
            </div>
        </div>
    </div>
</div>

<hr class="mb-12 border-gray-200">

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-12">
    @php
        // Nantinya variabel count ini akan diambil dari Database di Controller
        $stats = [
            ['label' => 'Total Aduan', 'count' => ($stats['total'] ?? 0), 'color' => 'blue', 'icon' => '📄'],
            ['label' => 'Menunggu', 'count' => ($stats['menunggu'] ?? 0), 'color' => 'yellow', 'icon' => '⏰'],
            ['label' => 'Diproses', 'count' => ($stats['diproses'] ?? 0), 'color' => 'sky', 'icon' => '⚙️'],
            ['label' => 'Selesai', 'count' => ($stats['selesai'] ?? 0), 'color' => 'green', 'icon' => '✅'],
        ];
    @endphp

    @foreach($stats as $stat)
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="text-3xl p-3 rounded-xl shadow-inner 
            @if($stat['color'] == 'blue') bg-blue-50 @elseif($stat['color'] == 'yellow') bg-yellow-50 @elseif($stat['color'] == 'sky') bg-sky-50 @else bg-green-50 @endif">
            {{ $stat['icon'] }}
        </div>
        <div>
            <p class="text-gray-500 text-xs uppercase tracking-wider font-semibold">{{ $stat['label'] }}</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stat['count'] }}</p>
        </div>
    </div>
    @endforeach
</div>

<div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
    <h3 class="text-xl font-bold mb-8 flex items-center gap-2 text-gray-800">
        <span class="w-2 h-8 bg-blue-600 rounded-full"></span>
        Tatacara Pengaduan
    </h3>
    
    <div class="grid grid-cols-1 gap-4">
        <div class="flex items-start gap-6 p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-md transition group">
            <span class="flex-shrink-0 bg-blue-100 text-blue-600 w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm group-hover:bg-blue-600 group-hover:text-white transition">1</span>
            <div>
                <h4 class="font-bold text-lg mb-1 text-gray-800">Akses Website</h4>
                <p class="text-gray-600 text-sm leading-relaxed">Masyarakat mengakses sistem pelaporan melalui portal website resmi untuk memulai proses pengaduan.</p>
            </div>
        </div>

        <div class="flex items-start gap-6 p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-md transition group">
            <span class="flex-shrink-0 bg-green-100 text-green-600 w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm group-hover:bg-green-600 group-hover:text-white transition">2</span>
            <div>
                <h4 class="font-bold text-lg mb-1 text-gray-800">Isi Formulir Laporan</h4>
                <p class="text-gray-600 text-sm leading-relaxed">Pengguna mengisi formulir laporan kerusakan yang tersedia pada sistem dengan data diri lengkap.</p>
            </div>
        </div>

        <div class="flex items-start gap-6 p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-md transition group">
            <span class="flex-shrink-0 bg-orange-100 text-orange-600 w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm group-hover:bg-orange-600 group-hover:text-white transition">3</span>
            <div>
                <h4 class="font-bold text-lg mb-1 text-gray-800">Lengkapi Informasi</h4>
                <p class="text-gray-600 text-sm leading-relaxed">Pelapor menyertakan deskripsi detail mengenai kerusakan dan mengunggah foto kondisi infrastruktur tersebut.</p>
            </div>
        </div>

        <div class="flex items-start gap-6 p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-md transition group">
            <span class="flex-shrink-0 bg-sky-100 text-sky-600 w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm group-hover:bg-sky-600 group-hover:text-white transition">4</span>
            <div>
                <h4 class="font-bold text-lg mb-1 text-gray-800">Penentuan Lokasi Otomatis</h4>
                <p class="text-gray-600 text-sm leading-relaxed">Sistem akan mengambil koordinat lokasi kejadian secara otomatis menggunakan teknologi geolocation atau pemilihan pada peta.</p>
            </div>
        </div>

        <div class="flex items-start gap-6 p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-md transition group">
            <span class="flex-shrink-0 bg-purple-100 text-purple-600 w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm group-hover:bg-purple-600 group-hover:text-white transition">5</span>
            <div>
                <h4 class="font-bold text-lg mb-1 text-gray-800">Pantau Riwayat</h4>
                <p class="text-gray-600 text-sm leading-relaxed">Setelah terkirim, Anda dapat memantau perkembangan laporan Anda melalui menu <strong>Riwayat</strong> secara berkala.</p>
            </div>
        </div>
    </div>
</div>

@if($slides->count() > 1)
<script>
    (function () {
        const slides = document.querySelectorAll('#hero-slides .hero-slide');
        let active = 0;

        setInterval(() => {
            slides[active].classList.remove('opacity-100');
            slides[active].classList.add('opacity-0');

            active = (active + 1) % slides.length;

            slides[active].classList.remove('opacity-0');
            slides[active].classList.add('opacity-100');
        }, 5000);
    })();
</script>
@endif
@endsection

