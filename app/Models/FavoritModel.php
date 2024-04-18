<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoritModel extends Model
{
    use HasFactory;
    protected $table = 'favorit';
    protected $guarded = [];
}
