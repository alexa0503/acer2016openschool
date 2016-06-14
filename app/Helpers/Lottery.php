<?php
namespace App\Helper;
use Carbon\Carbon;
class Lottery
{
    private $prize_config_id = null;
    private $prize_id = 12;
    private $time;
    private $date;
    private $prize_type;
    private $session;
    private $prize_code = null;
    public function __construct()
    {
        $session = \Request::session();
        $this->session = $session;
        $timestamp = time();
        $this->time = date('H:i:s', $timestamp);
        $this->date = date('Y-m-d', $timestamp);
        $this->prize_type = $session->get('lottery.id') == null ? 1 : 0;
    }
    public function run()
    {
        $this->lottery();
        $this->record();
        return $this->prize_id;
    }
    public function lottery()
    {
        $prize_type = $this->prize_type;
        $prize_id = $this->prize_id;//默认奖项
        //当前时段的中奖几率
        $date = $this->date;
        $time = $this->time;
        $config = \App\LotteryConfig::where('start_time','<=',$time)->where('shut_time','>',$time)->first();
        if( $config == null ){
            return $prize_id;
        }
        $rand_max = ceil(1/$config->win_odds);
        $rand1 = rand(1,$rand_max);
        $rand2 = rand(1,$rand_max);
        if( $rand1 == $rand2 ){
            $seed = rand(1, 1000);
            //奖项分布情况,计算出中几等奖
            $prize_model = \App\Prize::where('seed_min', '<=', $seed)->where('seed_max', '>=', $seed);
            if( $prize_model->count() > 0 ){
                $prize = $prize_model->first();
                //当日奖项设置
                $prize_config_model = \App\PrizeConfig::where('type', $prize_type)->where('lottery_date', $date)->where('prize', $prize->id);
                if( $prize_config_model->count() > 0){
                    //奖池情况
                    $prize_config = $prize_config_model->first();
                    /*
                    $count = \App\Lottery::where('prize', $prize->id)->count();
                    if( $count < $prize->sum ){
                        $prize_id = $prize->id;
                    }
                    */
                    if( $prize_config->prize_num > $prize_config->win_num ){
                        $prize_id = $prize->id;
                        $this->prize_config_id = $prize_config->id;
                    }
                }
            }
        }
        $this->prize_id = $prize_id;
        return;
    }
    public function record()
    {
        //$session = \Request::session();
        $session = $this->session;
        $prize_type = $this->prize_type;
        $date = $this->date;
        $time = $this->time;
        $prize_id = $this->prize_id;
        \DB::beginTransaction();
        try {
            if (null == $session->get('lottery.id')) {
                $wechat = \App\WechatUser::where('open_id', $session->get('wechat.openid'))->first();
                $lottery = new \App\Lottery();
                $lottery->user_id = $wechat->id;
                $lottery->snid = null;
                $lottery->prize_code_id = null;
                $lottery->created_time = Carbon::now();
                $lottery->created_ip = \Request::getClientIp();
            } else {
                $lottery = \App\Lottery::find($session->get('lottery.id'));
            }
            //蜘蛛网
            if (in_array($prize_id, [9, 10, 13])) {
                if ($prize_id == 9) {
                    $code_type = 1;
                } elseif ($prize_id == 10) {
                    $code_type = 2;
                } else {
                    $code_type = 3;
                }
                $prize_code_model = \App\PrizeCode::where('is_active', 0)->where('type', $code_type);
                if ($prize_code_model->count() > 0) {
                    $prize_code = $prize_code_model->first();
                    $prize_code->is_active = 1;
                    $prize_code->save();
                    $lottery->prize_code_id = $prize_code->id;
                    $this->prize_code = $prize_code->prize_code;
                } else {
                    $prize_id = 12;
                }
            }
            $lottery->prize = $prize_id;
            $lottery->prize_type = $prize_type;
            $lottery->lottery_time = Carbon::now();
            $lottery->has_lottery = 1;
            $lottery->save();
            $prize = \App\Prize::find($prize_id);
            $prize->save();
            if( null == $this->prize_config_id){
                $prize_config = \App\PrizeConfig::where('type', $prize_type)->where('lottery_date', $date)->where('prize', $prize_id)->first();
            }
            else{
                $prize_config = \App\PrizeConfig::find($this->prize_config_id);
            }
            if( null != $prize_config){
                $prize_config->win_num += 1;
                $prize_config->save();
            }
            $session->set('lottery.id', null);
            \DB::commit();
        } catch (Exception $e) {
            //$result = ['ret' => 1001, 'msg' => $e->getMessage()];
            \DB::rollBack();
        }
        return;
    }
    public function getCode(){
        return $this->prize_code;
    }
    public function getPrizeId()
    {
        return $this->prize_id;
    }
}
