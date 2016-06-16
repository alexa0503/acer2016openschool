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
    private $wechat_user;
    private $timestamp;
    public function __construct()
    {
        $session = \Request::session();
        $this->session = $session;
        $timestamp = time();
        $this->timestamp = $timestamp;
        $this->time = date('H:i:s', $timestamp);
        $this->date = date('Y-m-d', $timestamp);
        $this->prize_type = $session->get('lottery.id') == null ? 1 : 0;
        $this->wechat_user = \App\WechatUser::where('open_id', $session->get('wechat.openid'))->first();
    }
    public function run()
    {
        try {
            \DB::beginTransaction();
            $this->lottery();
            $this->record();
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            echo $e->getMessage()."<br/>";
            $this->prize_id = 0;
        }
        return $this->prize_id;
    }
    public function lottery()
    {
        $prize_type = $this->prize_type;
        $prize_id = $this->prize_id;//默认奖项
        //当前时段的中奖几率
        $date = $this->date;
        $time = $this->time;
        $timestamp = $this->timestamp;
        $wechat_user = $this->wechat_user;

        //判断当日是否中奖,已中奖则不发奖
        $count1 = \App\Lottery::where('user_id', $wechat_user->id)
            ->where('prize', '>', 0)
            ->where('lottery_time', '>=', date('Y-m-d', $timestamp))
            ->where('lottery_time', '<=', date('Y-m-d 23:59:59', $timestamp))
            ->sharedLock()
            ->count();
        if( $count1 > 0 ){
            $this->prize_id = 0;
            return;
        }

        //获取时间配置,当前为分配时间则不中奖,发默认奖
        $config = \App\LotteryConfig::where('start_time','<=',$time)->where('shut_time','>',$time)->first();
        if( $config == null ){
            return;
        }

        //获取中奖几率
        $rand_max = ceil(1/$config->win_odds);
        $rand1 = rand(1,$rand_max);
        $rand2 = rand(1,$rand_max);
        if( $rand1 != $rand2 ){
            return;
        }

        $seed = rand(1, 10000);
        //奖项分布情况,计算出中几等奖
        $prize_model = \App\Prize::where('seed_min', '<=', $seed)->where('seed_max', '>=', $seed);
        //无配置情况
        if( $prize_model->count() == 0 ){
            return;
        }

        $prize = $prize_model->first();

        //如果为12则不考虑
        if( $prize->id == 12 ){
            return;
        }
        //当日奖项设置
        $prize_config_model = \App\PrizeConfig::where('type', $prize_type)->where('lottery_date', $date)->where('prize', $prize->id);
        if( $prize_config_model->count() == 0 ){
            return;
        }
        $this->prize_id = $prize->id;
        //判断该用户是否中过此奖项
        $count2 = \App\Lottery::where('user_id', $wechat_user->id)
        ->where('prize', $prize->id)
        ->sharedLock()
        ->count();
        if( $count2 > 0){
            $this->prize_id = 0;
            return;
        }
        //奖池情况
        $prize_config = $prize_config_model->first();
        if( $prize_config->prize_num <= $prize_config->win_num ){
            return;
        }
        $this->prize_config_id = $prize_config->id;
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
        $wechat_user = $this->wechat_user;

        if (null == $session->get('lottery.id')) {
            $lottery = new \App\Lottery();
            $lottery->user_id = $wechat_user->id;
            $lottery->snid = null;
            $lottery->prize_code_id = null;
            $lottery->created_time = Carbon::now();
            $lottery->created_ip = \Request::getClientIp();
        } else {
            $lottery = \App\Lottery::find($session->get('lottery.id'));
        }
        if( $this->prize_id != 0){
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
        }
        $lottery->prize = $prize_id;
        $lottery->prize_type = $prize_type;
        $lottery->lottery_time = Carbon::now();
        $lottery->has_lottery = 1;
        $lottery->save();
        $session->set('lottery.id', null);
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
