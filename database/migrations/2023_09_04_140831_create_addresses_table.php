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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 100);
            $table->bigInteger('user_id');
            $table->string('telphone_number', 13);
            $table->integer('provinces');
            $table->integer('city');
            $table->integer('is_active')->default(0);
            $table->integer('type_of_place');
            $table->text('detail_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
