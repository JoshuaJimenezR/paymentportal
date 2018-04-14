<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index() {
        return view('payment.index');
    }

    public function create(Request $request) {
        //Take authenticated user
        $user = Auth::user();

        //Validate request input
        $this->validate($request, [
            'creditCardNumber' => 'required|string',
            'creditCardHolderName' => 'required|string',
            'creditCardExpiryMonth' => 'required',
            'creditCardExpiryYear' => 'required',
            'creditCardAmount' => 'required',
            'creditCardCVV' => 'required|min:3',
            'creditCountry' => 'required|string',
            'creditAddress' => 'required|string',
            'creditCity' => 'required|string',
            'creditState' => 'required|string',
            'creditZipCode' => 'required|string',
            'creditContactNumber' => 'required|string',
            'orderDescription' => 'required|string',
        ]);

        //set Data
        $timestamp = time();
        $amount = number_format((float)$request->input('creditCardAmount'), 2, '.', '');
        $email = $user->email;
        $ipAddress = $_SERVER['REMOTE_ADDR'];

        //Save Order
        $order = new Order;
        $order->user_id = $user->id;
        $order->card_number = $request->input('creditCardNumber');
        $order->card_holder_name = $request->input('creditCardHolderName');
        $order->card_expirity_month = $request->input('creditCardExpiryMonth');
        $order->card_expirity_year = $request->input('creditCardExpiryYear');
        $order->amount = $amount;
        $order->card_cvv = $request->input('creditCardCVV');
        $order->country = $request->input('creditCountry');
        $order->address = $request->input('creditAddress');
        $order->city = $request->input('creditCity');
        $order->state = $request->input('creditState');
        $order->zipcode = $request->input('creditZipCode');
        $order->phone_number = $request->input('creditContactNumber');
        $order->email = $email;
        $order->ip_address = $ipAddress;
        $order->save();

        //Set Order data
        $orderBank = $user->alias."-".$order->id;
        $hash = md5($orderBank."|".$amount."|".$timestamp);
        $fullName = explode(" ",$request->input('creditCardHolderName'));


        //Set Data for bank Api
        $info = [
            "cc" => $request->input('creditCardNumber'),
            "cc_exp" => $request->input('creditCardExpiryMonth').$request->input('creditCardExpiryYear'),
            "currency" => 'USD',
            "amount" => $amount,
            "cvv" => $request->input('creditCardCVV'),
            "first_name" => $fullName[0],
            "last_name" => (isset($fullName[1])? $fullName[1]: ""),
            "address1" => $request->input('creditAddress'),
            "city" => $request->input('creditCity'),
            "state" => $request->input('creditState'),
            "zip_code" => $request->input('creditZipCode'),
            "country" => $request->input('creditCountry'),
            "phone" => $request->input('creditContactNumber'),
            "email" => $email,
            "order" => $orderBank,
            "order_description" => $request->input('orderDescription'),
            "ip_address" => $ipAddress,
            "timestamp" => $timestamp,
            "hash" => $hash
        ];

        //Call bank Api
        //$credentials = base64_encode('panamamedical:xphOqvSMelMWpCNa9QpyOMJC5styAiYY');
        $credentials = base64_encode('mtmarketing:xyBjukme5TLWE4YWL9TmLWtPFcsRB2Cn');

        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, 'https://tscproc.com/proc/pp');
        curl_setopt( $ch, CURLOPT_HEADER, true );
        curl_setopt( $ch, CURLOPT_ENCODING, 'UTF-8' );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($info) );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Basic '.$credentials
            )
        );
        $response = curl_exec( $ch );

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        $bankResponse = json_decode($body, true);

        //Update Order
        $updateOrder = Order::find($order->id);

        $updateOrder->order = $orderBank;
        $updateOrder->order_description = $request->input('orderDescription');
        $updateOrder->response_code = $bankResponse['data']['response_code'];
        $updateOrder->response = $bankResponse['data']['response_text'];
        $updateOrder->transaction_id = $bankResponse['data']['transaction_id'];

        $updateOrder->save();

        if($bankResponse['data']['response_code'] == 100){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Transaction Approved!');
        }else{
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Transaction Rejected!');
        }

        return redirect('/');

    }
}
