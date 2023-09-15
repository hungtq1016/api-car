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
        Schema::create('owners', function (Blueprint $table) {
            $table->uuid('id')->primary(); 

            $table->uuid('car_id');
            $table->uuid('user_id');

            $table->uuid('province_id')->nullable(true);
            $table->uuid('district_id')->nullable(true);
            $table->uuid('ward_id')->nullable(true);

            $table->unsignedBigInteger('price');
            $table->boolean('isDelivery')->default(1);
            $table->boolean('isMortgages')->default(1);
            $table->boolean('isInstant')->default(1);
            $table->text('desc');
            $table->string('address');
     
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
