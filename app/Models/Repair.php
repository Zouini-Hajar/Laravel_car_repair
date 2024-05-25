<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_details_id',
        'mechanic_id',
        'vehicle_id',
        'invoice_id',
        'status',
        'start_date',
        'end_date',
        'mechanic_notes',
    ];
}
