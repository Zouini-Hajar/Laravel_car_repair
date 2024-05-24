<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    protected $fillable = [
        'picture',
        'name',
        'reference',
        'price',
        'stock',
        'supplier_id'
    ];
}
