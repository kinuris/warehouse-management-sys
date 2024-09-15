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
        'category_id',
    ];

    public function shrtName($length = 5)
    {
        $vowels = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'];
        $shortened = str_replace($vowels, '', $this->name);

        return substr($shortened, 0, $length);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function overhead()
    {
        return $this->hasOne(ItemOverhead::class, 'product_id');
    }

    public function getPriceAttribute()
    {
        return $this->overhead->base + $this->overhead->profit;
    }

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
