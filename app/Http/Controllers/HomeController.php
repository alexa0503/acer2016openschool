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
        $wechat_user = \App\WechatUser::where('open_id', $request->session()->get('wechat.openid'))
            ->with(['lotteries' => function ($query) {
                $query->where('prize', '!=', 12)->where('prize', '!=', 0)->orderBy('created_time', 'desc');
            }],'info')->first();
        $lottery_ctrip = \App\Lottery::where('prize', 12)->where('user_id',$wechat_user->id)->first();

        return view('index', ['lotteries' => $wechat_user->lotteries, 'lottery_ctrip'=>$lottery_ctrip, 'info' => $wechat_user->info]);
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
        //$response = 1;
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
    public function lottery()
    {
        $result = ['ret' => 0, 'prize' => [], 'msg' => ''];
        $lottery = new Helper\Lottery();
        $lottery->run();
        $prize_code = $lottery->getCode();
        $prize_id = $lottery->getPrizeId();
        //$lottery->record();
        $result['prize']['id'] = $prize_id;
        if( $prize_id != 0){
            $prize = \App\Prize::find($prize_id);
            $result['prize']['title'] = $prize->title;
            $result['prize']['imgUrl'] = asset('assets/images/ai'.$prize_id.'.png');
            $result['prize']['code'] = $prize_code;
        }

        return json_encode($result);
    }
}
