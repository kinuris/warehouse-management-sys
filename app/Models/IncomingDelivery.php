<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingDelivery extends Model
{
    protected $table = 'incoming_deliveries';
    protected $fillable = [
        'distributor_id',
        'product_id',
        'quantity',
        'batch_id',
        'delivery',
    ];

    public function status()
    {
        if (IncomingDeliverySuccess::query()->where('incoming_delivery_id', $this->id)->exists()) {
            return 'delivered';
        } else if (IncomingDeliveryCancel::query()->where('incoming_delivery_id', $this->id)->exists()) {
            return 'cancelled';
        } else {
            return 'pending';
        }
    }

    public function deliveryDate(): null | DateTime
    {
        if (IncomingDeliverySuccess::query()->where('incoming_delivery_id', $this->id)->exists()) {
            return IncomingDeliverySuccess::query()->where('incoming_delivery_id', $this->id)->first()->created_at;
        }

        return null;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function distributor() {
        return $this->belongsTo(Distributor::class);
    }

    public static function genNoCollisionBatchId() {
        $batchId = null;
        do {
            $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $batchId = substr(str_shuffle($chars), 0, 16);
        } while (self::query()->where('batch_id', $batchId)->exists());

        return $batchId;
    }

    public static function distributors(): array
    {
        $distributors = self::query()
            ->join('distributors', 'incoming_deliveries.distributor_id', '=', 'distributors.id')
            ->distinct('name')
            ->pluck('distributors.name')
            ->toArray();

        return $distributors;
    }

    use HasFactory;
}
