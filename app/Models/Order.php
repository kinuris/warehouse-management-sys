<?php

namespace App\Models;

use DateTime;
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
        'is_cancelled',
    ];

    public function isWalkIn() {
        return $this->address === '(Walk-in Order)';
    }

    public function getItemsAndQuantity()
    {
        $orderItems = OrderItem::query()
            ->where('order_id', '=', $this->id)
            ->get();

        $items = array();
        foreach ($orderItems as $orderItem) {
            array_push($items, [$orderItem->product_id, $orderItem->quantity]);
        }

        return $items;
    }

    public function isDelivered(): bool
    {
        return DeliveryRecord::query()->where('order_id', '=', $this->id)->exists();
    }

    public function isOnTimeDelivered(): bool
    {
        $record = DeliveryRecord::query()->where('order_id', '=', $this->id)->first();

        return $record !== null && date_create($record->delivery_time) <= date_create($this->delivery_time);
    }

    public function isLateNotDelivered(): bool
    {
        return !$this->isDelivered() && date_create($this->delivery_time) < date_create('now') && !$this->isFailed();
    }

    public function isLateDelivered(): bool
    {
        return !$this->isOnTimeDelivered() && $this->isDelivered();
    }

    public function isFailed(): bool
    {
        return $this->is_cancelled;
    }

    public function isPending(): bool
    {
        $exists = DeliveryRecord::query()->where('order_id', '=', $this->id)->exists();

        return !$exists && new DateTime($this->delivery_time) > date_create('now');
    }

    public static function pastDay(int $dayOffset = 0)
    {
        // $upper = date_create('now')->sub(new DateInterval('P' . $dayOffset . 'D'))->format('Y-m-d');
        // $lower = date_create($upper)->sub(new DateInterval('P1D'))->format('Y-m-d');

        $now = date_create('now')->format('Y-m-d H:i:s');

        if ($dayOffset > 0) {
            $now = date('Y-m-d', strtotime('-' . ($dayOffset - 1) . ' days'));
        }

        $lower = date_create('now')->format('Y-m-d');

        if ($dayOffset > 0) {
            $lower = date('Y-m-d', strtotime('-' . ($dayOffset) . ' days'));
        }

        return self::query()
            ->where('created_at', '<', $now)
            ->where('created_at', '>', $lower)
            ->where('is_cancelled', '=', '0')
            ->get();
    }

    public static function profit($orders) {
        $total = 0;
        foreach ($orders as $order) {
            $items = $order->getItemsAndQuantity();

            foreach ($items as [$item, $qty]) {
                $item = Product::find($item);

                $total += $item->overhead->profit * $qty;
            }
        }

        return $total;
    }

    public static function total($orders)
    {
        $total = 0;
        foreach ($orders as $order) {
            $items = $order->getItemsAndQuantity();

            foreach ($items as [$item, $qty]) {
                $item = Product::find($item);

                $total += $item->price * $qty;
            }
        }

        return $total;
    }

    public static function notDelivered()
    {
        $records = self::query()
            ->where('is_cancelled', '=', '0')
            ->get();

        $notDelivered = array();
        foreach ($records as $record) {
            if (!DeliveryRecord::where('order_id', $record->id)->exists()) {
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
        $failed = self::where('is_cancelled', '=', '0')->get();

        return $failed;
    }
}
