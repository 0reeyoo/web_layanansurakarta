<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class KontenWeb extends Model
{
    use HasFactory;

    protected $table = 'konten_webs';

    protected $fillable = [
        'tipe',
        'judul',
        'deskripsi',
        'gambar',
        'published_at',
        'user_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Mendapatkan URL lengkap untuk gambar konten
     */
    public function getGambarUrlAttribute()
    {
        if (!$this->gambar) return null;
        return Storage::disk('public')->url($this->gambar);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
