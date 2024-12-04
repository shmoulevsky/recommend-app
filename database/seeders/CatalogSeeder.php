<?php

namespace Database\Seeders;

use App\Modules\Catalog\Car\Models\Car;
use App\Modules\Catalog\Reference\Models\CarMark;
use App\Modules\Catalog\Reference\Models\CarModel;
use App\Modules\Catalog\Reference\Models\DrivenWheel;
use App\Modules\Catalog\Reference\Models\MarketCategory;
use App\Modules\Catalog\Reference\Models\TransmissionType;
use App\Modules\Catalog\Reference\Models\VehicleSize;
use App\Modules\Catalog\Reference\Models\VehicleStyle;
use Illuminate\Database\Seeder;


class CatalogSeeder extends Seeder
{
    public function run()
    {

        $csvFile = database_path('seeders/data/cars.csv');

        $data = array_map('str_getcsv', file($csvFile));
        $headers = array_map('strtolower', array_shift($data));

        foreach ($data as $key => $row) {

            $rowData = array_combine($headers, $row);
            $isSkip = false;

            foreach ($rowData as $data){
                if(empty($data)) {
                    $isSkip = true;
                }
            }

            if($isSkip) continue;

            $carMark = CarMark::firstOrCreate(['title' => $rowData['make']]);
            $carModel = CarModel::firstOrCreate([
                'title' => $rowData['model'],
                'car_mark_id' => $carMark->id,
            ]);

            $transmissionType = TransmissionType::firstOrCreate(['title' => $rowData['transmission type']]);
            $drivenWheel = DrivenWheel::firstOrCreate(['title' => $rowData['driven_wheels']]);
            $marketCategory = MarketCategory::firstOrCreate(['title' => $rowData['market category']]);
            $vehicleSize = VehicleSize::firstOrCreate(['title' => $rowData['vehicle size']]);
            $vehicleStyle = VehicleStyle::firstOrCreate(['title' => $rowData['vehicle style']]);

            Car::create([
                'car_mark_id' => $carMark->id,
                'car_model_id' => $carModel->id,
                'transmission_type_id' => $transmissionType->id,
                'driven_wheel_id' => $drivenWheel->id,
                'market_category_id' => $marketCategory->id,
                'vehicle_size_id' => $vehicleSize->id,
                'vehicle_style_id' => $vehicleStyle->id,
                'year' => $rowData['year'],
                'engine_hp' => $rowData['engine hp'],
                'engine_cylinders' => $rowData['engine cylinders'],
                'number_doors' => $rowData['number of doors'],
                'highway_mpg' => $rowData['highway mpg'],
                'city_mpg' => $rowData['city mpg'],
                'msrp' => $rowData['msrp'],
            ]);
        }
    }
}
