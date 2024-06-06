<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'email',
        'phone_number',
        'cin',
        'user_id',
        'recruitment_date',
        'salary'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
