<?php
namespace App\Helper;
class Lottery
{
    private $config = [
        ['title'=>'新西兰单人往返机票','sum'=>2,'odds'=>0],
        ['title'=>'携程网vip礼品卡','sum'=>2,'odds'=>1],
        ['title'=>'OLYMPUS E-PL7微单相机','sum'=>6,'odds'=>10],
        ['title'=>'赛睿Apex M800键盘','sum'=>5,'odds'=>10],
        ['title'=>'钢铁侠3纪念版游戏耳麦','sum'=>11,'odds'=>10],
        ['title'=>'LG趣拍得 POPO相印机','sum'=>12,'odds'=>10],
        ['title'=>'WD移动硬盘升级版','sum'=>10,'odds'=>10],
        ['title'=>'WD移动硬盘升级版','sum'=>10,'odds'=>10],
        ['title'=>'蜘蛛网电子礼品兑换券','sum'=>10,'odds'=>10],
        ['title'=>'蜘蛛网电影通兑券','sum'=>200,'odds'=>100],
        ['title'=>'携程网充值礼品卡','sum'=>50,'odds'=>20],
        ['title'=>'携程网充值礼品卡','sum'=>0,'odds'=>500],
        ['title'=>'蜘蛛网电子优惠券','sum'=>10000,'odds'=>500],
    ];
    public function run()
    {
        $distribution = $this->getDistribution();
        $max = $distribution[count($distribution) - 1][1];
        $rand = rand(0, $max);
        $prize = 12;//默认奖项
        foreach($distribution as $k => $v){
            if( $rand > $v[0] && $rand <= $v[1]){
                $prize = $k;
                break;
            }
        }
        return $prize+1;
    }
    //获取几率分布情况
    private function getDistribution()
    {
        $config = $this->config;
        $distribution = [];
        //$count = count($config);
        foreach ($config as $key => $value) {
            $min = $key == 0 ? 0 : $max;
            $max = $min + $value['odds'];
            $distribution[$key] = [$min, $max];
        }
        return $distribution;
    }
    public function getPrizeSum($prize)
    {
        $config = $this->config;
        return $config[$prize-1]['sum'];
    }
}
