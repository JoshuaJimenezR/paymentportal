<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index() {
        return view('payment.index');
    }

    public function create(Request $request) {

        $user = Auth::user();

        $order = $user->alias."-1001";

        $timestamp = time();

        $fullName = explode(" ",$request->input('creditCardHolderName'));

        $info = [
            "cc" => $request->input('creditCardNumber'),
            "cc_exp" => $request->input('creditCardExpiryMonth').$request->input('creditCardExpiryYear'),
            "currency" => 'USD',
            "amount" => $request->input('creditCardAmount'),
            "cvv" => $request->input('creditCardCVV'),
            "first_name" => $fullName[0],
            "last_name" => $fullName[1],
            "address1" => $request->input('creditAddress'),
            "city" => $request->input('creditCity'),
            "state" => $request->input('creditState'),
            "zip_code" => $request->input('creditZipCode'),
            "country" => $request->input('creditCountry'),
            "phone" => $request->input('creditContactNumber'),
            "email" => $user->email,
            "order" => $order,
            "order_description" => "",
            "ip_address" => $_SERVER['REMOTE_ADDR'],
            "timestamp" => $timestamp,
            "hash" => md5($order.$request->input('creditCardAmount').$timestamp)
        ];

        return $info;
    }
}
