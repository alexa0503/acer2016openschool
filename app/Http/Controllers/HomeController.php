<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helper;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('wechat.auth');
    }

    public function index(Request $request)
    {
        $wechat_user = \App\WechatUser::where('open_id', $request->session()->get('wechat.openid'))->first();
        $lottery = \App\Lottery::where('user_id', $wechat_user->id)->where('prize', '>', 0)->first();

        $prize_id = null == $lottery ? 0 : $lottery->prize;
        $has_lottery = null == $lottery ? true : false;
        $info = \App\Info::find($wechat_user->id);
        return view('index', [
            'prize_id' => $prize_id,
            'has_lottery' => $has_lottery,
            'info' => $info,
        ]);
    }

    //snid提交
    public function snid(Request $request)
    {
        $result = ['ret' => 0, 'msg' => ''];
        $snid = $request->get('snid');
        if (null == $snid) {
            $result = ['ret' => 1001, 'msg' => '请输入SNID'];
            return json_encode($result);
        }

        #测试
        $url = env('SNID_API');
        $response = Helper\HttpClient::post($url, ['snid' => $snid]);
        if(env('APP_ENV') == 'local' || env('APP_ENV') == 'dev' ){
            $response = 1;
        }

        if ($response == 1) {
            $row = \App\Lottery::where('snid', $snid);
            $wechat_user = \App\WechatUser::where('open_id', $request->session()->get('wechat.openid'))->first();
            //未使用或者当前用户使用未被兑换
            if ($row->count() == 0 || $row->first()->user_id == $wechat_user->id) {
                $lottery = new \App\Lottery();
                $lottery->user_id = $wechat_user->id;
                $lottery->snid = $snid;
                $lottery->has_lottery = 0;
                $lottery->prize = 0;
                $lottery->prize_type = 0;
                $lottery->prize_code_id = null;
                $lottery->lottery_time = null;
                $lottery->created_time = Carbon::now();
                $lottery->created_ip = $request->getClientIp();
                $lottery->save();
                $request->session()->set('lottery.id', $lottery->id);
            } else {
                $result = ['ret' => 1003, 'msg' => '此SNID已经使用过了~'];
            }
        } else {
            $result = ['ret' => 1002, 'msg' => 'SNID不正确，请重新输入~'];
        }

        return json_encode($result);
    }
    //信息提交
    public function info(Request $request)
    {
        $result = ['ret' => 0, 'msg' => ''];
        if (null == $request->input('name')) {
            $result = ['ret' => 1001, 'msg' => '姓名不能为空~'];
        } elseif (!preg_match('/1\d{10}/i', $request->input('mobile'))) {
            $result = ['ret' => 1003, 'msg' => '手机号不符合规则~'];
        } elseif (null == $request->input('address')) {
            $result = ['ret' => 1002, 'msg' => '地址不能为空~'];
        } else {
            $wechat_user = \App\WechatUser::where('open_id', $request->session()->get('wechat.openid'))->first();
            if (null == $wechat_user->info) {
                $info = new \App\Info();
                $info->id = $wechat_user->id;
                $info->name = $request->input('name');
                $info->mobile = $request->input('mobile');
                $info->address = $request->input('address');
                $info->created_time = Carbon::now();
                $info->created_ip = $request->getClientIp();
                $info->save();
            } else {
                $result = ['ret' => 1101, 'msg' => '信息已经填写过啦~'];
            }
        }

        return json_encode($result);
    }
    //抽奖
    public function lottery(Request $request)
    {
        //ip黑名单
        $ips = ['183.9.43.55','113.117.70.183','113.86.28.30','113.86.14.60'];
        $lotteries = \App\Lottery::select(\DB::raw('count(*) as ip_count, created_ip'))->groupBy('created_ip')->get();
        foreach( $lotteries as $lottery){
            if($lottery->ip_count > 50){
                $ips[] = $lottery->created_ip;
            }
        }

        if( in_array($request->getClientIp(), $ips) ){
            //return ['ret' => 1001, 'prize' => [], 'msg' => '请通过正常方式抽奖~'];
            return ['ret' => 0, 'prize' => [], 'msg' => ''];
        }
        $result = ['ret' => 0, 'prize' => [], 'msg' => ''];
        $wechat_user = \App\WechatUser::where('open_id', $request->session()->get('wechat.openid'))->first();
        $lottery = \App\Lottery::where('user_id', $wechat_user->id)->orderBy('created_time', 'DESC')->first();

        $lottery_timestamp = null == $lottery ? 0 : strtotime($lottery->created_time);
        $count = \App\Lottery::where('user_id', $wechat_user->id)->count();
        if( $lottery_timestamp + 15 > time() || $count >= 100){
            //$result = ['ret' => 1001, 'prize' => [], 'msg' => '请通过正常方式抽奖~'];
            return ['ret' => 0, 'prize' => [], 'msg' => ''];
        }
        else{
            $lottery = new Helper\Lottery();
            $lottery->run();
            //$prize_code = $lottery->getCode();
            $prize_id = $lottery->getPrizeId();
            $prize = \App\Prize::find($prize_id);
            //$result['prize']['id'] = $prize_id;
            $result['prize_id'] = $prize_id;
            $result['prize_title'] = $prize->title;

        }


        return json_encode($result);
    }
}
