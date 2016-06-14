<?php
namespace App\Helper;
class Lottery
{
    public function run($type = 0)
    {
        $prize_id = 12;//默认奖项
        //当前时段的中奖几率
        $timestamp = time();
        $time = date('H:i:s', $timestamp);
        $date = date('Y-m-d', $timestamp);
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
                $prize_config_model = \App\PrizeConfig::where('type', $type)->where('lottery_date', $date)->where('prize', $prize->id);
                if( $prize_config_model->count() > 0){
                    //奖池情况
                    $prize_config = $prize_config_model->first();
                    //var_dump($prize_config->prize_num);
                    if( $prize_config->prize_num > $prize_config->win_num ){
                        $prize_id = $prize->id;
                        $prize_config->win_num += 1;
                        $prize_config->save();
                    }
                }
                /*
                $count = \App\Lottery::where('prize', $prize->id)->count();
                if( $count < $prize->sum ){
                    $prize_id = $prize->id;
                }
                */
            }
        }
        return $prize_id;
    }
}
