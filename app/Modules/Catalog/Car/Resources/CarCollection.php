<?php

namespace App\Modules\Catalog\Car\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CarCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => CarShortResource::collection($this->collection),
        ];
    }
}
