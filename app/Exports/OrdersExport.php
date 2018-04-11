<?php

namespace App\Exports;

use App\Order;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrdersExport implements FromView{

    public function view(): View {
    	$user = Auth::user();

    	//Applying Filters
	    if (Input::has('startDate') && Input::has('endDate')) {
	        $startDate = Carbon::createFromFormat('Y-m-d H:s:i', Input::get('startDate')." 00:00:00");
	        $endDate = Carbon::createFromFormat('Y-m-d H:s:i', Input::get('endDate')." 23:59:59");
	    }else{
	        $startDate = Carbon::now()->startOfMonth();
	        $endDate =  cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y"))."-".date("m")."-2010 23:59:59";
	    }

		//Records
        if ($user->hasRole('admin')){
            $orders = Order::where("updated_at",">=", $startDate)->where("updated_at","<=",$endDate)->orderBy('updated_at', 'desc')->get();
        }else{
            $orders = $user->orders()->where("updated_at",">=", $startDate)->where("updated_at","<=",$endDate)->orderBy('updated_at', 'desc')->get();
        }
    

        return view('excel.orders', [
            'orders' => $orders
        ]);
    }

}