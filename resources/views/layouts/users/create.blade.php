@extends('master')

@section('title')
{{ isset($user) ? 'Update' : 'Add' }} User
@stop
@section('header')
{{ isset($user) ? 'Update' : 'Add' }} User
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
                                    <h3>{{ isset($user) ? 'Update' : 'Add' }} User</h3>

                                {{-- </div> --}}
                            </div>
                        </div>

                        <form action="{{ isset($user)? route('users.update',$user->id):route('users.store') }}" method="POST">
                            @csrf
                            @if (isset($user))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">First Name</label>
                                        @if($errors->has('first_name'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('first_name') }}</div>
                                        @endif
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter first name" name="first_name" value="{{ isset($user) ? $user->first_name : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Last Name</label>
                                        @if($errors->has('last_name'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('last_name') }}</div>
                                        @endif
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter last name" name="last_name" value="{{ isset($user) ? $user->last_name : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">User Name</label>
                                        @if($errors->has('username'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('username') }}</div>
                                        @endif
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter last name" name="username" value="{{ isset($user) ? $user->username : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        @if($errors->has('email'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('email') }}</div>
                                        @endif
                                        <input type="email" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter email" name="email" value="{{ isset($user) ? $user->email : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            Phone
                                        </label>
                                        @if($errors->has('phone'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('phone') }}</div>
                                        @endif
                                        <input type="number" class="form-control" id="exampleInputEmail1" minlength="9"
                                            aria-describedby="emailHelp" placeholder="Enter phone" name="phone" value="{{ isset($user) ? $user->phone : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">status</label>
                                        @if($errors->has('status_id'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('status_id') }}</div>
                                        @endif
                                        <select class="form-control  basic" name="status_id">
                                            <option value="1">new</option>
                                            <option value="8">Active</option>
                                            <option value="9">Disable</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">status</label>
                                        @if($errors->has('role_id'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('role_id') }}</div>
                                        @endif
                                        <select class="form-control  basic" name="role_id">
                                            <option selected disabled>-- Select Role --</option>
                                            @foreach ($roles as $role)
                                                <option value="{{$role->id}}" {{ isset($user) ? ($user->hasRole($role->id)?'selected':'') : '' }}>{{ucfirst($role->name)}}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Bio</label>
                                        @if($errors->has('bio'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('bio') }}</div>
                                        @endif
                                        <textarea class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter bio" name="bio">{{ isset($user) ? $user->bio : '' }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="password">
                                            Password
                                        </label>
                                        @if($errors->has('password'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('password') }}</div>
                                        @endif
                                        <input type="password" class="form-control" id="password"
                                            aria-describedby="emailHelp" placeholder="Enter password" name="password" value="{{ isset($user) ? $user->password : '' }}">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="password_confirmation">
                                            Confirm Password
                                        </label>

                                        @if($errors->has('password_confirmation'))
                                            <div Style="color:red; font-size:.7rem;">{{ $errors->first('password_confirmation') }}</div>
                                        @endif
                                        <input type="password" class="form-control" id="password_confirmation"
                                            aria-describedby="emailHelp" placeholder="Enter confirm password" name="password_confirmation">
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
