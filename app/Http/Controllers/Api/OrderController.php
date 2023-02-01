<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Product, Order, Address, User};
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function availiability($id,Request $request){
        $month = $request->month;
        $product =  Product::where('id',$id)->with('slots')->first();
        $unavailable_days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
        $order = '';
        if($product){
            // if($product->type_id == 2)
            // {
                // fetching booked order if any

                $orders = Order::where('product_id', $id);
                // ->first();
                if(isset($request->month))
                {
                    $orders = $orders->whereMonth('start_time',date('m',strtotime(Carbon::parse($request->month))))
                            ->whereYear('start_time',date('Y',strtotime(Carbon::parse($request->month))));
                }
                $orders = $orders->get();
                $dates = [];
                foreach($orders as $order){
                    $dates = $this->Dates($order->start_time, $order->end_time, $product->type_id);
                }


                // returning unavailable days for the specific product
                foreach($product->slots as $key=>$slot){
                    if (($key = array_search($slot->day->title,$unavailable_days)) !== false) {
                        unset($unavailable_days[$key]);
                    }
                }

                return response()->json([
                    "status"=>200,
                    "message"=>'fetch product successfully!',
                    "product"=>[
                        'unavailable_days'=>array_values($unavailable_days),
                        'booked'=>$dates,
                    ]
                ]);
            // }
            // if($product->type_id == 1)
            // {
            //     // fetching booked order if any

            //     $order = Order::where('product_id', $id)->first();
            //     $dates = $this->Dates($order->start_time, $order->end_time, $product->type_id);
            //     // returning unavailable days for the specific product
            //     foreach($product->slots as $key=>$slot){
            //         if (($key = array_search($slot->day->title,$unavailable_days)) !== false) {
            //             unset($unavailable_days[$key]);
            //         }
            //     }

            //     return response()->json([
            //         "status"=>200,
            //         "message"=>'fetch product successfully!',
            //         "product"=>[
            //             'unavailable_days'=>array_values($unavailable_days),
            //             'booked'=>$dates,
            //         ]
            //     ]);
            // }

        }
    }

    private function Dates($startDate, $endDate, $typeId)
    {
        $rangArray = [];
        if($typeId == 1){
            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);

            for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
                $date = date('Y-m-d', $currentDate);
                $rangArray[] = $date;
            }

            return $rangArray;
        }
        if($typeId == 2){
            // dd($endDate);
            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);

            for ($currentDate = $startDate; $currentDate <= $endDate;
                                            $currentDate += (86400)) {

                $date = date('Y-m-d H:i:s', $currentDate);
                $rangArray[] = $date;
            }
            for ($currentDate = $endDate; $currentDate >= $startDate;
            $currentDate -= (86400)) {

            $date = date('Y-m-d H:i:s', $currentDate);
            $rangArray[] = $date;
            }

            // foreach($rangArray as $arr){
            //   array_search($slot->day->title,$unavailable_days);
            //   $new_array[] =  date('Y-m-d', $arr);
            // }
            return $rangArray;
        }

    }

    public function order(Request $request){
        try{

            $product = Product::with('user','type')->where('id', $request->product_id)->where('status_id',8)->first();
            if($product){
                $stripe = new \Stripe\StripeClient(
                    env('STRIPE_SECRET')
                );

                // creating payment intent for payment

                $intent = $stripe->paymentIntents->create([
                    'amount' => ((float)$request->amount + (float)$request->service_fee) * 100,
                    'currency' => $request->currency,
                    'customer' =>auth()->user()->stripe_id,
                    'payment_method_types' => ['card'],
                ]);


                // confirm payment deduction through payment intent created earlier

                $payment = $stripe->paymentIntents->confirm(
                    $intent->id,
                    ['payment_method' => $request->payment_method]
                );

                if($payment->status == "succeeded"){

                    $product->update(['sales'=>(int)($product->sales) + 1]);
                    auth()->user()->update(['borrower_revenue'=>(float)(auth()->user()->borrower_revenue)+(float)$request->amount]);
                    $product->user->update(['lender_revenue'=>(float)($product->user->lender_revenue)+(float)$request->amount]);

                    if($product->type->title == "Item"){
                        $order = Order::create([
                            'user_id' => auth()->id(),
                            'product_id'=>$request->product_id,
                            'payment_intent'=>$payment->id,
                            'amount'=>$request->amount,
                            'service_fee'=>$request->service_fee,
                            'start_time'=>date('Y-m-d',strtotime($request->start_date)).' 00:00:00',
                            'end_time'=>date('Y-m-d',strtotime($request->end_date)).' 23:59:59',
                        ]);
                        if($order){
                            $address = Address::create([
                                'order_id' => $order->id,
                                'state_id' => $request->state_id,
                                'address_name' => $request->address_name,
                                'first_name' => $request->first_name,
                                'last_name' => $request->last_name,
                                'email' => $request->email,
                                'phone' => $request->phone,
                                'lat' => $request->lat,
                                'lng' => $request->lng,
                                'address1' => $request->address1,
                                'address2' => $request->address2,
                                'city' => $request->city,
                                'zipcode' => $request->zipCode,
                            ]);
                        }
                        if($order){
                            return response()->json([
                                'status' => 200,
                                'message'=>'order placed successfully!',
                            ],200);
                        }


                    }
                    if($product->type->title == "Experience"){
                        $order = Order::create([
                            'user_id' => auth()->id(),
                            'product_id'=>$request->product_id,
                            'payment_intent'=>$payment->id,
                            'amount'=>$request->amount,
                            'service_fee'=>$request->service_fee,
                            'start_time'=>date('Y-m-d',strtotime($request->start_date)).' '.date('H:i:s', strtotime($request->start_time)),
                            'end_time'=>date('Y-m-d',strtotime($request->end_date)).' '.date('H:i:s', strtotime($request->end_time)),
                        ]);
                        if($order){
                            return response()->json([
                                'status' => 200,
                                'message'=>'order placed successfully!',
                            ],200);
                        }
                    }
                }
            }else{
                return response()->json([
                    'status' => 403,
                    'message'=>'product is not available!'
                ],403);
            }


        }catch(Exception $e){
            return response()->json([
                'status' => 500,
                'message'=>$e->getMessage()
            ],500);
        }
    }
}
