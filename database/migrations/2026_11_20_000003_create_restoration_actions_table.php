<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restoration_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('analog_tape_id')->constrained('analog_tapes')->onDelete('cascade');
            $table->string('action_name');
            $table->string('priority', 50)->default('Sedang');
            $table->string('status', 50)->default('Direncanakan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restoration_actions');
    }
};
