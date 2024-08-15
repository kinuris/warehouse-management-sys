<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouses';

    protected $fillable = [
        'name',
        'image_link',
        'description',
    ];

    public function sections()
    {
        $sections = WarehouseSection::query()
            ->where('warehouse_id', $this->id)
            ->get();

        return $sections;
    }

    use HasFactory;
}
