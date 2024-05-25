<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairDetails extends Model
{
    use HasFactory;

    public $table = 'repairs_details';

    protected $fillable = [
        'description',
        'price'
    ];
}
