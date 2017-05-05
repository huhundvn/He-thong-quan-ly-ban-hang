<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	protected $table = "customer";

	public function province()
	{
		return $this->belongsTo('App\Province');
	}

	public function district()
	{
		return $this->belongsTo('App\District');
	}
}
