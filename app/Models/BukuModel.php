<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuModel extends Model
{
    use HasFactory;
    protected $table = 'buku';
    protected $guarded = [];

    public function Kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori', 'id');
    }
    public function favorit()
    {
        return $this->hasOne(FavoritModel::class, 'id', 'buku_id');
    }
    public function komentar()
    {
        return $this->hasOne(KomentarModel::class, 'buku_id', 'id');
    }
}
