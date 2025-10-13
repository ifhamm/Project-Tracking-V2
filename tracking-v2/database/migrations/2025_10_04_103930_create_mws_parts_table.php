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
        Schema::create('mws_parts', function (Blueprint $table) {
            $table->id('id_mws_part');
            $table->string('part_id')->unique();
            $table->bigInteger('id_customer')->nullable();
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('cascade');
            $table->string('urgent_request_by')->nullable();
            $table->date('start_date')->nullable();
            $table->string('ref_logistic_ppc')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('wbs_no')->nullable();
            $table->string('title');
            $table->string('part_number');
            $table->string('serial_number');
            $table->string('job_type')->nullable();
            $table->string('mdr_doc_defect')->nullable();
            $table->string('ref_no')->nullable();
            $table->string('ac_type')->nullable();
            $table->string('iwo_no');
            $table->string('shop_area')->nullable();
            $table->date('iwo_date')->nullable();
            $table->string('worksheet_no')->nullable();
            $table->string('remark_wms')->nullable();
            $table->string('test_result')->nullable();
            $table->date('schedule_delivery_on_time')->nullable();
            $table->integer('ecd_finish_workdays')->nullable();
            $table->integer('work_days_difference')->nullable();
            $table->string('precentage_schedule')->nullable();
            $table->date('worksheet_date')->nullable();
            $table->date('approved_date')->nullable();
            $table->string('form_out_no')->nullable();
            $table->string('fo_receipt_number')->nullable();
            $table->date('fo_receipt_date')->nullable();
            $table->date('stripping_report_date')->nullable();
            $table->date('stripping_order_by_sap_date')->nullable();
            $table->integer('order_work_days_difference')->nullable();
            $table->integer('time_stripping_work_days')->nullable();
            $table->date('max_stripping_date')->nullable();
            $table->string('tase_stripping')->nullable();
            $table->string('percentage_bdp')->nullable();
            $table->integer('qty_bdp')->nullable();
            $table->string('status_s_us')->nullable();
            $table->string('revision')->nullable();
            $table->date('finish_date')->nullable();
            $table->date('finish_date_2')->nullable();
            $table->string('men_powers')->nullable();
            $table->string('men_hours')->nullable();
            $table->date('ship_transfer_tt_date')->nullable();
            $table->string('ship_transfer_tt_no')->nullable();
            $table->string('isr_no')->nullable();
            $table->integer('shipping_work_days_difference')->nullable();
            $table->string('tase')->nullable();
            $table->string('remark')->nullable();
            $table->string('prepared_by')->nullable();
            $table->date('prepared_date')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->date('verified_date')->nullable();
            $table->boolean('stripping_notified')->nullable();
            $table->string('capability')->nullable();
            $table->text('attachment')->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_urgent')->nullable();
            $table->boolean('urgent_request')->nullable();
            $table->integer('current_step')->nullable();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mws_parts');
    }
};
