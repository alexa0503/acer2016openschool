<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
//use Carbon;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('wechat.auth');
    }

    public function index()
    {
        return view('index');
    }
}
