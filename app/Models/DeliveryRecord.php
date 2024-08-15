<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryRecord extends Model
{
    use HasFactory;

    protected $table = 'delivery_records'; 

    protected $fillable = [
        'order_id',
        'delivery_time',
        'image_link',
    ];
}
