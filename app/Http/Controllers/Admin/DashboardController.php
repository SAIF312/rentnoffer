<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_sales=Order::sum('amount');
        $total_service_fee=Order::sum('service_fee');
        $month_ini = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
        $month_end = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
        $total_sales_last_month=Order::whereDate('Created_at','>=',$month_ini)->whereDate('Created_at','<=',$month_end)->sum('amount');
        $total_service_fee_last_month=Order::whereDate('Created_at','>=',$month_ini)->whereDate('Created_at','<=',$month_end)->sum('service_fee');
        $year_ini = date("Y-m-d",strtotime("last year January 1st"));;
        $year_end = date("Y-m-d",strtotime("last year December 31st"));
        $total_sales_last_year=Order::whereDate('Created_at','>=',$year_ini)->whereDate('Created_at','<=',$year_end)->sum('amount');
        $total_service_fee_last_year=Order::whereDate('Created_at','>=',$year_ini)->whereDate('Created_at','<=',$year_end)->sum('service_fee');
        $total_items=Product::where('type_id',1)->count();
        $total_experiences=Product::where('type_id',2)->count();
        $total_orders=Order::count();
        return view('layouts.dashboard',compact('total_sales','total_service_fee','total_sales_last_month','total_service_fee_last_month','total_sales_last_year','total_service_fee_last_year','total_items','total_experiences','total_orders'));
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
}
