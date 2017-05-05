<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceOutput extends Model
{
	protected $table = 'price_output';

	public function detailPriceOutputs()
    {
        return $this->hasMany('App\DetailPriceOutput');
    }

	public function user()
	{
		return $this->belongsTo('App\User', 'created_by', 'id');
	}

	public function customer_group()
	{
		return $this->belongsTo('App\CustomerGroup');
	}
}
