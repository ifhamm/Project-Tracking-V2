<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mws_steps extends Model
{
    protected $table = 'mws_steps';
    protected $primaryKey = 'id_mws_step';
    protected $fillable = [
        'id_mws_part',
        'step_no',
        'description',
        'details',
        'plan_man',
        'plan_hours',
        'man',
        'hours',
        'tech',
        'insp',
        'status',
        'completed_by',
        'completed_date',
        'timer_start_time',
        'created_at',
        'updated_at',
        'attachments'
    ];

    protected $casts = [
        'completed_date' => 'datetime',
        'timer_start_time' => 'datetime',
    ];

    public function mws_parts()
    {
        return $this->belongsTo(mws_parts::class, 'id_mws_part');
    }
}
