<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPriceOutput extends Model
{
	protected $table = 'detail_price_output';

	public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
