<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $port = 80;
        if($_SERVER['SERVER_ADDR'] == '10.10.5.20'){
            $port = 7071;
        }
        $baseUrl = 'http://'.$_SERVER['HTTP_HOST'].':'.$port.'/';
        return view('welcome',compact('baseUrl'));
    }
}
