<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = Auth::user();

        //Dashboard Header
        $todayTransaction = DB::table('orders')
            ->select(DB::raw('*'))
            ->whereRaw('Date(created_at) = CURDATE()')
            ->count();
        $todayAmount = DB::table('orders')
            ->select(DB::raw('amount'))
            ->whereRaw('Date(created_at) = CURDATE()')
            ->sum('amount');
        $monthTransactions = Order::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $monthAmount = Order::where('created_at', '>=', Carbon::now()->startOfMonth())->sum('amount');

        //Records
        if ($user->hasRole('admin')){
            $orders = Order::orderBy('id', 'desc')->paginate(10);
        }else{
            $orders = $user->orders()->orderBy('created_at', 'desc')->paginate(10);
        }

        return view('home', compact('orders','todayTransaction','todayAmount', 'monthTransactions', 'monthAmount'));
    }
}
