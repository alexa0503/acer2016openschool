<?php
/*
Route::group(['middleware' => ['web','wechat.oauth']], function () {
    Route::get('/user', function () {
        $user = session('wechat.oauth_user'); // 拿到授权用户资料
        dd($user);
    });
    //Route::get('/', 'HomeController@index');
});
Route::any('/wechat', 'WechatController@serve');
*/
Route::get('/', 'HomeController@index');
Route::post('snid', 'HomeController@snid');
Route::post('lottery', 'HomeController@lottery');
Route::post('info', 'HomeController@info');
Route::get('/wx/share', function(){
    $url = urldecode(Request::get('url'));
    $options = [
      'app_id' => env('WECHAT_APPID'),
      'secret' => env('WECHAT_SECRET'),
      'token' => env('WECHAT_TOKEN')
    ];
    $wx = new EasyWeChat\Foundation\Application($options);
    $js = $wx->js;
    $js->setUrl($url);
    $config = json_decode($js->config(array('onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ'), false), true);
    $share = [
      'title' => env('WECHAT_SHARE_TITLE'),
      'desc' => env('WECHAT_SHARE_DESC'),
      'link' => env('APP_URL'),
      'imgUrl' => asset(env('WECHAT_SHARE_IMG')),
    ];
    return json_encode(array_merge($share, $config));
});
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//Route::auth();
//登录登出
Route::get('cms/login', 'Auth\AuthController@getLogin');
Route::post('cms/login', 'Auth\AuthController@postLogin');
Route::get('cms/logout', 'Auth\AuthController@logout');
//屏蔽注册路由
Route::any('/register', function(){

});
//Route::get('/register', 'Auth\AuthController@getRegister');
//Route::post('/register', 'Auth\AuthController@postRegister');

//Route::get('/home', 'HomeController@index');

Route::get('/cms', 'CmsController@index');
Route::get('/cms/users', 'CmsController@users');
Route::get('/cms/account', 'CmsController@account');
Route::post('/cms/account', 'CmsController@accountPost');
Route::get('/cms/wechat', 'CmsController@wechat');
Route::get('/cms/wechat/{id}', 'CmsController@wechat');
Route::get('/cms/user/logs', 'CmsController@userLogs');
//Route::get('/cms/wechat/export', 'CmsController@wechatExport');
Route::get('/cms/lotteries', 'CmsController@lotteries');
//Route::get('/cms/lotteries/export', 'CmsController@lotteriesExport');
Route::get('/cms/sessions', 'CmsController@sessions');
Route::get('/cms/session/{id}', 'CmsController@sessions');
Route::get('/cms/prizes', 'CmsController@prizes');
Route::get('/cms/prize/update/{id}', 'CmsController@prizeUpdate');

//wechat auth
Route::any('/wechat/auth', 'WechatController@auth');
Route::any('/wechat/callback', 'WechatController@callback');

//初始化后台帐号
Route::get('cms/account/init', function(){
    if( 0 == \App\User::count()){
        $user = new \App\User();
        $user->name = 'admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('admin123');
        $user->save();
    }
    return redirect('/cms');
});
