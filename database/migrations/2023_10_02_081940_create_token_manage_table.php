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
        Schema::create('token_manage', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('meters_id')->constrained()->onDelete('cascade');
            $table->string('token');
            $table->timestamp('generation_date');
            $table->foreignId('tariff_id')->constrained()->onDelete('cascade');
            $table->foreignId('meters_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_manage');
    }
};
