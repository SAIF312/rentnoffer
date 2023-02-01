<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceFee;

class ServiceFeeController extends Controller
{
    public function service_fee_percentage(){
        $serviceFee = ServiceFee::orderBy('created_at','DESC')->first()->value('s_fee');
        return response()->json([
            "status"=> 200,
            "message"=> "Service Fee Loaded Successfully!",
            "service_fee_percentage"=>$serviceFee
        ]);
    }
}
