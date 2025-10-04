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
        Schema::create('strippings', function (Blueprint $table) {
            $table->id('id_stripping');
            $table->string('bdp_name')->nullable();
            $table->string('bdp_number_eqv')->nullable();
            $table->integer('qty')->nullable();
            $table->string('unit')->nullable();
            $table->string('op_number')->nullable();
            $table->date('op_date')->nullable();
            $table->string('defect')->nullable();
            $table->string('mt_number')->nullable();
            $table->integer('mt_qty')->nullable();
            $table->date('mt_date')->nullable();
            $table->bigInteger('id_mws_part');
            $table->foreign('id_mws_part')->references('id_mws_part')->on('mws_parts')->onDelete('cascade');
            $table->string('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strippings');
    }
};
