<?php
/**
 * Created by PhpStorm.
 * User: alexz
 * Date: 05.03.2018
 * Time: 16:46
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    public $timestamps = false;

    public function purchase()
    {
        return $this->belongsTo('App\Purchase','productId');
    }

    public function order()
    {
        return $this->belongsTo('App\Order','productId');
    }

}