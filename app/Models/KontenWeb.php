<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
