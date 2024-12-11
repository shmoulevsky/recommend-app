<?php

namespace App\Modules\Catalog\Car\Models;

use App\Modules\Catalog\Reference\Models\CarMark;
use App\Modules\Catalog\Reference\Models\CarModel;
use App\Modules\Catalog\Reference\Models\DrivenWheel;
use App\Modules\Catalog\Reference\Models\MarketCategory;
use App\Modules\Catalog\Reference\Models\TransmissionType;
use App\Modules\Catalog\Reference\Models\VehicleSize;
use App\Modules\Catalog\Reference\Models\VehicleStyle;
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

    public function transmissionType()
    {
        return $this->belongsTo(TransmissionType::class);
    }

    public function drivenWheel()
    {
        return $this->belongsTo(DrivenWheel::class);
    }

    public function marketCategory()
    {
        return $this->belongsTo(MarketCategory::class);
    }

    public function vehicleSize()
    {
        return $this->belongsTo(VehicleSize::class);
    }

    public function vehicleStyle()
    {
        return $this->belongsTo(VehicleStyle::class);
    }

}
