<?php

namespace App\Modules\Catalog\Reference\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $fillable = [
        'title',
        'car_mark_id'
    ];
}
