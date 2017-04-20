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
}
