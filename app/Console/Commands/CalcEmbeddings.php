<?php

namespace App\Console\Commands;

use App\Modules\Catalog\Car\Models\Car;
use App\Modules\Embedding\Services\EmbeddingService;
use App\Modules\Embedding\ValueObjects\EmbeddingColumn;
use Illuminate\Console\Command;

class CalcEmbeddings extends Command
{
    const VECTOR_SIZE = 200; // размер поля эмбеддинга в БД
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calc-embeddings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Расчет эмбеддинов для таблицы cars';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //из чего формируются эмбеддинги
        $targetColumns = [
            ['name' => 'car_mark_id', 'type' => 'onehot', 'table' => 'car_marks'],
            ['name' => 'transmission_type_id', 'type' => 'onehot', 'table' => 'transmission_types'],
            ['name' => 'driven_wheel_id', 'type' => 'onehot', 'table' => 'driven_wheels'],
            ['name' => 'market_category_id', 'type' => 'onehot', 'table' => 'market_categories'],
            ['name' => 'vehicle_size_id', 'type' => 'onehot', 'table' => 'vehicle_sizes'],
            ['name' => 'vehicle_style_id', 'type' => 'onehot', 'table' => 'vehicle_styles'],
            ['name' => 'year', 'type' => 'range', 'table' => 'cars'],
            ['name' => 'engine_hp', 'type' => 'range', 'table' => 'cars'],
            ['name' => 'engine_cylinders', 'type' => 'range', 'table' => 'cars'],
            ['name' => 'number_doors', 'type' => 'range', 'table' => 'cars'],
            ['name' => 'highway_mpg', 'type' => 'range', 'table' => 'cars'],
            ['name' => 'city_mpg', 'type' => 'range', 'table' => 'cars'],
            ['name' => 'msrp', 'type' => 'range', 'table' => 'cars'],
        ];

        $columns = [];
        $service = new EmbeddingService();

        foreach ($targetColumns as $column){

            $min = null;
            $max = null;
            $variants = null;

            if($column['type'] === 'range'){
                $min = $service->getMin($column['table'], $column['name']);
                $max = $service->getMax($column['table'], $column['name']);
            }

            if($column['type'] === 'onehot'){
                $variants = $service->getVariants($column['table']);
            }

            $columns[] = new EmbeddingColumn($column['name'], $column['type'], $min, $max, $variants);
        }

        $embeddings = [];

        $cars = Car::query()->get();

        foreach ($cars as $car){

            foreach ($columns as $column){
                $name = $column->name;
                $embedding = $service->calc($column, $car->$name);

                if(!isset($embeddings[$car->id])){
                    $embeddings[$car->id] = [];
                }

                if(is_array($embedding)){
                    $embeddings[$car->id] = array_merge($embeddings[$car->id],$embedding);
                    continue;
                }

                $embeddings[$car->id][] = $embedding;
            }

            //до заполняем эмбеддинг до нужной размерности
            $filled = array_fill(0, self::VECTOR_SIZE - count($embeddings[$car->id]), 0);
            $embeddings[$car->id] = array_merge($embeddings[$car->id], $filled);
            $car->embedding = $embeddings[$car->id];
            $car->save();

        }

        return Command::SUCCESS;
    }
}
