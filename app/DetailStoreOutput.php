<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailStoreOutput extends Model
{
	protected $table = 'detail_store_output';

	public function product()
	{
		return $this->belongsTo('App\Product');
	}
}
