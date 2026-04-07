<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'action', 'description'];

    // Relasi untuk mengetahui siapa pelakunya
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // FUNGSI SUPER: Alat pencatat otomatis yang bisa dipanggil dari mana saja!
    public static function record($action, $description = null)
    {
        self::create([
            'user_id' => Auth::id(), // Otomatis mendeteksi siapa yang sedang login
            'action' => $action,
            'description' => $description
        ]);
    }
}