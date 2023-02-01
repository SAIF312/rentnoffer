<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function index()
    {
        return view('layouts.payments.index');
    }
    public function invoices()
    {

        $payments = Payment::with('user', 'order', 'payment_method')->get();

        if (request()->ajax()) {

            return DataTables::of($payments)
                ->addIndexColumn()
                ->editColumn('name', function ($payment) {
                    return $payment->user->username;
                })
                ->editColumn('status', function ($payment) {
                    return "<span class='badge badge-success'>".ucfirst($payment->status)."</span>";
                })
                ->editColumn('product', function ($payment) {
                    return "<img src='".env('BASE_URL').$payment->order->product->feature_image."' height='75' width='75'>";
                })
                ->editColumn('amount', function ($payment) {
                    return $payment->amount .' '.strtoUpper($payment->currency);
                })
                ->editColumn('created', function ($payment) {
                    return $payment->created;
                })
                ->editColumn('card', function ($payment) {
                    return "************".$payment->payment_method->last_digit;
                })
                ->editColumn('brand', function ($payment) {
                    return strtoUpper($payment->payment_method->brand);
                })
                ->editColumn('actions', function ($payment) {
                    return view('Layouts.payments.actions', compact('payment'));
                })
                ->rawColumns(['actions', 'status', 'product'])
                ->toJson();
        }
        return view('Layouts.payments.index');
    }

    public function detail(Request $request){
        $payment = Payment::where('id',$request->id)->with('user', 'order', 'payment_method')->first();
        return $payment;
    }
}
