<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mws_parts extends Model
{
    protected $table = 'mws_parts';
    protected $primaryKey = 'id_mws_part';
    public $timestamps = true;
    protected $fillable = [
        'part_id',
        'id_customer',
        'urgent_request_by',
        'start_date',
        'ref_logistic_ppc',
        'customer_name',
        'wbs_no',
        'title',
        'part_number',
        'serial_number',
        'job_type',
        'mdr_doc_defect',
        'ref_no',
        'ac_type',
        'iwo_no',
        'shop_area',
        'iwo_date',
        'worksheet_no',
        'remark_wms',
        'test_result',
        'schedule_delivery_on_time',
        'ecd_finish_workdays',
        'work_days_difference',
        'precentage_schedule',
        'worksheet_date',
        'approved_date',
        'form_out_no',
        'fo_receipt_number',
        'fo_receipt_date',
        'stripping_report_date',
        'stripping_order_by_sap_date',
        'order_work_days_difference',
        'time_stripping_work_days',
        'max_stripping_date',
        'tase_stripping',
        'percentage_bdp',
        'qty_bdp',
        'status_s_us',
        'revision',
        'finish_date',
        'finish_date_2',
        'men_powers',
        'men_hours',
        'ship_transfer_tt_date',
        'ship_transfer_tt_no',
        'isr_no',
        'shipping_work_days_difference',
        'tase',
        'remark',
        'prepared_by',
        'prepared_date',
        'approved_by',
        'verified_by',
        'verified_date',
        'stripping_notified',
        'capability',
        'attachment',
        'status',
        'is_urgent',
        'urgent_request',
        'current_step',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'start_date' => 'date',
        'iwo_date' => 'date',
        'schedule_delivery_on_time' => 'date',
        'worksheet_date' => 'date',
        'approved_date' => 'date',
        'fo_receipt_date' => 'date',
        'stripping_report_date' => 'date',
        'stripping_order_by_sap_date' => 'date',
        'max_stripping_date' => 'date',
        'finish_date' => 'date',
        'finish_date_2' => 'date',
        'ship_transfer_tt_date' => 'date',
        'prepared_date' => 'date',
        'verified_date' => 'date',
        'stripping_notified' => 'boolean',
        'is_urgent' => 'boolean',
        'urgent_request' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = now()->format('ym');
            $year = now()->year;

            $last = self::whereYear('created_at', $year)
                ->where('iwo_no', 'like', $prefix . '%')
                ->orderBy('iwo_no', 'desc')
                ->first();

            $nextNumber = 1;
            if ($last) {
                $lastSeq = intval(substr($last->iwo_no, -4));
                $nextNumber = $lastSeq + 1;
            }

            $sequence = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            $model->iwo_no = "{$prefix}-{$sequence}";
        });
    }

    public function customers()
    {
        return $this->belongsTo(customers::class, 'id_customer', 'id_customer');
    }

    public function mws_steps()
    {
        return $this->hasMany(mws_steps::class, 'id_mws_part', 'id_mws_part');
    }

    public function strippings()
    {
        return $this->hasMany(strippings::class, 'id_mws_part', 'id_mws_part');
    }
}
