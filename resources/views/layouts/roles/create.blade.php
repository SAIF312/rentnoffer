@extends('master')

@section('title')
{{ isset($role) ? 'Update' : 'Add' }} Role
@stop
@section('header')
{{ isset($role) ? 'Update' : 'Add' }} Role
@stop
@push('end-style')
    <link href="{{ asset('assets/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css" />

@endpush
@push('end-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="{{ asset('assets/assets/js/scrollspyNav.js') }}"></script>
    <script src="{{ asset('assets/plugins/file-upload/file-upload-with-preview.min.js') }}"></script>
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
                                {{-- <div class="widget-content widget-content-area br-6"> --}}
                                    <h3>{{ isset($role) ? 'Update' : 'Add' }} Role</h3>

                                {{-- </div> --}}
                            </div>
                        </div>

                        <form action="{{ isset($role)? route('roles.update',$role->id):route('roles.store') }}" method="POST">
                            @csrf
                            @if (isset($role))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        @if($errors->has('name'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('name') }}</div>
                                        @endif
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter name" name="name" value="{{ isset($role) ? $role->name : '' }}" required>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Description</label>
                                        @if($errors->has('description'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('description') }}</div>
                                        @endif
                                        <textarea class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter description" name="description"  required>{{ isset($role) ? $role->description : '' }}</textarea>
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
@stop
