<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
	protected $table = 'order_detail';
	
	public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
