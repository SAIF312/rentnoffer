@extends('master')

@section('title')
{{ isset($setting) ? 'Update' : 'Add' }} Setting
@stop
@section('header')
{{ isset($setting) ? 'Update' : 'Add' }} Setting
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
                                    <h3>{{ isset($setting) ? 'Update' : 'Add' }} Setting</h3>

                                {{-- </div> --}}
                            </div>
                        </div>

                        <form action="{{ isset($setting)? route('settings.update',$setting->id):route('settings.store') }}" method="POST">
                            @csrf
                            @if (isset($setting))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Site Title</label>
                                        @if($errors->has('site_title'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('site_title') }}</div>
                                        @endif
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter Site Title" name="site_title" value="{{ isset($setting) ? $setting->site_title : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Site Logo Large</label>
                                        @if($errors->has('site_logo_large'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('site_logo_large') }}</div>
                                        @endif
                                        <input type="file" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter last name" name="site_logo_large" value="{{ isset($setting) ? $setting->site_logo_large : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Site Logo Small</label>
                                        @if($errors->has('site_logo_small'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('site_logo_small') }}</div>
                                        @endif
                                        <input type="file" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter last name" name="site_logo_small" value="{{ isset($setting) ? $setting->site_logo_small : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Copy Right Text</label>
                                        @if($errors->has('copy_right_text'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('copy_right_text') }}</div>
                                        @endif
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter copy_right_text" name="copy_right_text" value="{{ isset($setting) ? $setting->copy_right_text : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            Site Email
                                        </label>
                                        @if($errors->has('site_email'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('site_email') }}</div>
                                        @endif
                                        <input type="email" class="form-control" id="exampleInputEmail1" minlength="9"
                                            aria-describedby="emailHelp" placeholder="Enter site email" name="site_email" value="{{ isset($setting) ? $setting->site_email : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            Address
                                        </label>
                                        @if($errors->has('address'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('address') }}</div>
                                        @endif
                                        <input type="text" class="form-control" id="exampleInputEmail1" minlength="9"
                                            aria-describedby="emailHelp" placeholder="Enter address" name="address" value="{{ isset($setting) ? $setting->address : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            Facebook Link
                                        </label>
                                        @if($errors->has('facebook_url'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('facebook_url') }}</div>
                                        @endif
                                        <input type="text" class="form-control" id="exampleInputEmail1" minlength="9"
                                            aria-describedby="emailHelp" placeholder="Enter facebook link" name="facebook_url" value="{{ isset($setting) ? $setting->facebook_url : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            twitter Link
                                        </label>
                                        @if($errors->has('twitter_url'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('twitter_url') }}</div>
                                        @endif
                                        <input type="text" class="form-control" id="exampleInputEmail1" minlength="9"
                                            aria-describedby="emailHelp" placeholder="Enter twitter link" name="twitter_url" value="{{ isset($setting) ? $setting->twitter_url : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            Linkedin Link
                                        </label>
                                        @if($errors->has('linkedin_url'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('linkedin_url') }}</div>
                                        @endif
                                        <input type="text" class="form-control" id="exampleInputEmail1" minlength="9"
                                            aria-describedby="emailHelp" placeholder="Enter linkedin link" name="linkedin_url" value="{{ isset($setting) ? $setting->linkedin_url : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            Instagram Link
                                        </label>
                                        @if($errors->has('instagram_url'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('instagram_url') }}</div>
                                        @endif
                                        <input type="text" class="form-control" id="exampleInputEmail1" minlength="9"
                                            aria-describedby="emailHelp" placeholder="Enter instagram link" name="instagram_url" value="{{ isset($setting) ? $setting->instagram_url : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Timezone</label>
                                        @if($errors->has('timezone_id'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('timezone_id') }}</div>
                                        @endif
                                        <select class="form-control  basic" name="timezone_id">
                                            <option selected disabled>-- Select Timezone --</option>
                                            @foreach ($timezones as $timezone)
                                                <option value="{{$timezone->id}}" {{($timezone->id == $setting->timezone_id) ? 'selected':''}}>{{$timezone->title}}({{$timezone->description}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            Contect Us Email
                                        </label>
                                        @if($errors->has('contact_us_email'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('contact_us_email') }}</div>
                                        @endif
                                        <input type="email" class="form-control" id="exampleInputEmail1" minlength="9"
                                            aria-describedby="emailHelp" placeholder="Enter contect us email" name="contact_us_email" value="{{ isset($setting) ? $setting->contact_us_email : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            Order Service fee percentage
                                        </label>
                                        @if($errors->has('s_fee'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('s_fee') }}</div>
                                        @endif
                                        <input type="number" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter contect us email" name="s_fee" value="{{ isset($service_fee) ? $service_fee->s_fee : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            Order Payment Processing Time(In Days)
                                        </label>
                                        @if($errors->has('order_payment_process_days'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('order_payment_process_days') }}</div>
                                        @endif
                                        <input type="number" class="form-control" id="exampleInputEmail1" minlength="9"
                                            aria-describedby="emailHelp" placeholder="Enter contect us email" name="order_payment_process_days" value="{{ isset($setting) ? $setting->order_payment_process_days : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            Distance(Miles)
                                        </label>
                                        @if($errors->has('distance'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('distance') }}</div>
                                        @endif
                                        <input type="number" class="form-control" id="exampleInputEmail1" minlength="9"
                                            aria-describedby="emailHelp" placeholder="Enter contect us email" name="distance" value="{{ isset($setting) ? $setting->distance : '' }}">
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
