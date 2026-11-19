<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tape_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('analog_tape_id')->unique()->constrained('analog_tapes')->onDelete('cascade');
            $table->string('physical_condition', 100);
            $table->string('magnetic_degradation', 100);
            $table->string('housing_status', 100)->default('Utuh');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tape_conditions');
    }
};
