<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('symptom_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('symptoms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('symptom_categories')->cascadeOnDelete();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('question');
            $table->decimal('mb', 4, 2);
            $table->decimal('md', 4, 2);
            $table->decimal('cf_expert', 4, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('burnout_levels', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('min_cf', 4, 2);
            $table->decimal('max_cf', 4, 2);
            $table->timestamps();
        });

        Schema::create('rules', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('burnout_level_id')->constrained('burnout_levels')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('rule_symptoms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rule_id')->constrained('rules')->cascadeOnDelete();
            $table->foreignId('symptom_id')->constrained('symptoms')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rule_symptoms');
        Schema::dropIfExists('rules');
        Schema::dropIfExists('burnout_levels');
        Schema::dropIfExists('symptoms');
        Schema::dropIfExists('symptom_categories');
    }
};
