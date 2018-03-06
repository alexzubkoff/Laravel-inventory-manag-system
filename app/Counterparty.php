<?php
/**
 * Created by PhpStorm.
 * User: alexz
 * Date: 05.03.2018
 * Time: 17:34
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class Counterparty extends Model
{
    public $timestamps = false;

    public function purchase()
    {
        return $this->belongsTo('App\Purchase','counterpartyId');
    }

    public function order()
    {
        return $this->belongsTo('App\Order','counterpartyId');
    }

}