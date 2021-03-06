<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value','payer', 'payee'
    ];

    public function payer()
    {
        return $this->hasOne('App\Models\User', 'id', 'payer');
    }

    public function payee()
    {
        return $this->hasOne('App\Models\User', 'id', 'payee');
    }
}
