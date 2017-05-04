<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $table = 'product';

	public function attributes()
	{
		return $this->hasMany('App\ProductAttribute');
	}

	public function images()
	{
		return $this->hasMany('App\ProductImage');
	}

	public function detailPriceOutputs()
	{
		return $this->hasMany('App\DetailPriceOutput');
	}

	public function detailPriceInputs()
	{
		return $this->hasMany('App\DetailPriceInput');
	}
}
