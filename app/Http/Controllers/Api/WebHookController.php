<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WebHookController extends Controller
{
    public function stripe_webhook(Request $request)
    {
        $data = $request->getContent();
        $format = json_decode($data);

        // return $format->status;
        if ($format->status = "succeeded") {
            try{
                Payment::create([
                    'customer'=>$format->customer,
                    'payment_method_id'=>$format->payment_method,
                    'payment_intent'=>$format->id,
                    'amount'=>$format->amount_received/100,
                    'currency'=>$format->currency,
                    'status'=>$format->status,
                    'created'=>date('Y-m-d H:i:s',strtotime(Carbon::parse($format->created)))
                ]);
                return response()->json([
                    "status"=>200,
                    "message" =>"payment added successfully!"
                ],200);
            }catch(Exception $e){
                return response()->json([
                    "status"=>500,
                    "message" =>$e->getMessage()
                ],500);
            }
        }
    }
}
