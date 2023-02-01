@extends('master')
@push('end-style')
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<link href="{{asset('assets/plugins/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/assets/css/dashboard/dash_1.css')}}" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<style>
    .layout-spacing{
        height:7rem;
        margin-bottom:1rem;
    }
</style>
@endpush
@push('end-script')
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="{{asset('assets/plugins/apex/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/assets/js/dashboard/dash_1.js')}}"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
@endpush

@section('title')
    Dashboard
@stop
@section('header')
Dashboard
@stop
<style>
.widget-one {
    background:transparent!important;
}
.card-styles {
    box-shadow: rgba(50, 50, 93, 0.11) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
    background:#fff;
    border-radius: 6px;
}
.card-styles .w-content .w-value,.card-styles .w-content .w-numeric-title{
    color:#F21B2D!important;
}
.card-styles .w-icon{
    color:#fff!important;
    background:#064490!important;
}
.card-styles .w-icon i{
    color:#fff!important;
}
</style>


@section('content')

    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing">
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget-one widget">
                        <div class="widget-content">
                            <div class="w-numeric-value card-styles">
                                <div class="w-icon">
                                    {{-- <i class="fa-solid fa-truck-fast custom-icons" aria-hidden="true"></i> --}}
                                    <i class="fa-solid fa-dollar-sign custom-icons mx-auto" aria-hidden="true"></i>
                                </div>
                                <div class="w-content">
                                    <span class="w-value">${{$total_sales}}</span>
                                    <span class="w-numeric-title">Total Sales</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget-one widget">
                        <div class="widget-content">
                            <div class="w-numeric-value card-styles">
                                <div class="w-icon">
                                    <i class="fa-solid fa-dollar-sign custom-icons mx-auto" aria-hidden="true"></i>
                                </div>
                                <div class="w-content">
                                    <span class="w-value">${{$total_service_fee}}</span>
                                    <span class="w-numeric-title">Total Service Fee</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget-one widget">
                        <div class="widget-content">
                            <div class="w-numeric-value card-styles">
                                <div class="w-icon">
                                    {{-- <i class="fa-solid fa-truck-fast custom-icons" aria-hidden="true"></i> --}}
                                    <i class="fa-solid fa-money-bill-trend-up custom-icons" aria-hidden="true"></i>
                                </div>
                                <div class="w-content">
                                    <span class="w-value">${{$total_sales_last_month}}</span>
                                    <span class="w-numeric-title">Total Sales of Last Month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget-one widget">
                        <div class="widget-content">
                            <div class="w-numeric-value card-styles">
                                <div class="w-icon">
                                    {{-- <i class="fa-solid fa-truck-fast custom-icons" aria-hidden="true"></i> --}}
                                    <i class="fa-solid fa-money-bill-trend-up custom-icons" aria-hidden="true"></i>
                                </div>
                                <div class="w-content">
                                    <span class="w-value">${{$total_service_fee_last_month}}</span>
                                    <span class="w-numeric-title">Total Service Fee of Last Month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget-one widget">
                        <div class="widget-content">
                            <div class="w-numeric-value card-styles">
                                <div class="w-icon">
                                    <i class="fa-solid fa-sack-dollar custom-icons mx-auto" aria-hidden="true"></i>
                                </div>
                                <div class="w-content">
                                    <span class="w-value">${{$total_sales_last_year}}</span>
                                    <span class="w-numeric-title">Total Sales of Last Year</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget-one widget">
                        <div class="widget-content">
                            <div class="w-numeric-value card-styles">
                                <div class="w-icon">
                                    <i class="fa-solid fa-sack-dollar custom-icons mx-auto" aria-hidden="true"></i>
                                </div>
                                <div class="w-content">
                                    <span class="w-value">${{$total_service_fee_last_year}}</span>
                                    <span class="w-numeric-title">Total Service Fee of Last Year</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget-one widget">
                        <div class="widget-content">
                            <div class="w-numeric-value card-styles">
                                <div class="w-icon">
                                    {{-- <i class="fa-solid fa-truck-fast custom-icons" aria-hidden="true"></i> --}}
                                    <i class="fa-brands fa-product-hunt custom-icons m-auto" aria-hidden="true"></i>
                                </div>
                                <div class="w-content">
                                    <span class="w-value">{{$total_items}}</span>
                                    <span class="w-numeric-title">Total No of Items</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget-one widget">
                        <div class="widget-content">
                            <div class="w-numeric-value card-styles">
                                <div class="w-icon">
                                    {{-- <i class="fa-solid fa-truck-fast custom-icons" aria-hidden="true"></i> --}}
                                    <i class="fa-brands fa-product-hunt custom-icons m-auto" aria-hidden="true"></i>
                                </div>
                                <div class="w-content">
                                    <span class="w-value">{{$total_experiences}}</span>
                                    <span class="w-numeric-title">Total No of Experience</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget-one widget">
                        <div class="widget-content">
                            <div class="w-numeric-value card-styles">
                                <div class="w-icon">
                                    <i class="fa-solid fa-truck-fast custom-icons" aria-hidden="true"></i>
                                </div>
                                <div class="w-content">
                                    <span class="w-value">{{$total_orders}}</span>
                                    <span class="w-numeric-title">Total No of Orders</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>


    </div>

@stop
