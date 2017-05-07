<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table = 'order';

	public function orderDetails()
	{
		return $this->hasMany('App\OrderDetail');
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'created_by', 'id');
	}

	public function customer()
	{
		return $this->belongsTo('App\Customer');
	}

	public function priceOutput()
	{
		return $this->belongsTo('App\PriceOutput');
	}
}
