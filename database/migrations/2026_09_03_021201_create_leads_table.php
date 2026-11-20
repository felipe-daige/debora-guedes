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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('interest')->nullable();
            $table->text('message')->nullable();
            $table->string('source')->default('site');
            $table->string('status')->default('new');
            $table->text('lost_reason')->nullable();
            $table->decimal('potential_value', 15, 2)->nullable();
            $table->timestamp('next_contact_at')->nullable();
            $table->json('tracking')->nullable();
            $table->timestamps();
            $table->index(['status', 'created_at']);
            $table->index(['assigned_to', 'next_contact_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
