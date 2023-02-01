@extends('master')

@section('title')
{{ isset($page) ? 'Update' : 'Add' }} Page
@stop
@section('header')
{{ isset($page) ? 'Update' : 'Add' }} Page
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
                                    <h3>{{ isset($page) ? 'Update' : 'Add' }} Page</h3>

                                {{-- </div> --}}
                            </div>
                        </div>

                        <form action="{{ isset($page)? route('pages.update',$page->id):route('pages.store') }}" method="POST">
                            @csrf
                            @if(isset($page))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Title<span Style="color:red; font-size:.7rem;">*</span></label>
                                        @if($errors->has('title'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('title') }}</div>
                                        @endif
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter title" name="title" value="{{ isset($page) ? $page->title : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Slug<span Style="color:red; font-size:.7rem;">*</span></label>
                                        @if($errors->has('slug'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('slug') }}</div>
                                        @endif
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter slug" name="slug" value="{{ isset($page) ? $page->slug : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Description</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter meta title" name="meta_title" value="{{ isset($page) ? $page->meta_title : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">status</label>
                                        <select class="form-control  basic" name="status">
                                            <option value="Active" {{ isset($page) ? ($page->status == "Active"? 'selected':'') : '' }}>Active</option>
                                            <option value="In-active" {{ isset($page) ? ($page->status == "In-active"? 'selected':'') : 'selected' }}>In Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Raw Meta</label>
                                        <textarea type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter title" name="raw_meta">{{ isset($page) ? $page->raw_meta : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="summernote">Content<span Style="color:red; font-size:.7rem;">*</span></label>
                                        @if($errors->has('content'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('content') }}</div>
                                        @endif
                                        <textarea class="form-control" id="summernote" name="content">{{ isset($page) ? $page->content : '' }}</textarea>
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
