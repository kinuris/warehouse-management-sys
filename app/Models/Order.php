<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'delivery_time',
        'is_cancelled',
        'is_walk_in', // Added is_walk_in field
    ];

    public function getAddressAttribute()
    {
        return $this->customer->address;
    }


    public function getClientNameAttribute()
    {
        return $this->customer->name;
    }

    public function getClientPhoneAttribute()
    {
        return $this->customer->phone;
    }

    /**
     * Get the customer that owns the order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public static function uniqueClientNames()
    {
        // Returning unique customer names associated with orders for now
        return Customer::whereHas('orders')->distinct()->pluck('name');
    }

    public function isWalkIn()
    {
        // Check the is_walk_in flag first, fallback to customer_id check for backward compatibility
        return $this->is_walk_in || is_null($this->customer_id);
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

    public function getProfit()
    {
        $profit = 0;
        foreach ($this->getItemsAndQuantity() as [$id, $qty]) {
            $profit += Product::query()
                ->where('id', '=', $id)
                ->first()
                ->overhead->profit * $qty;
        }

        return $profit;
    }

    public function getTax()
    {
        return $this->getProfit() * 0.12;
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($this->getItemsAndQuantity() as [$id, $qty]) {
            $total += Product::query()
                ->where('id', '=', $id)
                ->first()
                ->price * $qty;
        }

        return $total;
    }

    public static function pastDay(int $dayOffset = 0)
    {
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

    public static function profit($orders)
    {
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

    public function casts()
    {
        return [
            'delivery_time' => 'datetime'
        ];
    }
}
