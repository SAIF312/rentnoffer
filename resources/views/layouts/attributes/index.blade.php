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
            ajax: "{{ route('attributes.datatable') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'value',
                    name: 'value'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'mandatory',
                    name: 'mandatory'
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
        function change_status(id,status) {
            if(status == 9){
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
                            type: "POST",
                            url: "{{ route('attributes.status') }}",
                            data:{
                                _token:"{{csrf_token()}}",
                                id:id
                            },

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
            }else{
                swal.fire({
                    title: "Are you sure to deactivate this Attribute?",
                    text: "User will not be able to see any products under this Attribute",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, disable it!",
                }).then((result) => {
                    //  console.log(isConfirm);
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('attributes.status') }}",
                            data:{
                                _token:"{{csrf_token()}}",
                                id:id
                            },

                            success: function(data) {
                                $('#attributes_table').DataTable().ajax.reload();
                                swal.fire("Success", " Attribute deactivate successfully", "success");
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

        function delete_attribute(id) {
            swal.fire({
                title: "Are you sure to delete this Attribute?",
                text: "It may cause deletion of products if this attribute assign to some catrgory",
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
@endpush

@section('title')
    Attributes
@stop
@section('header')
    Attribute List
@stop

@section('content')

    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing">
                <div class="col-12">
                    <a type="button" href="{{ route('add_attribute') }}" class="btn btn-dark float-right ms-auto mb-2">Add
                        Attribute</a>
                </div>

                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">

                        <table id="attributes_table" class="table table-hover non-hover" style="width:100%">

                            <thead>

                                <tr>
                                    <th>#</th>
                                    <th>Question</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Answers</th>
                                    <th>Status</th>
                                    <th>Mandatory</th>
                                    <th class="dt-no-sorting">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>

        </div>

    </div>


@stop
