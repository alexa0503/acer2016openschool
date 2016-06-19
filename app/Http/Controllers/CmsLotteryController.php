<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use DB;
//use Maatwebsite\Excel\Facades\Excel;
//use App\Http\Controllers\Controller;

class CmsLotteryController extends Controller
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
     * @return mixed
     * 查看
     */
    public function lotteries()
    {
        $prize = \Request::get('prize');
        if( empty($prize) ){
            $lotteries = \App\Lottery::paginate(20);
        }
        else{
            $lotteries = \App\Lottery::where('prize', $prize)->paginate(20);
        }

        $prizes = \App\Prize::all();
        return view('cms/lotteries', ['lotteries' => $lotteries,'prizes'=>$prizes]);
    }
    public function prizes()
    {
        $prizes = \App\Prize::paginate(20);
        return view('cms/prizes', ['prizes'=>$prizes]);
    }
    public function prizeUpdate($id)
    {
        $prize = \App\Prize::find($id);
        $prize->seed_min = \Request::input('seed_min');
        $prize->seed_max = \Request::input('seed_max');
        $prize->save();
        $result = [
            'ret'=> 0,
            'data'=> [
                'seed_min'=> $prize->seed_min,
                'seed_max'=> $prize->seed_max
            ],
        ];
        return json_encode($result);
    }
    public function lotteryConfigUpdate($id)
    {
        $prize = \App\LotteryConfig::find($id);
        $prize->start_time = \Request::input('start_time');
        $prize->shut_time = \Request::input('shut_time');
        $prize->win_odds = \Request::input('win_odds');
        $prize->save();
        $result = [
            'ret'=> 0,
            'data'=> [
                'start_time'=> $prize->start_time,
                'shut_time'=> $prize->shut_time,
                'win_odds'=> $prize->win_odds,
            ],
        ];
        return json_encode($result);
    }
    public function lotteryConfigAdd()
    {
        $prize = new \App\LotteryConfig();
        $prize->start_time = \Request::input('start_time');
        $prize->shut_time = \Request::input('shut_time');
        $prize->win_odds = \Request::input('win_odds');
        $prize->save();
        $result = [
            'ret'=> 0,
            'data'=> [
                'start_time'=> $prize->start_time,
                'shut_time'=> $prize->shut_time,
                'win_odds'=> $prize->win_odds,
            ],
        ];
        return json_encode($result);
    }
    public function prizeConfigs()
    {
        if( \Request::get('date') == null ){
            $date = date('Y-m-d');
        }
        else{
            $date = date('Y-m-d', strtotime(\Request::get('date')));
        }
        $dates = [];
        $timestamp = time();
        for( $i=0; $i<60; $i++){
            $dates[] = date('Y-m-d', strtotime('+'.$i.' day', $timestamp));
        }
        $prize_configs = \App\PrizeConfig::where('lottery_date', $date)->paginate(20);
        return view('cms/prize_configs', ['prize_configs'=>$prize_configs,'dates'=>$dates]);
    }
    public function prizeConfig($id)
    {
        $prize_config = \App\PrizeConfig::find($id);
        $prizes = \App\Prize::all();
        return view('cms/prize_config',['prize_config'=>$prize_config,'prizes'=>$prizes]);
    }
    public function prizeConfigUpdate($id)
    {
        $prize_config = \App\PrizeConfig::find($id);
        $prize_config->lottery_date = \Request::input('lottery_date');
        $prize_config->type = \Request::input('type');
        $prize_config->prize = \Request::input('prize');
        $prize_config->prize_num = \Request::input('prize_num');
        $prize_config->save();
        return redirect(url('cms/prize/configs?date='.$prize_config->lottery_date));
    }
    public function prizeConfigAdd()
    {
        $prizes = \App\Prize::all();
        return view('cms/prize_config_add',['prizes'=>$prizes]);
    }
    public function prizeConfigStore(Request $request)
    {
        $this->validate($request, [
            'lottery_date' => 'required|date',
            'prize_num' => 'required',
            'type' => 'required',
            'prize' => 'required',
        ]);
        $prize_config = new \App\PrizeConfig();
        $prize_config->lottery_date = \Request::input('lottery_date');
        $prize_config->type = \Request::input('type');
        $prize_config->prize = \Request::input('prize');
        $prize_config->prize_num = \Request::input('prize_num');
        $prize_config->save();
        return ['ret'=>0];
        // Store the blog post...
    }

    public function lotteryConfigs()
    {
        $lottery_configs = \App\LotteryConfig::paginate(20);
        return view('cms/lottery_configs', ['lottery_configs'=>$lottery_configs]);
    }

    public function prizeCodes()
    {
        $prize_codes = \App\PrizeCode::paginate(20);
        return view('cms/prize_codes', ['prize_codes'=>$prize_codes]);
    }


}
