<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreTranfer extends Model
{
	protected $table = 'store_tranfer';

	public function detailStoreTranfers()
	{
		return $this->hasMany('App\DetailStoreTranfer');
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'created_by', 'id');
	}
}
