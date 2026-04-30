@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-8">
    <div class="flex items-center gap-3 mb-6 border-b pb-4">
        <div class="bg-blue-100 p-2 rounded-full">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Visi & Misi Platform</h2>
    </div>

    <div class="space-y-8">
        <section>
            <h3 class="text-xl font-semibold text-gray-800 mb-3">Visi</h3>
            <p class="text-gray-600 leading-relaxed text-lg">
                Menjadi platform digital terintegrasi yang mewujudkan pelayanan publik di Kota Surakarta yang lebih responsif, transparan, dan efektif melalui pemanfaatan teknologi informasi.
            </p>
        </section>

        <section>
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Misi</h3>
            <ul class="space-y-4">
                <li class="flex gap-4 items-start">
                    <div class="mt-1 bg-green-100 p-1 rounded-full">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 text-lg">Mempermudah partisipasi masyarakat dalam melaporkan kerusakan infrastruktur publik secara cepat melalui sistem berbasis web.</p>
                </li>
                <li class="flex gap-4 items-start">
                    <div class="mt-1 bg-green-100 p-1 rounded-full">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 text-lg">Meningkatkan akurasi data lokasi pelaporan dengan mengintegrasikan teknologi geolocation dan Maps API.</p>
                </li>
                <li class="flex gap-4 items-start">
                    <div class="mt-1 bg-green-100 p-1 rounded-full">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 text-lg">Meningkatkan efisiensi pengelolaan dan monitoring laporan oleh pemerintah daerah melalui penyediaan database yang terstruktur dan dashboard real-time.</p>
                </li>
                <li class="flex gap-4 items-start">
                    <div class="mt-1 bg-green-100 p-1 rounded-full">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 text-lg">Mempercepat proses penanganan kerusakan fasilitas publik dengan menghubungkan sistem pelaporan langsung kepada pihak admin dan tim teknis terkait.</p>
                </li>
            </ul>
        </section>
    </div>
</div>
@endsection