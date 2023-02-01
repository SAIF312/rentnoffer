@extends('master')
@push('end-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/table/datatable/custom_dt_html5.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/table/datatable/dt-global_style.css') }}">

    <style>
        .table-responsive > .table {
            background: transparent;
        }
    </style>
@endpush
@push('end-script')
    <script src="{{ asset('assets/plugins/table/datatable/datatables.js') }}"></script>
    <!-- NOTE TO Use Copy CSV Excel PDF Print Options You Must Include These Files  -->
    <script src="{{ asset('assets/plugins/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/table/datatable/button-ext/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/table/datatable/button-ext/buttons.print.min.js') }}"></script>
    <script>
        /* Custom filtering function which will search data in column four between two values */
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var from_date = new Date($('#from_date').val());
                var to_date = new Date($('#to_date').val());

                var from =  new Date(data[4].trim().replaceAll('   ','').slice(0,10)+' '+data[4].trim().replaceAll('   ','').slice(10,18))  || new Date("2023-01-01");
                var to = new Date(data[5].trim().replaceAll('   ','').slice(0,10)+' '+data[5].trim().replaceAll('   ','').slice(10,18))  ||  new Date("{{date('Y-m-d')}}");
                if ( (from >= from_date && from <= to_date) ||
                    (to >= from_date && to <= to_date) ){
                    return true;
                }
                return false;
            }
        );

        $(document).ready(function() {
            var table = $('#orders_table').DataTable({
                "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                buttons: {
                    buttons: [{
                            extend: 'copy',
                            className: 'btn btn-sm'
                        },
                        {
                            extend: 'csv',
                            className: 'btn btn-sm'
                        },
                        {
                            extend: 'excel',
                            className: 'btn btn-sm'
                        },
                        {
                            extend: 'print',
                            className: 'btn btn-sm'
                        }
                    ]
                },
                ajax: "{{ route('orders.show_all') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'product_title',
                        name: 'product_title'
                    },
                    {
                        data: 'owner',
                        name: 'owner'
                    },
                    {
                        data: 'borrower',
                        name: 'borrower'
                    },
                    {
                        data: 'start_time',
                        name: 'start_time'
                    },
                    {
                        data: 'end_time',
                        name: 'end_time'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                    "sLengthMenu": "Results :  _MENU_",
                },
                "stripeClasses": [],
                "lengthMenu": [7, 10, 20, 50],
                "pageLength": 7
            });
            $('#from_date, #to_date').change( function() { table.draw(); } );
        });
    </script>
@endpush

@section('title')
    Orders
@stop
@section('header')
    Order Details
@stop

@section('content')

    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing">
                <div class="col pr-0">
                    <a type="button" onclick="history.back();" class="btn btn-primary mb-2 float-right">Back To List</a>
                </div>
                <div class="col-auto">
                    <a type="button" href="{{route('orders.pdf',$order->id)}}" class="btn btn-primary me-2 mb-2">Print</a>
                </div>

                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 mx-3 mt-3">
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
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 mx-3 mt-3 pr-5">
                                <table class="table w-100">
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
                        </div>
                        <div class="row mt-2">
                            <div class="col mx-3">
                                <h5 class="text-muted">Product</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 mx-3 mt-3 pr-5">
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
                                                <img src="{{env('BASE_URL').$order->product->feature_image}}" height="60" width="85"> {{$order->product->title}}
                                            </td>
                                            <td>
                                                ${{$price}}
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
                                                ${{$order->amount}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col mx-3">
                                <h5 class="text-muted">Borrower</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 mx-3 mt-3 pr-5">
                                <table class="table w-100">
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
                                                {{$order->address?$order->address->address1:($order->user->addressess?$order->user->addressess[0]->address1:'')}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col mx-3">
                                <h5 class="text-muted">Lender</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 mx-3 mt-3 pr-5">
                                <table class="table w-100">
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
                                                {{$order->product->user->addressess?$order->product->user->addressess[0]->address1:''}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-sm-12 mt-3 ml-auto" style="padding-right: 2rem!important;">
                                <table class="table w-100">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">
                                                <div class="row">
                                                    <div class="col pl-2">
                                                        <b>Subtotal</b>
                                                    </div>
                                                    <div class="col text-right">
                                                        ${{$order->amount}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col pl-2">
                                                        <b>Service fee</b>
                                                    </div>
                                                    <div class="col text-right">
                                                        ${{$order->service_fee}}
                                                    </div>
                                                </div>
                                                {{-- <div class="row">
                                                    <div class="col pl-2">
                                                        <b>Weekly Price Discount</b>
                                                    </div>
                                                    <div class="col text-right">
                                                        ${{$org_price}}
                                                    </div>
                                                </div> --}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td class="text-right">${{$order->amount + $order->service_fee}}</td>
                                        </tr>
                                        <tr>
                                            <th>Paid</th>
                                            <td class="text-right">${{$order->payment->amount}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <script>


        function change_status(id,status) {
            if(status == "In-active"){
                swal.fire({
                    title: "Are you sure to Active this Order?",
                    text: "It will be visible to users",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Activate it!",
                }).then((result) => {
                    //  console.log(isConfirm);
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: '{{ route("orders.status") }}',
                            data:{
                                id:id,
                                _token:"{{csrf_token()}}"
                            },

                            success: function(data) {
                                $('#products_table').DataTable().ajax.reload();
                                swal.fire("Success", " Order Activated successfully", "success");
                            },
                            error: function(error) {
                                Snackbar.show({
                                    text: 'Somthing Went Wrong',
                                    pos: 'top-right',
                                    actionTextColor: '#fff',
                                    backgroundColor: '#e7515a'
                                });
                            }
                        });
                    }
                });
            }else{
                swal.fire({
                    title: "Are you sure to In active this Order?",
                    text: "It will be invisible to users",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Inactivate it!",
                }).then((result) => {
                    //  console.log(isConfirm);
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: '{{ route("orders.status") }}',
                            data:{
                                id:id,
                                _token:"{{csrf_token()}}"
                            },

                            success: function(data) {
                                $('#products_table').DataTable().ajax.reload();
                                swal.fire("Success", " Order In activated successfully", "success");
                            },
                            error: function(error) {
                                Snackbar.show({
                                    text: 'Somthing Went Wrong',
                                    pos: 'top-right',
                                    actionTextColor: '#fff',
                                    backgroundColor: '#e7515a'
                                });
                            }
                        });
                    }
                });
            }

        }


    </script>
@stop
