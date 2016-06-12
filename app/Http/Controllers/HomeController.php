<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use App\Helper;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('wechat.auth');
    }

    public function index()
    {
        return view('index');
    }

    //snid提交
    public function snid(Request $request)
    {
        $result = ['ret'=>0, 'msg'=>''];
        $snid = $request->get('snid');
        if( null == $snid){
            $result = ['ret'=>1001, 'msg'=>'请输入SNID'];
            return json_encode($result);
        }

        $url = env('SNID_API');
        $response = Helper\HttpClient::post($url, ['snid'=>$snid]);
        if( $response == 1){
            $count = \App\Lottery::where('snid', $snid)->count();
            if( $count == 0){
                $wechat = \App\WechatUser::where('open_id', $request->session()->get('wechat.openid'))->first();
                $lottery = new \App\Lottery();
                $lottery->user_id = $wechat->id;
                $lottery->snid = $snid;
                $lottery->has_lottery = 0;
                $lottery->prize = 0;
                $lottery->prize_code_id = null;
                $lottery->lottery_time = null;
                $lottery->created_time = Carbon::now();
                $lottery->created_ip = $request->getClientIp();
                $lottery->save();
                $request->session->set('lottery.id', $lottery->id);
            }
            else{
                $result = ['ret'=>1003, 'msg'=>'此SNID已经使用过了~'];
            }
        }
        else{
            $result = ['ret'=>1002, 'msg'=>'SNID不正确，请重新输入~'];
        }
        return json_encode($result);
    }
    //抽奖
    public function lottery(Request $request)
    {
        $result = ['ret'=>0, 'prize'=>rand(1,13), 'msg'=>''];
        return json_encode($result);
        if( null != $request->session->set('lottery.id')){
            $lottery = new Helper\Lottery();
            $prize = $lottery->run();
            $sum = $lottery->getPrizeSum($prize);
            $count = \App\Lottery::where('prize', $prize)->count();
            if($count >= $sum){
                $prize = 12;
            }
            $result['prize'] = $prize;
            //蜘蛛网
            $lottery = \App\Lottery::find($request->session->set('lottery.id'));
            if( in_array($prize, [9,10,13]) ){
                $prize_code = \App\PrizeCode::where('is_active',0)->where('prize', $prize)->first();
                $prize_code->status = 1;
                $prize_code->save();
                $lottery->prize_code_id = $prize_code->id;
            }
            $lottery->prize = $prize;
            $lottery->lottery_time = Carbon::now();
            $lottery->has_lottery = 1;
            $lottery->save();
        }
        else{
            $lottery = new \App\Lottery();
            $lottery->user_id = $wechat->id;
            $lottery->snid = null;
            $lottery->has_lottery = 1;
            $lottery->prize = 12;
            $lottery->prize_code_id = null;
            $lottery->lottery_time = Carbon::now();
            $lottery->created_time = Carbon::now();
            $lottery->created_ip = $request->getClientIp();
            $lottery->save();
        }
        $request->session->set('lottery.id', null);
        return json_encode($result);
    }
}
