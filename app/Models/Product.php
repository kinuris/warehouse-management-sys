<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'internal_id',
        'name',
        'stock_qty',
        'is_suspended',
        'price',
    ];

    public static function create($fields = []): Product
    {
        return Product::query()->create(array_merge($fields, [
            'internal_id' => 'SBP-' . Product::getNoCollisionID(),
        ]));
    }

    public static function getNoCollisionID(): string
    {
        while (true) {
            $end = random_int(0, 9999);

            $like = Product::query()->where('internal_id', 'LIKE', "%$end%")->first();

            if ($like === null) {
                return $end;
            }
        }
    }

    use HasFactory;
}
