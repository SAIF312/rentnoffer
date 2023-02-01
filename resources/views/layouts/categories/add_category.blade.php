@extends('master')

@section('title')
    {{isset($category)?'Update ':'Add ' }}Category
@stop
@section('header')
    {{isset($category)?'Update':'Add' }} Category
@stop
@push('end-style')
    <link href="{{ asset('assets/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('end-script')
    <script src="{{ asset('assets/assets/js/scrollspyNav.js') }}"></script>
    <script src="{{ asset('assets/plugins/file-upload/file-upload-with-preview.min.js') }}"></script>

    <script>
        //First upload
        var firstUpload = new FileUploadWithPreview('myFirstImage')
        //Second upload
        var secondUpload = new FileUploadWithPreview('mySecondImage')
    </script>
    <script>
        $(document).ready(function() {
            //set initial state.
            $('#is_popular').prop('checked', false);
            $('#is_parent').prop('checked', false);
        });
    </script>
@endpush

@section('content')

    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing">

                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">

                        <form action="{{ route('add_categories') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Title</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Enter title" name="title" value="{{isset($category)?$category->title:'' }}" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Parent Category</label>
                                <select class="form-control  basic" name="parent_id">
                                    <option disabled selected value> -- Select Parent if any -- </option>
                                    @foreach ($categories as $option)
                                        <option value="{{ $option->id }}" {{isset($category)?($category->parent_id == $option->id?'selected':''):''}}>{{ $option->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Select Type</label>
                                <select class="form-control  basic" name="type_id">
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}" {{isset($category)?($category->type_id == $type->id?'selected':''):''}}>{{ $type->title }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="custom-file-container" data-upload-id="myFirstImage">
                                <label>Upload (Single File) <a href="javascript:void(0)"
                                        class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                <label class="custom-file-container__custom-file">
                                    <input name="image" type="file"
                                        class="custom-file-container__custom-file__custom-file-input" accept="image/*" required>
                                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                    <span class="custom-file-container__custom-file__custom-file-control"></span>
                                </label>
                                <div class="custom-file-container__image-preview"></div>
                            </div>
                            <div class="n-chk">
                                <label class="new-control new-checkbox checkbox-primary">
                                    <input type="checkbox" class="new-control-input" id="is_popular" value="{{isset($category)?$category->is_popular:'1' }}"
                                        name="is_popular">
                                    <span class="new-control-indicator"></span>is Popular?
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>

@stop
