<?php
/**
 * Created by PhpStorm.
 * User: ka
 * Date: 20/04/2017
 * Time: 09:01
 */

namespace app;


use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $table = 'address';

    public function province()
    {
        return $this->hasOne('App\Province', 'id', 'province_id');
    }

    public function district()
    {
        return $this->hasOne('App\District', 'id', 'district_id');
    }

    public function ward()
    {
        return $this->hasOne('App\Ward', 'id', 'ward_id');
    }
}