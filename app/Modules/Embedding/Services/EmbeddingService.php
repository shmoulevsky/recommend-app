<?php

namespace App\Modules\Embedding\Services;

use App\Modules\Embedding\ValueObjects\EmbeddingColumn;
use Illuminate\Support\Facades\DB;

class EmbeddingService
{
    public function calc(EmbeddingColumn $column, mixed $value): array|float
    {
        if($column->type === 'range'){
            return $this->normalize((float)$value, (float)$column->min, (float)$column->max);

        }
        return $this->oneHotEncode($value, $column->variants);
    }

    /**
     * @param float $value
     * @param float $min
     * @param float $max
     * @return float
     */
    private function normalize(float $value, float $min, float $max): float
    {
        if ($max - $min == 0) {
            return 0.0;
        }

        return ($value - $min) / ($max - $min);
    }

    /**
     * One-hot encode для категориальных характеристик
     *
     * @param int $value
     * @param array $categories
     * @return array
     */
    private function oneHotEncode(int $value, array $categories): array
    {
        return array_map(fn($category) => $category === $value ? 1 : 0, $categories);
    }

    public function getMin(string $table, string $name)
    {
        return DB::table($table)->min($name);
    }

    public function getMax(string $table, string $name)
    {
        return DB::table($table)->max($name);
    }

    public function getVariants(string $table): array
    {
        return DB::table($table)->select('id')
            ->get()
            ->pluck('id')
            ->toArray();
    }

}
