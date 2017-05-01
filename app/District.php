<?php
/**
 * Created by PhpStorm.
 * User: ka
 * Date: 20/04/2017
 * Time: 09:40
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'district';

    public function ward()
    {
        return $this->hasMany('App\ward');
    }
}