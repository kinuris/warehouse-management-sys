<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WareHouseSectionProduct extends Model
{
    use HasFactory;

    protected $table = 'ware_house_section_products';

    protected $fillable = [
        'warehouse_section_id',
        'product_id',
    ];

    public function getWarehouseSection(): WarehouseSection {
        return WarehouseSection::query()->find($this->warehouse_section_id); 
    }
}
