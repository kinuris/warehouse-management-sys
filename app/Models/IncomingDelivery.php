<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingDelivery extends Model
{
    protected $table = 'incoming_deliveries';
    protected $fillable = [
        'distributor',
        'product_id',
        'quantity',
        'delivery',
    ];

    public function status() {
        if (IncomingDeliverySuccess::query()->where('incoming_delivery_id', $this->id)->exists()) {
            return 'delivered'; 
        } else if (IncomingDeliveryCancel::query()->where('incoming_delivery_id', $this->id)->exists()) {
            return 'cancelled';
        } else {
            return 'pending';
        }
    }

    public function deliveryDate(): null | DateTime {
        if (IncomingDeliverySuccess::query()->where('incoming_delivery_id', $this->id)->exists()) {
            return IncomingDeliverySuccess::query()->where('incoming_delivery_id', $this->id)->first()->created_at;
        }

        return null;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    use HasFactory;
}
