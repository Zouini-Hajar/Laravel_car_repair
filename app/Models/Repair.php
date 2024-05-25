<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'start_date',
        'end_date',
        'mechanic_notes',
        'mechanic_id',
        'vehicle_id',
    ];
}
