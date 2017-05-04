<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPriceInput extends Model
{
	protected $table = 'detail_price_input';

	public function product()
	{
		return $this->hasOne('App\Product', 'id', 'product_id');
	}
}
