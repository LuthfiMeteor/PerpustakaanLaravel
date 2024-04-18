<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentarModel extends Model
{
    use HasFactory;
    protected $table = 'komentar';
    protected $guarded = [];

    public function KomentarOleh()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
