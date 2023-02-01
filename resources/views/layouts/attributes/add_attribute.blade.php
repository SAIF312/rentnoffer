@extends('master')

@section('title')
    {{isset($attribute)?'Update ':'Add ' }}Attribute
@stop
@section('header')
    {{isset($attribute)?'Update':'Add' }} Attribute
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

            $('#is_mandatory').prop('checked', "{{isset($attribute)?(($attribute->is_mandatory)?true:false):false}}");
        });
    </script>
@endpush

@section('content')

    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing">

                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">

                        <form action="{{isset($attribute)?route('attributes.update',$attribute->id):route('add_attributess') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">Question</label>
                                <input type="text" class="form-control" id="title" aria-describedby="emailHelp" placeholder="Enter Question" name="title" value="{{isset($attribute)?$attribute->title:'' }}" required>
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control  basic" name="category_id" id="category" required>
                                    <option disabled {{isset($attribute)?'':'selected' }} value> -- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{isset($attribute)?(($attribute->category_id == $category->id)?'selected':''):'' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="type">Select Type</label>
                                <select class="form-control  basic" name="attribute_type_id" id="type" required>
                                    <option disabled {{isset($attribute)?'':'selected' }} value> -- Select Type --</option>
                                    @foreach ($attribute_types as $attribute_type)
                                        <option value="{{ $attribute_type->id }}" {{isset($attribute)?(($attribute->attribute_type_id == $attribute_type->id)?'selected':''):'' }}>{{ $attribute_type->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Answers">Answers</label>
                                <input type="text" class="form-control" id="Answers"
                                    aria-describedby="emailHelp" placeholder="Enter attribute values"
                                    name="value" value="{{isset($attribute)?$attribute->value:'' }}" required>
                                {{-- Type and press enter (Each value must not be greater than 10 characters) --}}
                            </div>
                            <div class="n-chk">
                                <label class="new-control new-checkbox checkbox-primary">
                                    <input type="checkbox" class="new-control-input" id="is_popular" value="1"
                                        name="is_mandatory" {{isset($attribute)?(($attribute->is_mandatory)?'Checked':''):'' }}>
                                    <span class="new-control-indicator"></span>is Mandatory?
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary">{{isset($attribute)?'Update':'Submit' }}</button>
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>

@stop
