<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function setAmountUsdAttribute($value)
    {
        if ($this->attributes['currency'] == 'usd') {
        	$this->attributes['amount_usd'] = $value;
        } else {
        	$this->attributes['amount_usd'] = 0;	
        }
        
    }

    public function setAmountAttribute($value)
    {
        if ($this->attributes['currency'] == 'usd') {
        	$this->attributes['amount'] = $value * $this->attributes['rate'];
        } else {
        	$this->attributes['amount'] = $value;	
        }
        
    }
}
