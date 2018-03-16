<?php
/**
 * Created by PhpStorm.
 * User: alexz
 * Date: 05.03.2018
 * Time: 18:14
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public $timestamps = false;

    public function good()
    {
        return $this->hasOne('App\Good','productId');
    }

    public function counterparty()
    {
        return $this->hasOne('App\Counterparty','counterpartyId');
    }
      // delete Entrust with JWT
}