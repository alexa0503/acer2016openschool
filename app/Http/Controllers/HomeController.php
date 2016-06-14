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
                $query->orderBy('created_time', 'desc');
            }],'info')->first();
        return view('index', ['lotteries' => $wechat_user->lotteries, 'info' => $wechat_user->info]);
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

        $url = env('SNID_API');
        $response = Helper\HttpClient::post($url, ['snid' => $snid]);
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
        $prize_id = 12;
        $_prize_code = null;
        $session = \Request::session();
        \DB::beginTransaction();
        try {
            $prize_type = $session->get('lottery.id') == null ? 1 : 0;
            $lottery = new Helper\Lottery();
            $prize_id = $lottery->run($prize_type);
            //$prize_id = 1;
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
                    $_prize_code = $prize_code->prize_code;
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
            $session->set('lottery.id', null);
            \DB::commit();
        } catch (Exception $e) {
            $result = ['ret' => 1001, 'msg' => $e->getMessage()];
            \DB::rollBack();
        }
        $prize = \App\Prize::find($prize_id);
        $result['prize']['id'] = $prize_id;
        $result['prize']['title'] = $prize->title;
        $result['prize']['imgUrl'] = asset('assets/images/ai'.$prize_id.'.png');
        $result['prize']['code'] = $_prize_code;

        return json_encode($result);
    }
}
