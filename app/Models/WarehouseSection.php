<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseSection extends Model
{
    protected $table = 'warehouse_sections';

    protected $fillable = [
        'warehouse_id',
        'image_link',
        'description'
    ];

    use HasFactory;
}
