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
        $('#products_table').DataTable({
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
            ajax: "{{ route('pages.show_all') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'slug',
                    name: 'slug'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                },
                // {
                //     data: 'description',
                //     name: 'description'
                // },
                // {
                //     data: 'rule_for_use',
                //     name: 'rule_for_use'
                // },
                // {
                //     data: 'privacy_notes',
                //     name: 'privacy_notes'
                // },
                // {
                //     data: 'minimum_rent_days',
                //     name: 'minimum_rent_days'
                // },
                // {
                //     data: 'value',
                //     name: 'value'
                // },
                // {
                //     data: 'image',
                //     name: 'image'
                // },
                // {
                //     data: 'type',
                //     name: 'type'
                // },

                // {
                //     data: 'status',
                //     name: 'status'
                // },
                // {
                //     data: 'actions',
                //     name: 'actions'
                // }
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
@endpush

@section('title')
    Pages
@stop
@section('header')
    Page List
@stop

@section('content')

    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing">
                <div class="col-12">
                    <a type="button" href="{{ route('pages.create') }}" class="btn btn-dark float-right ms-auto mb-2">Add Page</a>
                </div>

                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 mx-3 mt-3">
                                    <h3>Page List<h3>
                            </div>
                        </div>
                        <table id="products_table" class="table table-hover non-hover" style="width:100%">

                            <thead>

                                <tr>
                                    <th>#</th>
                                    <th>title</th>
                                    <th>slug</th>
                                    <th>status</th>
                                    <th class="dt-no-sorting">Action</th>
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
                    title: "Are you sure to Active this Page?",
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
                            url: '{{ route("pages.status") }}',
                            data:{
                                id:id,
                                _token:"{{csrf_token()}}"
                            },

                            success: function(data) {
                                $('#products_table').DataTable().ajax.reload();
                                swal.fire("Success", " Page Activated successfully", "success");
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
                    title: "Are you sure to In active this Page?",
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
                            url: '{{ route("pages.status") }}',
                            data:{
                                id:id,
                                _token:"{{csrf_token()}}"
                            },

                            success: function(data) {
                                $('#products_table').DataTable().ajax.reload();
                                swal.fire("Success", " Page In activated successfully", "success");
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
