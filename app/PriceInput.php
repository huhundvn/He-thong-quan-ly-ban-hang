<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceInput extends Model
{
	protected $table = 'price_input';

	public function priceDetailInput()
	{
		return $this->hasMany('App\PriceDetailInput', 'price_input_id', 'id');
	}
}
