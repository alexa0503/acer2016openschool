<?php

namespace App\Http\Middleware;

use Closure;

class WechatAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->session()->set('wechat.redirect_uri', $request->getUri());
        if( env('APP_ENV') == 'local' ){
            $request->session()->set('wechat.openid','o2-sBj0oOQJCIq6yR7I9HtrqxZcY');
        }
        if( null == $request->session()->get('wechat.openid') && $request->getClientIp() != '127.0.0.1'){
            return redirect('/wechat/auth');
        }
        return $next($request);
    }
}
