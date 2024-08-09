<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemRole extends Model
{
    use HasFactory;

    protected $table = 'system_roles';

    protected $fillable = [
        'name',
    ];

    public function getShortened(): string {
        return strtoupper(substr($this->name, 0, 3));
    }
}
