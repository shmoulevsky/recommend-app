<?php

namespace App\Modules\Embedding\ValueObjects;

class EmbeddingColumn
{
    public function __construct(
        public string $name,
        public string $type,
        public ?float $min,
        public ?float $max,
        public ?array $variants
    )
    {
    }
}
