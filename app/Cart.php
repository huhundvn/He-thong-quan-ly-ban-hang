<?php
/**
 * Created by PhpStorm.
 * User: ka
 * Date: 16/04/2017
 * Time: 14:44
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $table = 'cart';

    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}