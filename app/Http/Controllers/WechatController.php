<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Helper;
use Carbon\Carbon;

class WechatController extends Controller
{
    protected $app_id = 'wx1f984cba30eb34b7';
    public function auth(Request $request)
    {
        $app_id = $this->app_id;
        //$callback_url = $request->session()->get('wechat.redirect_uri');
        $callback_url = $request->getUriForPath('/wechat/callback');
        $url = "http://wx.ompchina.net/sns/oauth2?appid=".$app_id."&redirecturl=".$callback_url."&oauthscope=snsapi_userinfo";
        return redirect($url);
    }
    public function callback(Request $request)
    {
        $app_id = $this->app_id;
        $openid = $request->get('openid');
        $url = "http://wx.ompchina.net/sns/UserInfo?appId={$app_id}&openid={$openid}";
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
