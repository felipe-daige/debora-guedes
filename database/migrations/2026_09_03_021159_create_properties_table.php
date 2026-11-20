<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('type');
            $table->string('purpose')->default('sale');
            $table->string('status')->default('draft');
            $table->string('city');
            $table->string('neighborhood')->nullable();
            $table->string('address')->nullable();
            $table->text('description');
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('condominium_fee', 12, 2)->nullable();
            $table->decimal('property_tax', 12, 2)->nullable();
            $table->decimal('area', 12, 2)->nullable();
            $table->unsignedSmallInteger('bedrooms')->nullable();
            $table->unsignedSmallInteger('suites')->nullable();
            $table->unsignedSmallInteger('bathrooms')->nullable();
            $table->unsignedSmallInteger('parking_spaces')->nullable();
            $table->json('features')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index(['status', 'published_at']);
            $table->index(['purpose', 'city']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
