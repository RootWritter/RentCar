<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentData extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'user_id',
        'date_start_rent',
        'est_rent',
        'price',
        'price_correction',
        'date_end_rent',
    ];
}
