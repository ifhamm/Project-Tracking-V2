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
        Schema::create('mws_steps', function (Blueprint $table) {
            $table->id('id_mws_step');
            $table->bigInteger('id_mws_part');
            $table->foreign('id_mws_part')->references('id_mws_part')->on('mws_parts')->onDelete('cascade');
            $table->integer('step_no');
            $table->string('description');
            $table->text('details')->nullable();
            $table->string('plan_man')->nullable();
            $table->string('plan_hours')->nullable();
            $table->text('man')->nullable();
            $table->string('hours')->nullable();
            $table->string('tech')->nullable();
            $table->string('insp')->nullable();
            $table->string('status')->nullable();
            $table->string('completed_by')->nullable();
            $table->string('completed_date')->nullable();
            $table->string('timer_start_time')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->text('attachments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mws_steps');
    }
};
