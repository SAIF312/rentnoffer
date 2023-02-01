<!DOCTYPE html>
<html>
    <head>
        <style>
            .top_space{
                margin-top:8px;
            }
            .row{
                width:100%;
            }
            .table{
                width:100%;
            }
            .total-table{
                width:100%;
            }
            .total-table th{
                justify-content:left;
            }
            .table thead{
                width:100%;
                background: rgba(234, 241, 255, 0.74);
            }
            .mt-2{
                margin-top:8px;
            }
            .text-muted{
                color: #888ea8 !important;
            }
            .col{
                width:50%;
            }
            table td{

            }

        </style>
    </head>
    <body>


        <div class="top_space">
            <div class="row">
                <h3>Order Details<h3>
                {{-- {{dd($order)}} --}}
                @php
                    $org_price = 0;
                    if($order->product->price7 == '' || $order->product->price7 == null){
                        $org_price = abs($order->product->price1 - $order->product->price7);
                    }
                    $price = 0;
                    $diff = 0;
                    if($order->product->type_id == 1){

                        $diff = ceil(ceil(abs(round((strtotime($order->start_time) - strtotime($order->end_time))/3600,2)))/24);
                        if($diff>30)
                        {
                            if($order->product->price30 == '' || $order->product->price30 == null){
                                $price = $order->product->price30;
                            }else{
                                $price = $order->product->price1;
                            }
                        }elseif ($diff>7) {
                            if($order->product->price7 == '' || $order->product->price7 == null){
                                $price = $order->product->price1;
                            }else{
                                $price = $order->product->price7;
                            }
                        }else{
                            $price = $order->product->price1;
                        }
                    }else{
                        $diff = ceil(abs(round((strtotime($order->start_time) - strtotime($order->end_time))/3600,2)));
                        if($diff>21)
                        {
                            if($order->product->price30 == '' || $order->product->price30 == null){
                                $price = $order->product->price30;
                            }else{
                                $price = $order->product->price1;
                            }
                        }elseif ($diff>7) {
                            if($order->product->price7 == '' || $order->product->price7 == null){
                                $price = $order->product->price1;
                            }else{
                                $price = $order->product->price7;
                            }
                        }else{
                            $price = $order->product->price1;

                        }
                    }
                @endphp
            </div>
            <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    Order Id
                                </th>
                                <th>
                                    Order Date
                                </th>
                                <th>
                                    Order Status
                                </th>
                                <th>
                                    Order Type
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    000{{$order->id}}
                                </td>
                                <td>
                                    {{date('m d, Y',strtotime($order->created_at))}}
                                    {{-- December 30, 2022 --}}
                                </td>
                                <td>
                                    new
                                </td>
                                <td>
                                    {{$order->product->type->title}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            <div class="row mt-2">
                    <h5 class="text-muted">Product</h5>
            </div>

            <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    Product
                                </th>
                                <th>
                                    Price
                                </th>
                                <th>
                                    Booked From
                                </th>
                                <th>
                                    Booked To
                                </th>
                                <th>
                                    Price * {{$order->type_id == 1 ? 'Days': 'Hours'}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <img src="{{$order->product->feature_image}}" height="60" width="85"> titleeeeee
                                </td>
                                <td>
                                    {{$price}}
                                </td>
                                <td>

                                    {{date('d-m-Y',strtotime($order->start_time))}}
                                    {{-- 01-jan-2023 --}}
                                </td>
                                <td>
                                    {{date('d-m-Y',strtotime($order->end_time))}}
                                    {{-- 04-jan-2023 --}}
                                </td>
                                <td>
                                    {{$price * $diff}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>

            <div class="row mt-2">
                    <h5 class="text-muted">Customer</h5>
            </div>

            <div class="row">
                    <table class="table">
                        <thead>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {{$order->user->username}}
                                </td>
                                <td>
                                    {{$order->user->phone}}
                                </td>
                                <td>
                                    {{$order->user->addressess[0]->address1}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>

            <div class="row mt-2">
                    <h5 class="text-muted">Owner</h5>
            </div>

            <div class="row">
                    <table class="table">
                        <thead>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {{$order->product->user->username}}
                                </td>
                                <td>
                                    {{$order->product->user->phone}}
                                </td>
                                <td>
                                    {{$order->product->user->addressess[0]->address1}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
            <div class="row mt-2">
                    <table class="total-table">
                        <tbody>
                            <tr>
                                <th>Subtotal</th>
                                <td class="text-right">${{$price * $diff}}</td>
                            </tr>
                            <tr>
                                <th>Service fee</th>
                                <td class="text-right">$0.00</td>
                            </tr>
                            <tr>
                                <th>Weekly Price Discount</th>
                                <td class="text-right">${{$org_price}}</td>
                            </tr>

                            <tr>
                                <th>Total</th>
                                <td class="text-right">${{$price * $diff}}</td>
                            </tr>
                            <tr>
                                <th>Paid</th>
                                <td class="text-right">${{$order->payment->amount/100}}</td>
                            </tr>
                        </tbody>
                    </table>
            </div>

        </div>


    </body>
</html>





















{{-- @extends('master')

@section('title')
{{-- isset($order) ? 'Update' : 'Add' }} Order
@stop
@section('header')
{{-- isset($order) ? 'Update' : 'Add' }} Order
@stop
@push('end-style')
    <link href="{{-- asset('assets/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{-- asset('assets/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css" />

@endpush
@push('end-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="{{-- asset('assets/assets/js/scrollspyNav.js') }}"></script>
    <script src="{{-- asset('assets/plugins/file-upload/file-upload-with-preview.min.js') }}"></script>
    <script>


    </script>
@endpush

@section('content')

    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">




                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">



                    <div class="widget-content widget-content-area br-6">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                    <h3>{{-- isset($order) ? 'Update' : 'Add' }} Order</h3>


                            </div>
                        </div>

                        <form action="{{-- isset($order)? route('orders.update',$order->id):route('orders.store') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Title</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter title" name="title" value="{{-- isset($order) ? $order->title : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Slug</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter slug" name="slug" value="{{-- isset($order) ? $order->slug : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Description</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter meta title" name="meta_title" value="{{-- isset($order) ? $order->meta_title : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">status</label>
                                        <select class="form-control  basic" name="status">
                                            <option value="Active" {{-- isset($order) ? ($order->status == "Active"? 'selected':'') : '' }}>Active</option>
                                            <option value="In-active" {{-- isset($order) ? ($order->status == "In-active"? 'selected':'') : 'selected' }}>In Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Raw Meta</label>
                                        <textarea type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter title" name="raw_meta">{{-- isset($order) ? $order->raw_meta : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="summernote">Content</label>
                                        <textarea class="form-control" id="summernote" name="content">{{-- isset($order) ? $order->content : '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>

@stop --}}
