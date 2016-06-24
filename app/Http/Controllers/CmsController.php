<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use DB;
use Maatwebsite\Excel\Facades\Excel;

//use App\Http\Controllers\Controller;

class CmsController extends Controller
{
    /**
     * Create a new controller instance.
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
        $prizes = \App\Prize::all();
        $start_time = strtotime(date('2016-06-20'));
        $n = ceil((time() - $start_time) / (3600 * 24));
        $data = [];
        for ($i = 0; $i < $n; ++$i) {
            $num = [];
            $timestamp = $start_time + $i * 24 * 3600;
            $date1 = date('Y-m-d', $timestamp);
            $date2 = date('Y-m-d 23:59:59', $timestamp);
            $prize_count = $prizes->map(function ($prize) use ($date1, $date2) {
                    $count = \App\Lottery::where('prize', $prize->id)
                        ->where('lottery_time', '>=', $date1)
                        ->where('lottery_time', '<=', $date2)
                        ->count();

                return $count;
            });
            $data[$date1] = $prize_count;
        }
        $prize_count = $prizes->map(function ($prize) {
                $count = \App\Lottery::where('prize', $prize->id)
                    ->count();

            return $count;
        });
        $data['Total'] = $prize_count;

        return view('cms/dashboard', ['count' => $count, 'prizes' => $prizes, 'data' => $data]);
    }

    /**
     * 微信授权用户.
     *
     * @return mixed
     */
    public function wechat($id = null)
    {
        if ($id == null) {
            $wechat_users = DB::table('wechat_users')->paginate(20);
        } else {
            $wechat_users = DB::table('wechat_users')->where('id', $id)->paginate(20);
        }

        return view('cms/wechat_user', ['wechat_users' => $wechat_users]);
    }
    public function infos()
    {
        $infos = \App\Info::paginate(20);

        return view('cms/infos', ['infos' => $infos]);
    }
    /**
     * 账户管理.
     */
    public function users()
    {
        $users = DB::table('users')->paginate(20);

        return view('cms/users', ['users' => $users]);
    }
    /**
     * @return mixed
     *               session 查看
     */
    public function sessions($id = null)
    {
        if (null == $id) {
            $sessions = DB::table('sessions')->paginate(20);
        } else {
            $sessions = DB::table('sessions')->where('id', '=', $id)->paginate(20);
        }

        return view('cms/sessions', ['sessions' => $sessions]);
    }

    /**
     *账户管理.
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

        return view('cms/userLogs', ['logs' => $logs]);
    }

     /**
      * 导出.
      */
     public function export($table)
     {
         if ($table == 'lottery') {
             $collection = \App\Lottery::where('prize', '>', '0')->where('prize', '!=', '12')->get();

             $data = $collection->map(function ($item) {
                    $name = $item->user->info == null ? '--' : $item->user->info->name;
                    $mobile = $item->user->info == null ? '--' : $item->user->info->mobile;
                    $address = $item->user->info == null ? '--' : $item->user->info->address;
                    $prize_type = $item->prize_type == 1 ? '普通' : '输码';
                    $snid = $item->snid ?: '--';
                    $prize_info = $item->prizeInfo != null ? $item->prizeInfo->title : '--';
                    $prize_code = $item->prize_code_id != null ? $item->prizeCode->prize_code : '--';
                    $lottery_time = $item->lottery_time ?: '--';

                 return [
                     json_decode($item->user->nick_name),
                     $item->user->open_id,
                     $name,
                     $mobile,
                     $address,
                     $prize_type,
                     $snid,
                     $prize_info,
                     $prize_code,
                     $lottery_time,
                 ];
             });
             $titles = ['微信用户', '微信openId', '姓名',  '手机号', '地址', '抽奖方式', 'SNID', '奖品', '奖券', '抽奖时间'];
             $excel_title = '用户信息';
         } elseif ($table == 'wechat') {
             $collection = \App\WechatUser::all();
             $data = $collection->map(function ($item) {
                 return [
                     $item->id,
                     $item->open_id,
                     json_decode($item->nick_name),
                     $item->head_img,
                     $item->gender,
                     $item->country,
                     $item->province,
                     $item->city,
                     $item->create_time,
                     $item->create_ip,
                 ];
             });
             $titles = ['ID', 'openid', '昵称', '头像', '性别', '国家', '省份', '城市', '授权时间', '授权IP'];
             $excel_title = '授权用户';
         } else {
             return;
         }
         $filename = $table.date('_Y-m-d');
         Excel::create($filename, function ($excel) use ($data, $excel_title, $titles) {
             $excel->setTitle($excel_title);
             // Chain the setters
             $excel->setCreator('Alexa');
             // Call them separately
             $excel->setDescription($excel_title);
             $excel->sheet('Sheet', function ($sheet) use ($data, $titles) {
                 $sheet->row(1, $titles);
                 $sheet->fromArray($data, null, 'A2', false, false);
             });
         })->download('xlsx');
     }
}
