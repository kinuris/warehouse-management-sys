<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemOverhead extends Model
{
    protected $table = 'item_overheads';
    protected $fillable = [
        'base',
        'profit',
        'product_id',
    ];

    use HasFactory;
}
