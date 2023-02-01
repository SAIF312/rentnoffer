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
    Order List
@stop

@section('content')

    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing">


                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 mx-3 mt-3">
                                    <h3>Order List<h3>
                            </div>
                        </div>
                        <div class="table-form">
                            <div class="form-group row mr-3">
                                <label for="from_date" class="col-sm-5 col-form-label col-form-label-sm">From Date:</label>
                                <div class="col-sm-7">
                                    <input type="date" class="form-control form-control-sm" name="from_date" id="from_date" value="2023-01-01" min="2023-01-01" max="{{date('Y-m-d')}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="to_date" class="col-sm-5 col-form-label col-form-label-sm">To Date:</label>
                                <div class="col-sm-7">
                                    <input type="date" class="form-control form-control-sm" name="to_date" id="to_date" value="{{date('Y-m-d')}}" min="2023-01-01" max="{{date('Y-m-d')}}">
                                </div>
                            </div>
                        </div>
                        <table id="orders_table" class="display table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Owner</th>
                                    <th>Borrower</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Created At</th>
                                    <th class="text-center dt-no-sorting">Action</th>
                                </tr>
                            </thead>
                        </table>
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
