<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Costume;

class KatalogController extends Controller
{
    public function index()
    {
        // Hanya ambil kostum yang stoknya lebih dari 0 DAN kondisinya bukan 'rusak'
        $costumes = Costume::where('stock', '>', 0)
                           ->where('condition', '!=', 'rusak')
                           ->get();
                           
        return view('katalog', compact('costumes'));
    }
}