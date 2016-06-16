<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
//use App\Http\Controllers\Controller;

class CmsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = \App\WechatUser::count();
        return view('cms/dashboard',['count' => $count]);
    }

    /**
     * 微信授权用户
     * @return mixed
     */
    public function wechat($id = null)
    {
        if( $id == null ){
            $wechat_users = DB::table('wechat_users')->paginate(20);
        }
        else{
            $wechat_users = DB::table('wechat_users')->where('id', $id)->paginate(20);
        }

        return view('cms/wechat_user',['wechat_users' => $wechat_users]);
    }

    /**
     * 账户管理
     */
    public function users()
    {
        $users = DB::table('users')->paginate(20);
        return view('cms/users', ['users' => $users]);
    }
    /**
     * @return mixed
     * session 查看
     */
    public function sessions($id = null)
    {
        if( null == $id)
            $sessions = DB::table('sessions')->paginate(20);
        else
            $sessions = DB::table('sessions')->where('id', '=', $id)->paginate(20);
        return view('cms/sessions', ['sessions' => $sessions]);
    }
    /**
     * 导出
     */
    public function export()
    {
        $filename = 'lottery'.date('YmdHis');
        $collection = \App\Photo::all();
        $data = $collection->map(function($item){
            return [
                $item->id,
                $item->sid,
                url('uploads/'.$item->image),
                $item->attitude,
                $item->self_name,
                $item->friend_name,
                $item->created_time,
                $item->created_ip,
            ];
        });
        Excel::create($filename, function($excel) use($data) {
            $excel->setTitle('照片');
            // Chain the setters
            $excel->setCreator('Alexa');
            // Call them separately
            $excel->setDescription('照片');
            $excel->sheet('Sheet', function($sheet) use($data) {
                $sheet->row(1, array('ID','sid','照片地址','态度','自己名','朋友名','创建时间','创建IP'));
                $sheet->fromArray($data, null, 'A2', false, false);
            });
        })->download('xlsx');
    }
    /**
     *账户管理
     */
    public function account()
    {
        return view('cms/account');
    }
    public function accountPost(Requests\AccountFormRequest $request)
    {
        //var_dump($request->user()->id);
        $user = \App\User::find($request->user()->id);
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return redirect('cms/logout');
        //var_dump($request->input('password'));
    }
    public function userLogs()
    {
        $logs = \App\UserLog::limit(30)->offset(0)->orderBy('create_time', 'DESC')->get();
        return view('cms/userLogs',['logs' => $logs]);
    }
}
