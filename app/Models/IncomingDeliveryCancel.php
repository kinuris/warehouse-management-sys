<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingDeliveryCancel extends Model
{
    protected $table = 'incoming_delivery_cancels';
    protected $fillable = [
        'incoming_delivery_id',
    ];

    use HasFactory;
}
