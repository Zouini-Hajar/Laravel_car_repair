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
        Schema::create('repair_spareparts', function(Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->unsignedBigInteger('repair_id');
            $table->foreign('repair_id')->references('id')->on('repairs')->onDelete('cascade');
            $table->unsignedBigInteger('sparepart_id');
            $table->foreign('sparepart_id')->references('id')->on('spareparts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
