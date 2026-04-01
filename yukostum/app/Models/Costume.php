<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Costume extends Model
{
    // Tambahkan baris ini agar data boleh diisi dari website:
    protected $fillable = [
        'name', 'material', 'size', 'color', 'origin', 'type', 'stock', 'condition'
    ];
}
