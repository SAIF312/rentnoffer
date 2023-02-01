@extends('master')
@push('end-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/table/datatable/custom_dt_html5.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/table/datatable/dt-global_style.css') }}">
@endpush
@push('end-script')
    <script src="{{ asset('assets/plugins/table/datatable/datatables.js') }}"></script>
    <!-- NOTE TO Use Copy CSV Excel PDF Print Options You Must Include These Files  -->
    <script src="{{ asset('assets/plugins/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/table/datatable/button-ext/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/table/datatable/button-ext/buttons.print.min.js') }}"></script>
    <script>
        $('#attributes_table').DataTable({
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
            ajax: "{{ route('invoices') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'product',
                    name: 'product'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'created',
                    name: 'created'
                },
                {
                    data: 'card',
                    name: 'card'
                },
                {
                    data: 'brand',
                    name: 'brand'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'actions',
                    name: 'actions'
                }
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
    </script>
    <script>
        function view_details(id){
            $.ajax({
                type: "POST",
                url: '{{ route("invoices.detail") }}',
                data:{
                    id:id,
                    _token:"{{csrf_token()}}"
                },
                success: function(data) {
                    $('#invoice_detail_modal').modal('show');
                    $('#transection_id').text(data.payment_intent);
                    $('#amount_paid').text(parseFloat(data.amount)+ " "+data.currency.toUpperCase());
                    $('#amount').text(parseFloat(data.order.amount)+ " "+data.currency.toUpperCase());
                    $('#service_fee').text(parseFloat(data.order.service_fee)+ " "+data.currency.toUpperCase());
                    $('#card_type').text(data.payment_method.brand.toUpperCase());
                    $('#card_no').text("************"+data.payment_method.last_digit);
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
    </script>
@endpush

@section('title')
    Payments
@stop
@section('header')
    Payment List
@stop

@section('content')

    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing">
                {{-- <div class="col-12">
                    <a type="button" href="{{ route('add_attribute') }}" class="btn btn-dark float-right ms-auto mb-2">Add
                        Attribute</a>
                </div> --}}

                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">

                        <table id="attributes_table" class="table table-hover non-hover" style="width:100%">

                            <thead>

                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Product</th>
                                    <th>Amount</th>
                                    <th>Dated</th>
                                    <th>Card</th>
                                    <th>Brand</th>
                                    <th>Status</th>
                                    <th class="dt-no-sorting">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>

        </div>

    </div>


    <div id="invoice_detail_modal" class="modal animated zoomInUp custo-zoomInUp"  aria-hidden="true">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Invoice Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card component-card_1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <b>Transection Id:<b>
                                </div>
                                <div class="col" id="transection_id">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <b>Amount:<b>
                                </div>
                                <div class="col" id="amount">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <b>Service Fee:<b>
                                </div>
                                <div class="col" id="service_fee">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <b>Amount Paid:<b>
                                </div>
                                <div class="col" id="amount_paid">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <b>Card Type:<b>
                                </div>
                                <div class="col" id="card_type">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <b>Card Number:<b>
                                </div>
                                <div class="col" id="card_no">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer md-button">
                    <button class="btn btn-primary" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save</button> --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        function DisableAttribute(id) {
            swal.fire({
                title: "Are you sure to disable this Attribute?",
                text: "User will not be able to see any products under this Attribute",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, disable it!",
            }).then((result) => {
                //  console.log(isConfirm);
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: '{{ url('attribute_disable') }}/' + id,

                        success: function(data) {
                            $('#attributes_table').DataTable().ajax.reload();
                            swal.fire("Success", " Attribute disabled successfully", "success");
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

        function ActiveAttribute(id) {
            swal.fire({
                title: "Are you sure to Active this Attribute?",
                text: "It will be visible to users",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Activate it!",
            }).then((result) => {
                //  console.log(isConfirm);
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: '{{ url('attribute_active') }}/' + id,

                        success: function(data) {
                            $('#attributes_table').DataTable().ajax.reload();
                            swal.fire("Success", " Attribute Activated successfully", "success");
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

        function DeleteAttribute(id) {
            swal.fire({
                title: "Are you sure to delete this Attribute?",
                text: "All products under this Attribute will automatically delete",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                //  console.log(isConfirm);
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: '{{ url('attribute_delete') }}/' + id,

                        success: function(data) {
                            $('#attributes_table').DataTable().ajax.reload();
                            swal.fire("Success", "Attribute deleted successfully", "success");
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
    </script>
@stop
