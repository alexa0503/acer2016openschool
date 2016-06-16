<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrizeConfig extends Model
{
    //
    public $timestamps = false;
    public function prizeInfo()
    {
        return $this->belongsTo('App\Prize', 'prize');
    }
}
