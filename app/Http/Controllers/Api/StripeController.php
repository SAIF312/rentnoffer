<?php

namespace App\Http\Controllers\Api;

use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function create_payment_method(Request $request){
        try{
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
              );
            $stripe_response = $stripe->paymentMethods->create([
                'type' => 'card',
                'card' => [
                  'number' => $request->number,
                  'exp_month' => $request->exp_month,
                  'exp_year' => $request->exp_year,
                  'cvc' => $request->cvc,
                ],
            ]);
            $card = PaymentMethod::create([
                'user_id'=>auth()->id(),
                'payment_method'=>$stripe_response->id,
                'last_digit'=>$stripe_response->card->last4,
                'type'=>$stripe_response->type,
                'brand'=>$stripe_response->card->brand,
            ]);
            if($card){
                return response()->json([
                    'status' => 200,
                    'message'=>'card added successfully!'
                ],200);
            }
        }catch(Exception $e){
            return response()->json([
                'status' => 500,
                'message'=>$e->getMessage()
            ],500);
        }
    }

    public function attach_payment_method(Request $request){
        $attach_card = PaymentMethod::where('id',$request->payment_id)->with('user:id,stripe_id')->first();
        try{
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );
            $stripe->paymentMethods->attach(
                $attach_card->payment_method ,
                ['customer' => $attach_card->user->stripe_id]
            );
            return response()->json([
                'status' => 200,
                'message'=>'card added to stripe successfully!'
            ],200);
        }catch(Exception $e){
            return response()->json([
                'status' => 500,
                'message'=>$e->getMessage()
            ],500);
        }

    }

    public function create_payment_intent(Request $request){
        try{
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );
            $intent = $stripe->paymentIntents->create([
                'amount' => $request->amount * 100,
                'currency' => $request->currency,
                'customer' =>auth()->user()->stripe_id,
                'payment_method_types' => ['card'],
            ]);
            // Order::
            return response()->json([
                'status' => 200,
                'message'=>'created successfully!',
                'intent'=>$intent
            ],200);
        }catch(Exception $e){
            return response()->json([
                'status' => 500,
                'message'=>$e->getMessage()
            ],500);
        }

    }

    public function confirm_payment(Request $request){
        try{
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );
            $payment = $stripe->paymentIntents->confirm(
                $request->payment_intent,
                ['payment_method' => $request->payment_method]
            );

            return response()->json([
                'status' => 200,
                'message'=>'created successfully!',
                // 'payment'=>$payment
            ],200);
        }catch(Exception $e){
            return response()->json([
                'status' => 500,
                'message'=>$e->getMessage()
            ],500);
        }

    }

    public function get_cards(){
        $cards = PaymentMethod::where('user_id',auth()->id())->get();
        if(count($cards)){
            return response()->json([
                'status' => 200,
                'message'=>'created successfully!',
                'cards'=>$cards
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message'=>'you do not have any card!'
            ],404);
        }
    }

    public function payment_testing(){
        // $appointment = Appoinment::where('id', $request->appointment_id)->first();
        $fees = $appointment->fees;
        $currency = $appointment->currency_source;
        // $app->post('/payment-sheet', function (Request $request, Response $response) {
        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        \Stripe\Stripe::setApiKey('sk_test_51LZucNElYqPVcqHjldA6F4dA3kCxEa2avnDq7Lv8EHJ0ib5kOhOqrnGiZVHKPjpuz4vDWLBvjnGQXFTV6zayiEJG003Gy0Dik3');
        // Use an existing Customer ID if this is a returning customer.
        $customer = \Stripe\Customer::create();
        $ephemeralKey = \Stripe\EphemeralKey::create(
            [
                'customer' => $customer->id,
            ],
            [
                'stripe_version' => '2022-08-01',
            ]
        );
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $fees * 100,
            'currency' => $currency,
            'customer' => $customer->id,
            'automatic_payment_methods' => [
                'enabled' => 'false',
            ],
        ]);
        if ($paymentIntent->id) {
            $appointment->payment_id = $paymentIntent->id;
            $run = $appointment->save();
        }
        Invoice::create(['appointment_id' => $appointment->id, 'doctor_id' => $appointment->doctor_id, 'patient_id' => $appointment->patient_id, 'slot_id' => $appointment->slot_id, 'charges' => $currency . '' . $fees]);
        return response()->Json([
            'status' => 200,
            'paymentIntent' => $paymentIntent->client_secret,
            'ephemeralKey' => $ephemeralKey->secret,
            'customer' => $customer->id,
            'publishableKey' => 'pk_test_51LZucNElYqPVcqHj46f6RWuqIYotcXtYbr0hXVIETaH20fXFLxuTKPQ9m4FfZhKNTklpnvuMiSivyyYOxH4EnxdG00rQgvbHqo',
            'payment_method_types' => ['card'],
        ]);
    }
}
