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
        Schema::create('utility_providers', function (Blueprint $table) {
            $table->id();
            $table->string('provider_name');
            $table->string('provider_code');
            $table->string('provider_status');
            $table->foreignId('provider_categories_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utility_providers');
    }
};
