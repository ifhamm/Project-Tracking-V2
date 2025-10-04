<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customers extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id_customer';
    protected $fillable = [
        'username',
        'password',
        'company_name',
        'role'
    ];

    public function mws_parts()
    {
        return $this->hasMany(mws_parts::class, 'id_customer', 'id_customer');
    }
}
