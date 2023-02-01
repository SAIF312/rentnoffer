<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use PDF;
use Yajra\DataTables\Facades\DataTables;



class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Layouts.orders.index');
    }

    public function show_all(){
        $orders = Order::with('product','payment')->get();
        if (request()->ajax()) {
            return DataTables::of($orders)
                ->addIndexColumn()
                ->editColumn('borrower', function ($order) {
                    return $order->payment->user->username;
                })
                ->editColumn('owner', function ($order) {
                    return $order->product->user->username;
                })
                ->editColumn('product_title', function ($order) {
                    return $order->product->name;
                })
                ->editColumn('created_at', function ($order) {
                    return date('Y-m-d',strtotime($order->created_at));
                })
                ->editColumn('start_time', function ($order) {
                    return "<div class='row'>
                                <div class='col-12'>".
                                    date('Y-m-d',strtotime($order->start_time))
                                ."</div>
                                <div class='col-12'>".
                                    date('H:i:s',strtotime($order->start_time))
                                ."</div>
                            </div>";
                })
                ->editColumn('end_time', function ($order) {
                    return "<div class='row'>
                                <div class='col-12'>".
                                    date('Y-m-d',strtotime($order->end_time))
                                ."</div>
                                <div class='col-12'>".
                                    date('H:i:s',strtotime($order->end_time))
                                ."</div>
                            </div>";
                })
                ->editColumn('action', function ($order) {
                    return view('Layouts.orders.actions', compact('order'));
                })
                ->rawColumns(['action', 'status','start_time','end_time'])
                ->toJson();
        }
        return view('layouts.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::where('id',$id)->with('product','payment')->first();
        // dd($order);
        return view('Layouts.orders.show',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function create_pdf($id)
    {
        set_time_limit(300);
        $order = Order::where('id',$id)->with('product','payment')->first();
        $org_price = 0;
        // if($order->product->price7 == '' || $order->product->price7 == null){
        //     $org_price = abs($order->product->price1 - $order->product->price7);
        // }
        // $price = 0;
        // $diff = 0;
        // if($order->product->type_id == 1){

        //     $diff = ceil(ceil(abs(round((strtotime($order->start_time) - strtotime($order->end_time))/3600,2)))/24);
        //     if($diff>30)
        //     {
        //         if($order->product->price30 == '' || $order->product->price30 == null){
        //             $price = $order->product->price30;
        //         }else{
        //             $price = $order->product->price1;
        //         }
        //     }elseif ($diff>7) {
        //         if($order->product->price7 == '' || $order->product->price7 == null){
        //             $price = $order->product->price1;
        //         }else{
        //             $price = $order->product->price7;
        //         }
        //     }else{
        //         $price = $order->product->price1;
        //     }
        // }else{
        //     $diff = ceil(abs(round((strtotime($order->start_time) - strtotime($order->end_time))/3600,2)));
        //     if($diff>21)
        //     {
        //         if($order->product->price30 == '' || $order->product->price30 == null){
        //             $price = $diff * $order->product->price30;
        //         }else{
        //             $price = $diff * $order->product->price1;
        //         }
        //     }elseif ($diff>7) {
        //         if($order->product->price7 == '' || $order->product->price7 == null){
        //             $price = $diff * $order->product->price1;
        //         }else{
        //             $price = $diff * $order->product->price7;
        //         }
        //     }else{
        //         $price = $diff * $order->product->price1;

        //     }
        // }
        // $data['id'] = $order->id;
        // $data['order_date'] = date('m d, Y',strtotime($order->created_at));
        // $data['type'] = $order->product->type->title;
        // $data['type_id'] = $order->product->type_id;
        // $data['feature_image'] = $order->product->feature_image;
        // $data['start_time'] = date('d-m-Y',strtotime($order->start_time));
        // $data['end_time'] = date('d-m-Y',strtotime($order->end_time));
        // $data['total'] = $price * $diff;

        // $data['cust_name'] = $order->user->username;
        // $data['cust_phone'] = $order->user->phone;
        // $data['cust_address'] = $order->user->addressess[0]->address1;

        // $data['own_name'] = $order->product->user->username;
        // $data['own_phone'] = $order->product->user->phone;
        // $data['own_address'] = $order->product->user->addressess[0]->address1;

        // $data['weekly_discount'] = $org_price;
        // $data['paid'] = $order->payment->amount/100;

        // return view('Layouts.orders.pdf_view', compact('order'));


        $pdf = PDF::loadView('Layouts.orders.pdf_view', compact('order'));
        // download PDF file with download method
        return $pdf->download('Layouts.orders.pdf_file.pdf');
    }

}
