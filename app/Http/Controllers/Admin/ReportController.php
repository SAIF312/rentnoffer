<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts.reports.index');
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
        //
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

    public function top_sales_product(){
        $products = Product::with('type', 'status', 'user', 'category', 'address')->orderBy('sales','DESC')->limit(10)->get();
        if (request()->ajax()) {
            return DataTables::of($products)
                ->addIndexColumn()
                ->editColumn('name', function ($products) {
                    return ucwords($products->name);
                })
                ->editColumn('status', function ($products) {
                    return "<span class='badge badge-success'>" . ucfirst($products->status->title) . "</span>";
                })
                ->editColumn('type', function ($products) {
                    return ($products->type->title == 'Item')? "<span class='badge badge-primary'>" . ucfirst($products->type->title) . "</span>": "<span class='badge badge-success'>" . ucfirst($products->type->title) . "</span>";
                })
                ->editColumn('image', function ($products) {
                    return view('Layouts.products.image', compact('products'));
                })
                ->editColumn('description', function ($products) {
                    return "<div title='$products->description'>".Str::limit($products->description, 30) ."...</div>";
                })
                ->editColumn('category', function ($products) {
                    return isset($products->category) ? ucwords($products->category->title) : "N/A";
                })
                ->editColumn('user', function ($products) {
                    return isset($products->user) ? ucwords($products->user->username) : "N/A";
                })
                ->rawColumns(['description', 'status', 'image', 'type'])
                ->toJson();
        }
        return view('layouts.products.index');
    }

    public function top_viewed_product(){
        $products = Product::with('type', 'status', 'user', 'category', 'address')->orderBy('views','DESC')->limit(10)->get();
        if (request()->ajax()) {
            return DataTables::of($products)
                ->addIndexColumn()
                ->editColumn('name', function ($products) {
                    return ucwords($products->name);
                })
                ->editColumn('status', function ($products) {
                    return "<span class='badge badge-success'>" . ucfirst($products->status->title) . "</span>";
                })
                ->editColumn('type', function ($products) {
                    return ($products->type->title == 'Item')? "<span class='badge badge-primary'>" . ucfirst($products->type->title) . "</span>": "<span class='badge badge-success'>" . ucfirst($products->type->title) . "</span>";
                })
                ->editColumn('image', function ($products) {
                    return view('Layouts.products.image', compact('products'));
                })
                ->editColumn('description', function ($products) {
                    return "<div title='$products->description'>".Str::limit($products->description, 30) ."...</div>";
                })
                ->editColumn('category', function ($products) {
                    return isset($products->category) ? ucwords($products->category->title) : "N/A";
                })
                ->editColumn('user', function ($products) {
                    return isset($products->user) ? ucwords($products->user->username) : "N/A";
                })
                ->rawColumns(['description','status', 'image', 'type'])
                ->toJson();
        }
        return view('layouts.products.index');
    }

    public function top_orders(){
        $orders = Order::with('product','payment')->orderBy('created_at','DESC')->limit(10)->get();
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
                ->rawColumns(['status','start_time','end_time'])
                ->toJson();
        }
        return view('layouts.orders.index');
    }

    public function top_borrowers(){
        $users = User::whereHas('roles',function($q){
            $q->where('name', '!=','admin');
        })->where('phone_verification',1)->with('status', 'addressess', 'orders', 'products')->orderBy('borrower_revenue','DESC')->limit(10)->get();
        if (request()->ajax()) {

            return DataTables::of($users)
                ->addIndexColumn()
                ->editColumn('status', function ($users) {
                    if ($users->status->title == 'new' || $users->status->title == 'disable' || $users->status->title == 'blocked' || $users->status->title == 'pending'){
                        return "<span class='badge badge-warning'>" . ucfirst($users->status->title) . "</span>";
                    }else if ($users->status->title == 'deactivated'){
                        return "<span class='badge badge-danger'>" . ucfirst($users->status->title) . "</span>";
                    }else if ($users->status->title == 'activated'){
                        return "<span class='badge badge-success'>" . ucfirst($users->status->title) . "</span>";
                    }
                })
                ->editColumn('revenue', function ($users) {
                    return '$'.$users->borrower_revenue;
                })
                ->editColumn('state', function ($users) {
                    return $users->primary_address? $users->primary_address->state->title:'N/A';
                })
                ->editColumn('products', function ($users) {
                    return count($users->products);
                })
                ->editColumn('orders', function ($users) {
                    return count($users->orders);
                })
                ->rawColumns([ 'status'])
                ->toJson();
        }
        return view('Layouts.users.index');
    }

    public function top_lenders(){
        $users = User::whereHas('roles',function($q){
            $q->where('name', '!=','admin');
        })->where('phone_verification',1)->with('status', 'addressess', 'orders', 'products')->orderBy('lender_revenue','DESC')->limit(10)->get();
        if (request()->ajax()) {

            return DataTables::of($users)
                ->addIndexColumn()
                ->editColumn('status', function ($users) {
                    if ($users->status->title == 'new' || $users->status->title == 'disable' || $users->status->title == 'blocked' || $users->status->title == 'pending'){
                        return "<span class='badge badge-warning'>" . ucfirst($users->status->title) . "</span>";
                    }else if ($users->status->title == 'deactivated'){
                        return "<span class='badge badge-danger'>" . ucfirst($users->status->title) . "</span>";
                    }else if ($users->status->title == 'activated'){
                        return "<span class='badge badge-success'>" . ucfirst($users->status->title) . "</span>";
                    }
                })
                ->editColumn('revenue', function ($users) {
                    return '$'.$users->lender_revenue;
                })
                ->editColumn('state', function ($users) {
                    return $users->primary_address? $users->primary_address->state->title:'N/A';
                })
                ->editColumn('products', function ($users) {
                    return count($users->products);
                })
                ->editColumn('orders', function ($users) {
                    return count($users->orders);
                })
                ->rawColumns(['status'])
                ->toJson();
        }
        return view('Layouts.users.index');
    }
}
