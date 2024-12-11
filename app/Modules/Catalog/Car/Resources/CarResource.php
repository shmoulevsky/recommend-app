<?php

namespace App\Modules\Catalog\Car\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class CarResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->carMark?->title.' '.$this->carModel?->title,
            'transmission_type' => $this->transmissionType?->title,
            'driven_wheel' => $this->drivenWheel?->title,
            'market_category' => $this->marketCategory?->title,
            'vehicle_size' => $this->vehicleSize?->title,
            'vehicle_style' => $this->vehicleStyle?->title,
            'year' => $this->year,
            'engine_hp' => $this->engine_hp,
            'engine_cylinders' => $this->engine_cylinders,
            'msrp' => $this->msrp,
            'number_doors' => $this->number_doors,
            'city_mpg' => $this->city_mpg,
            'highway_mpg' => $this->highway_mpg,
            'distance' => $this->distance ?? null
        ];
    }
}
