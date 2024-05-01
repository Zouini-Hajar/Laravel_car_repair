<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparePartController extends Controller
{
    // Show all spare parts
    public function index() {
        return view('spareparts.index', [
            'spareparts' => Sparepart::all(['id', 'name', 'reference', 'stock', 'price', 'picture'])
        ]);
    }

    // Show single spare part
    public function show(Sparepart $sparepart) {
        return view('spareparts.show', [
            'sparePart' => $sparepart
        ]);
    }
}
