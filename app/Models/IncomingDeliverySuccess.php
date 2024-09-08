<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingDeliverySuccess extends Model
{
    protected $table = 'incoming_delivery_successes';
    protected $fillable = [
        'incoming_delivery_id',
    ];

    use HasFactory;
}
