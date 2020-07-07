<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attestat;
use App\User;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $result = [];
        return response()->json(['success' => true, 'result' => $result]);
    }
}
