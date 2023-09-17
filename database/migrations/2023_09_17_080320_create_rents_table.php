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
        Schema::create('rents', function (Blueprint $table) {
            $table->id(); 
            $table->uuid('owner_id');
            $table->uuid('guest_id');
            $table->string('address')->nullable(true);
            $table->string('phone');
            $table->integer('total');
            $table->dateTimeTz('count_days');
            $table->dateTimeTz('star_day');
            $table->dateTimeTz('end_day');
            $table->integer('fees')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};
