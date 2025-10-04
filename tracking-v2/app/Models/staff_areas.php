<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class staff_areas extends Model
{
    protected $table = 'staff_areas';
    protected $primaryKey = 'id_staff_area';
    protected $fillable = [
        'id_user',
        'assigned_customers',
        'assigned_shop_area',
    ];

    protected $casts = [
        'assigned_customers' => 'array',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
