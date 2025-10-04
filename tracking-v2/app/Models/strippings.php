<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class strippings extends Model
{
    protected $table = 'strippings';
    protected $primaryKey = 'id_stripping';
    protected $fillable = [
        'bdp_name',
        'bdp_number_eqv',
        'qty',
        'unit',
        'op_number',
        'op_date',
        'defect',
        'mt_number',    
        'mt_qty',
        'mt_date',
        'id_mws_part',
        'remarks',
    ];

    protected $casts = [
        'op_date' => 'datetime',
        'mt_date' => 'datetime',
    ];

    public function mws_parts()
    {
        return $this->belongsTo(mws_parts::class, 'id_mws_part');
    }
}
