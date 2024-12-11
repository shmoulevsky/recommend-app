<?php

namespace App\Modules\Catalog\Car\Repositories;


use App\Modules\Base\Enums\FilterEnum;
use App\Modules\Catalog\Car\Models\Car;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;


class CarRepository
{
    /**
     * @var array|array[]
     */
    private array $filters;

    public function __construct()
    {
        //параметры для фильтров
        $this->filters = [
            'car_mark_id' => [
                'column' => 'car_mark_id',
                'type' => FilterEnum::whereIn->value
            ],
            'car_model_id' => [
                'column' => 'car_model_id',
                'type' => FilterEnum::whereIn->value
            ],
            'transmission_type_id' => [
                'column' => 'transmission_type_id',
                'type' => FilterEnum::whereIn->value
            ],
            'driven_wheel_id' => [
                'column' => 'driven_wheel_id',
                'type' => FilterEnum::whereIn->value
            ],
            'market_category_id' => [
                'column' => 'market_category_id',
                'type' => FilterEnum::whereIn->value
            ],
            'vehicle_size_id' => [
                'column' => 'vehicle_size_id',
                'type' => FilterEnum::whereIn->value
            ],
            'vehicle_style_id' => [
                'column' => 'vehicle_style_id',
                'type' => FilterEnum::whereIn->value
            ],
            'year' => [
                'column' => 'year',
                'type' => FilterEnum::range->value
            ],
            'engine_hp' => [
                'column' => 'engine_hp',
                'type' => FilterEnum::range->value
            ],
            'engine_cylinders' => [
                'column' => 'engine_cylinders',
                'type' => FilterEnum::range->value
            ],
            'number_doors' => [
                'column' => 'number_doors',
                'type' => FilterEnum::range->value
            ],
            'highway_mpg' => [
                'column' => 'highway_mpg',
                'type' => FilterEnum::range->value
            ],
            'city_mpg' => [
                'column' => 'city_mpg',
                'type' => FilterEnum::range->value
            ],
            'msrp' => [
                'column' => 'msrp',
                'type' => FilterEnum::range->value
            ],
            'id' => [
                'column' => 'id',
                'type' => FilterEnum::whereIn->value
            ],
        ];
    }

    /**
     * @param string $sort
     * @param string $dir
     * @param array $filters
     * @param int|null $count
     * @return LengthAwarePaginator
     */
    public function getList(string $sort = 'created_at', string $dir = 'asc', array $filters = [], int $count = null): LengthAwarePaginator
    {
        $builder = Car::query()->with(['transmissionType', 'drivenWheel', 'marketCategory', 'vehicleSize']);
        $builder = $this->applyFilters($filters, $builder);
        return $builder->orderBy($sort, $dir)->paginate($count);
    }

    /**
     * @param array $filters
     * @param Builder $builder
     * @return Builder
     */
    private function applyFilters(array $filters, Builder $builder): Builder
    {
        foreach ($filters as $key => $filter){

            if(empty($filter) && $key !== 'id') continue;
            $settings = Arr::get($this->filters, $key);

            if(empty($settings)) continue;

            //равное
            if($settings['type'] === FilterEnum::equal->value){
                $builder->where("products.".$settings['column'],'=', $filter);
                continue;
            }

            //справочник
            if($settings['type'] === FilterEnum::whereIn->value){
                $values = explode(',',$filter);
                $builder->whereIn("products.".$settings['column'], $values);
                continue;
            }

            //диапазон
            if($settings['type'] === FilterEnum::range->value){

                list($from, $to) = explode(',', $filter);

                $from = (int)$from;
                $to = (int)$to;

                if(!empty($from) && !empty($to)){
                    $builder->whereBetween("products.".$settings['column'], [$from, $to]);
                }

                if(!empty($from) && empty($to)){
                    $builder->where("products.".$settings['column'], '>=', $to);
                }

                if(empty($from) && !empty($to)){
                    $builder->where("products.".$settings['column'], '<=', $to);
                }
            }

        }

        return $builder;
    }

    public function getSimilar(?int $id, int $count = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $car = Car::query()
            ->select('car_mark_id','car_model_id')
            ->where('id', '=', $id)
            ->first();

        $builder = Car::query()->select(
            'id',
            'car_mark_id',
            'car_model_id',
            'driven_wheel_id',
            'transmission_type_id',
            'market_category_id',
            'vehicle_size_id',
            'engine_cylinders',
            'highway_mpg',
            'vehicle_style_id',
            'engine_hp',
            'msrp',
            'year'
        );
        $builder->selectRaw("embedding <-> (SELECT embedding FROM cars WHERE id = $id) as distance");
        $builder->with(['transmissionType', 'drivenWheel', 'marketCategory', 'vehicleSize', 'drivenWheel']);
        $builder->where([
            ['car_mark_id', '<>', $car->car_mark_id],
            ['car_model_id', '<>', $car->car_model_id],
        ]);
        return $builder->orderBy("distance")->paginate($count);
    }

    public function getById(int $id)
    {
        return Car::query()
            ->where('id', '=', $id)
            ->first();
    }

}
