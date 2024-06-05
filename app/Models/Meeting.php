<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'mechanic_id',
        'vehicle_id',
        'date',
        'time',
        'status'
    ];
}
