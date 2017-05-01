<?php
/**
 * Created by PhpStorm.
 * User: ka
 * Date: 20/04/2017
 * Time: 09:40
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'province';

    public function district()
    {
        return $this->hasMany('Add\district');
    }
}