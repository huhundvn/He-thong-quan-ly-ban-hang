<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductInStore extends Model
{
	protected $table = 'product_in_store';

	public function store()
	{
		return $this->belongsTo('App\Store');
	}

	public function supplier()
	{
		return $this->belongsTo('App\Supplier');
	}

	public function unit()
	{
		return $this->belongsTo('App\Unit');
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'created_by', 'id');
	}
}
