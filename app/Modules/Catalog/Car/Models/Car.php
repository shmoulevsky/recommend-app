<?php

namespace App\Modules\Catalog\Car\Models;

use App\Modules\Catalog\Reference\Models\CarMark;
use App\Modules\Catalog\Reference\Models\CarModel;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'car_mark_id',
        'car_model_id',
        'transmission_type_id',
        'driven_wheel_id',
        'market_category_id',
        'vehicle_size_id',
        'vehicle_style_id',
        'year',
        'engine_hp',
        'number_doors',
        'highway_mpg',
        'city_mpg',
        'msrp',
    ];

    public function carMark()
    {
        return $this->belongsTo(CarMark::class);
    }

    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }
}
