<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InputStore extends Model
{
	protected $table = "input_store";

	public function detailInputStores()
	{
		return $this->hasMany('App\DetailInputStore');
	}

	public function store()
	{
		return $this->belongsTo('App\Store');
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'created_by', 'id');
	}

	public function supplier()
	{
		return $this->belongsTo('App\Supplier');
	}

	public function account()
	{
		return $this->belongsTo('App\Account');
	}
}
