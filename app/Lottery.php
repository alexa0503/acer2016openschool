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
        return $this->belongsTo('App\PrizeCode');
    }
    public function prizeInfo()
    {
        return $this->belongsTo('App\Prize', 'prize');
    }
}
