<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('car_mark_id')
                ->nullable()
                ->constrained('car_marks')
                ->nullOnDelete();
            $table->foreignId('car_model_id')
                ->nullable()
                ->constrained('car_models')
                ->nullOnDelete();
            $table->foreignId('transmission_type_id')
                ->nullable()
                ->constrained('transmission_types')
                ->nullOnDelete();
            $table->foreignId('driven_wheel_id')
                ->nullable()
                ->constrained('driven_wheels')
                ->nullOnDelete();
            $table->foreignId('market_category_id')
                ->nullable()
                ->constrained('market_categories')
                ->nullOnDelete();
            $table->foreignId('vehicle_size_id')
                ->nullable()
                ->constrained('vehicle_sizes')
                ->nullOnDelete();
            $table->foreignId('vehicle_style_id')
                ->nullable()
                ->constrained('vehicle_styles')
                ->nullOnDelete();
            $table->integer('year')->nullable();
            $table->integer('engine_hp')->nullable();
            $table->integer('engine_cylinders')->nullable();
            $table->tinyInteger('number_doors')->nullable();
            $table->float('highway_mpg')->nullable();
            $table->float('city_mpg')->nullable();
            $table->integer('msrp')->nullable();

        });

        DB::statement('ALTER TABLE cars ADD COLUMN embedding vector(200);');
        DB::statement('CREATE INDEX cars_embedding_index ON cars USING hnsw (embedding vector_l2_ops);');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
        DB::statement('DROP INDEX IF EXISTS cars_embedding_index;');
        DB::statement('ALTER TABLE cars DROP COLUMN embedding;');
    }
};
