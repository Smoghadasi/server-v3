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
        Schema::create('history_search_drivers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('driver_id')->nullable();
            $table->unsignedInteger('from_city_id')->nullable();
            $table->unsignedInteger('to_city_id')->nullable();
            $table->integer('count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_search_drivers');
    }
};
