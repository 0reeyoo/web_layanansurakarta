@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-[#1e3a8a] text-white p-6 rounded-t-2xl shadow-lg">
        <h2 class="text-2xl font-bold">Form Pengaduan</h2>
        <p class="text-blue-100 opacity-90 text-sm">Lengkapi data berikut untuk mengajukan pengaduan</p>
    </div>

    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-b-2xl shadow-xl p-8 space-y-10 border-x border-b border-gray-100">
        @csrf
        @php($user = auth()->user())
        @if($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-semibold mb-1">Pengaduan belum bisa dikirim. Mohon lengkapi data berikut:</p>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="space-y-6">
            <div class="flex items-center gap-3 pb-2 border-b border-gray-100">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                <h3 class="text-lg font-bold text-gray-800">Data Pelapor</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama" value="{{ old('nama', optional($user)->name) }}" placeholder="Masukkan nama lengkap" required readonly class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition bg-gray-50/50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">KTP *</label>
                    <input type="text" name="ktp" value="{{ old('ktp', optional($user)->nik) }}" placeholder="16 digit KTP" required readonly class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition bg-gray-50/50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon *</label>
                    <input type="text" name="telp" value="{{ old('telp', optional($user)->no_hp) }}" placeholder="08xxxxxxxxxx" required readonly class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition bg-gray-50/50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat *</label>
                    <input type="text" name="alamat" value="{{ old('alamat', optional($user)->alamat) }}" placeholder="Alamat tempat tinggal" required readonly class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition bg-gray-50/50">
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <div class="flex items-center gap-3 pb-2 border-b border-gray-100">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                <h3 class="text-lg font-bold text-gray-800">Detail Pengaduan</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                    <select name="kategori" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition bg-gray-50/50">
                        <option selected disabled>Pilih kategori</option>
                        @foreach(App\Models\Pengaduan::getCategories() as $kategori => $dinas)
                            <option value="{{ $kategori }}">{{ $kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Pengaduan *</label>
                <textarea name="deskripsi" rows="4" placeholder="Jelaskan detail pengaduan Anda..." required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition bg-gray-50/50"></textarea>
            </div>
        </section>

        <section class="space-y-4">
            <label class="block text-sm font-medium text-gray-700 font-bold">Pilih Lokasi Kejadian di Peta *</label>
            
            <!-- Search Box -->
            <div class="relative z-[1100]">
                <div class="relative z-[1100]">
                    <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></path></svg>
                    <input 
                        type="text" 
                        id="search-location" 
                        placeholder="Cari Alamat..." 
                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none transition bg-gray-50/50 z-10"
                    >
                </div>
                <!-- Search Results Dropdown -->
                <div id="search-results" class="absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-xl shadow-lg mt-2 max-h-64 overflow-y-auto hidden z-[1200]">
                </div>
            </div>

            <!-- Map -->
            <div id="map" class="w-full h-80 rounded-2xl border border-gray-200 relative z-0"></div>
            
            <!-- Selected Location Info -->
            <div id="location-info" class="hidden bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <p class="text-sm font-medium text-gray-700">Lokasi Terpilih:</p>
                <p id="selected-location-text" class="text-blue-600 font-bold mt-1">Klik pada peta atau cari lokasi</p>
            </div>

            <input type="hidden" name="lat" id="lat" required>
            <input type="hidden" name="lng" id="lng" required>
        </section>

        <section class="space-y-4">
            <label class="block text-sm font-medium text-gray-700 font-bold">Unggah Foto/Gambar Kejadian *</label>
            <div class="relative group border-2 border-dashed border-gray-300 rounded-2xl bg-gray-50 hover:bg-gray-100 transition-all p-8 text-center" id="drop-zone">
                <img id="image-preview" src="#" alt="Preview" class="hidden mx-auto max-h-64 mb-4 rounded-xl shadow-lg border-2 border-white">
                
                <div id="placeholder-content">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <p class="text-gray-600 font-bold">Klik atau seret gambar di sini</p>
                    <p class="text-xs text-gray-400 mt-1">PNG, JPG, WebP (Maks 10 MB per file)</p>
                </div>

                <input type="file" name="foto" id="foto-input" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
            </div>
        </section>

        <div class="flex flex-col sm:flex-row gap-4 pt-6">
            <a href="{{ route('home') }}" class="flex-1 px-8 py-4 rounded-xl border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 transition text-center">Batal</a>
            <button type="submit" class="flex-1 px-8 py-4 rounded-xl bg-[#2563eb] text-white font-bold hover:bg-blue-700 shadow-lg flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                Kirim Pengaduan
            </button>
        </div>
    </form>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Logika Peta
    const map = L.map('map').setView([-7.5666, 110.8243], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    
    let marker;
    const latInput = document.getElementById('lat');
    const lngInput = document.getElementById('lng');
    const searchInput = document.getElementById('search-location');
    const searchResults = document.getElementById('search-results');
    const locationInfo = document.getElementById('location-info');
    const selectedLocationText = document.getElementById('selected-location-text');

    // Fungsi untuk update marker dan info
    function setLocation(lat, lng, locationName = null) {
        if (marker) marker.setLatLng([lat, lng]);
        else marker = L.marker([lat, lng]).addTo(map);
        
        latInput.value = lat;
        lngInput.value = lng;
        
        map.setView([lat, lng], 15);
        
        locationInfo.classList.remove('hidden');
        selectedLocationText.textContent = locationName || `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    }

    // Click pada map
    map.on('click', function(e) {
        setLocation(e.latlng.lat, e.latlng.lng);
        searchResults.classList.add('hidden');
    });

    // Debounce untuk search
    let searchTimeout;
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const query = e.target.value.trim();
        
        if (query.length < 3) {
            searchResults.classList.add('hidden');
            return;
        }

        searchTimeout = setTimeout(async () => {
            const scopedQuery = `${query}, Surakarta, Jawa Tengah`;
            const scopedUrl = `https://nominatim.openstreetmap.org/search?format=jsonv2&addressdetails=1&countrycodes=id&accept-language=id&limit=8&q=${encodeURIComponent(scopedQuery)}&viewbox=110.70,-7.65,110.92,-7.49&bounded=1`;
            const fallbackUrl = `https://nominatim.openstreetmap.org/search?format=jsonv2&addressdetails=1&countrycodes=id&accept-language=id&limit=8&q=${encodeURIComponent(query + ', Indonesia')}`;

            const fetchLocations = async (url) => {
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }
                return response.json();
            };

            try {
                let data = await fetchLocations(scopedUrl);
                if (!Array.isArray(data) || data.length === 0) {
                    data = await fetchLocations(fallbackUrl);
                }

                searchResults.innerHTML = '';
                
                if (!Array.isArray(data) || data.length === 0) {
                    searchResults.innerHTML = '<div class="p-4 text-gray-500 text-sm">Lokasi tidak ditemukan</div>';
                } else {
                    data.forEach(result => {
                        const mainName = result.name || result.display_name?.split(',')[0] || 'Lokasi';
                        const subText = result.display_name || '';
                        const div = document.createElement('div');
                        div.className = 'p-3 hover:bg-blue-50 cursor-pointer border-b last:border-b-0 text-sm';
                        div.innerHTML = `
                            <p class="font-medium text-gray-800">${mainName}</p>
                            <p class="text-xs text-gray-500">${subText}</p>
                        `;
                        div.addEventListener('click', () => {
                            setLocation(parseFloat(result.lat), parseFloat(result.lon), result.display_name || mainName);
                            searchResults.classList.add('hidden');
                            searchInput.value = result.display_name || mainName;
                        });
                        searchResults.appendChild(div);
                    });
                }
                
                searchResults.classList.remove('hidden');
            } catch (error) {
                console.error('Error:', error);
                searchResults.innerHTML = '<div class="p-4 text-red-500 text-sm">Gagal mencari lokasi</div>';
                searchResults.classList.remove('hidden');
            }
        }, 500);
    });

    // Tutup search results saat klik di luar
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#search-location') && !e.target.closest('#search-results')) {
            searchResults.classList.add('hidden');
        }
    });

    // LOGIKA UNGGAH FOTO (FIXED)
    const fotoInput = document.getElementById('foto-input');
    const imagePreview = document.getElementById('image-preview');
    const placeholderContent = document.getElementById('placeholder-content');
    const dropZone = document.getElementById('drop-zone');

    fotoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // Validasi Ukuran (Maks 10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert("File terlalu besar! Maksimal 10MB.");
                this.value = "";
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                // Ganti sumber gambar preview dengan data file yang dipilih
                imagePreview.src = e.target.result;
                
                // Munculkan Gambar & Sembunyikan Placeholder
                imagePreview.classList.remove('hidden');
                placeholderContent.classList.add('hidden');
                
                // Ubah gaya border menjadi biru agar terlihat aktif
                dropZone.classList.add('border-blue-500', 'bg-blue-50');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
