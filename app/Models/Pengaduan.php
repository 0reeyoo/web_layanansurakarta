<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduans';

    protected $fillable = [
        'user_id',
        'nama_pelapor',
        'ktp',
        'no_telp',
        'alamat_pelapor',
        'kategori',
        'dinas',
        'tanggal_kejadian',
        'deskripsi',
        'latitude',
        'longitude',
        'foto_bukti',
        'bukti_selesai',
        'status',
    ];

    protected $casts = [
        'tanggal_kejadian' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Daftar kategori dan dinas yang terkait
     */
    public static function getCategories()
    {
        $defaults = [
            'Jalan Rusak' => 'PUPR',
            'Penerangan Jalan' => 'PUPR',
            'Trotoar/Drainase Rusak' => 'PUPR',
            'Sampah/TPA Penuh' => 'DLH',
            'Air dan Sanitasi' => 'DLH',
            'Lampu Lalu Lintas Rusak' => 'PERHUBUNGAN',
            'Transportasi' => 'PERHUBUNGAN',
        ];

        if (! Schema::hasTable('kategori_pengaduans')) {
            return $defaults;
        }

        $dynamic = KategoriPengaduan::where('is_active', true)
            ->orderBy('dinas')
            ->orderBy('nama')
            ->get(['nama', 'dinas'])
            ->mapWithKeys(fn ($item) => [$item->nama => $item->dinas])
            ->toArray();

        return array_merge($defaults, $dynamic);
    }

    public static function getDinas()
    {
        return [
            'PUPR' => 'Dinas Pekerjaan Umum dan Penataan Ruang',
            'DLH' => 'Dinas Lingkungan Hidup',
            'PERHUBUNGAN' => 'Dinas Perhubungan',
        ];
    }
}
