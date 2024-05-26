<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairSparePart extends Model
{
    use HasFactory;

    public $table = 'repair_spareparts';

    protected $fillable = [
        'repair_id',
        'sparepart_id',
        'quantity'
    ];
}
