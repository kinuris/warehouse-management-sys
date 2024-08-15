<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'client_name',
        'client_phone',
        'address',
        'delivery_time',
    ];

    public function isDelivered(): bool
    {
        return DeliveryRecord::query()->where('order_id', '=', $this->id)->exists();
    }

    public function isFailed(): bool {
        $record = DeliveryRecord::query()->where('order_id', '=', $this->id)->first();

        return date_create($this->delivery_time) < date_create('now') && $record === null;
    }

    public function isPending(): bool {
        return !$this->isDelivered() && !$this->isFailed();
    }

    public static function notDelivered()
    {
        $records = self::where('delivery_time', '>', now())->get();

        $notDelivered = array();
        foreach ($records as $record) {
            if (DeliveryRecord::where('order_id', $record->id)->count() === 0) {
                array_push($notDelivered, $record);
            }
        }

        return $notDelivered;
    }

    public static function success()
    {
        $records = DeliveryRecord::all();

        $success = array();
        foreach ($records as $record) {
            $order = self::find($record->order_id);

            array_push($success, $order);
        }

        return $success;
    }

    public static function failed()
    {
        $records = self::where('delivery_time', '<', now())->get();

        $failed = array();
        foreach ($records as $record) {
            if (DeliveryRecord::where('order_id', $record->id)->count() === 0) {
                array_push($failed, $record);
            }
        }

        return $failed;
    }
}
