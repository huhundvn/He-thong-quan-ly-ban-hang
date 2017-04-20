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
}
