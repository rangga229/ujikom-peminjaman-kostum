<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    // Mengizinkan data ini diisi dari website
    protected $fillable = [
        'user_id', 'costume_id', 'borrow_date', 'return_date', 'status'
    ];

    // Relasi: Peminjaman ini milik Kostum apa? (Agar nanti namanya bisa dipanggil)
    public function costume()
    {
        return $this->belongsTo(Costume::class);
    }
}