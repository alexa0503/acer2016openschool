<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Helper;
use Carbon\Carbon;

class WechatController extends Controller
{
    public function auth(Request $request)
    {
        $app_id = env('WECHAT_APPID');
        //$callback_url = $request->session()->get('wechat.redirect_uri');
        $callback_url = $request->getUriForPath('/wechat/callback');
        //$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$app_id."&redirecturl=".$callback_url."&oauthscope=snsapi_userinfo";
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$app_id."&redirect_uri=".$callback_url."&response_type=code&scope=snsapi_userinfo&state=$state#wechat_redirect";
        return redirect($url);
    }
    public function callback(Request $request)
    {
        $app_id = env('WECHAT_APPID');
        $secret = env('WECHAT_SECRET');
        $code = $request->get('code');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $app_id . "&secret=" . $secret . "&code=$code&grant_type=authorization_code";
        $data = Helper\HttpClient::get($url);
        $token = json_decode($data);
        if (isset($token->errcode) && $token->errcode != 0) {
            return view('errors/503',['error_msg' => '获取用户信息失败~']);
        }

        $wechat_token = $token->access_token;
        $openid = $token->openid;

        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$wechat_token}&openid={$openid}";
        $data = Helper\HttpClient::get($url);
        $user_data = json_decode($data);
        if(isset($user_data) && isset($user_data->errcode)){
            //echo $user_data->message;
            return view('errors/503',['error_msg' => $user_data->message]);
            //return $user_data->message;
        }
        else{
            $wechat_user = \App\WechatUser::where('open_id',$openid);
            if($wechat_user->count() > 0){
                $wechat = $wechat_user->first();
            }
            else{
                $wechat = new \App\WechatUser();
                $wechat->open_id = $openid;
                $wechat->create_time = Carbon::now();
                $wechat->create_ip = $request->getClientIp();
            }
            $wechat->gender = $user_data->sex;
            $wechat->head_img = $user_data->headimgurl;
            $wechat->nick_name = json_encode($user_data->nickname);
            $wechat->country = $user_data->country;
            $wechat->province = $user_data->province;
            $wechat->city = $user_data->city;
            //$wechat->options = $options;
            $wechat->save();
            $request->session()->set('wechat.openid', $openid);
        }
    }
}
