<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceOutput extends Model
{
	protected $table = 'price_output';

	public function priceDetailOutput()
    {
        return $this->hasMany('App\PriceDetailOutput', 'price_output_id', 'id');
    }
}
