<?php

namespace App\Http\Controllers\V1;

use App\Modules\Base\DTO\ParamListDTO;
use App\Modules\Catalog\Car\Repositories\CarRepository;
use App\Modules\Catalog\Car\Resources\CarCollection;
use App\Modules\Catalog\Car\Resources\CarResource;
use Illuminate\Http\Request;

class CarController
{
    public function __construct(
        protected CarRepository $carRepository
    )
    {
    }

    public function index(Request $request)
    {
        $params = ParamListDTO::fromRequest($request, 'created_at');

        $cars = $this->carRepository->getList(
            $params->getSort(),
            $params->getDir(),
            $params->getFilter(),
            $params->getCount(),
        );

        return (new CarCollection($cars));
    }

    public function show(Request $request)
    {
        $car = $this->carRepository->getById($request->id);
        return new CarResource($car);
    }

    public function similar(Request $request)
    {
        $products = $this->carRepository->getSimilar($request->id);
        return (new CarCollection($products));
    }

    private function CarResource($car)
    {
    }

}
