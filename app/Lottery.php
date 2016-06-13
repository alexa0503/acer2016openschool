<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    //
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\WechatUser');
    }
    public function prizeCode()
    {
        return $this->hasOne('App\PrizeCode');
    }
}