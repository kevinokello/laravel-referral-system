@extends('masters.master')
@section('content')
<div class="wrapper d-flex align-items-stretch">
    @include('auth.layout')
    <div id="content" class="p-4 p-md-5 pt-5">
        <div class="container">
            <h4 class="mb-4" style="float: left;">Profile</h4><br>
            <hr style="border: 1px solid lightgray;">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('profile.user') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="update_username">Name</label>
                            <input type="text" name="update_username" id="update_username" class="form-control" placeholder="Username" value="{{ Auth::user()->name }}">
                            @if($errors->has('update_username'))
                                <pre class="text-danger my-1">{{ $errors->first('update_username') }}</pre>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="update_email">Email</label>
                            <input type="text" name="update_email" id="update_email" class="form-control" placeholder="Email" value="{{ Auth::user()->email }}">
                            @if($errors->has('update_email'))
                                <pre class="text-danger my-1">{{ $errors->first('update_email') }}</pre>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="submit" name="profile_btn" id="profile_btn" class="btn btn-info btn-sm" value="Update">
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    @if(session()->has('success'))
                        <div class="alert alert-success my-2">
                            <a href="" class="close" data-dismiss="alert">&times;</a>
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger my-2">
                            <a href="" class="close" data-dismiss="alert">&times;</a>
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    <form action="{{ route('change.password') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="update_password">Password</label>
                            <input type="text" name="update_password" id="update_password" class="form-control" placeholder="Password">
                            @if($errors->has('update_password'))
                                <pre class="text-danger my-1">{{ $errors->first('update_password') }}</pre>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="text" name="password" id="password" class="form-control" placeholder="New Password">
                            @if($errors->has('password'))
                                <pre class="text-danger my-1">{{ $errors->first('password') }}</pre>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="conf_password">Confirm Password</label>
                            <input type="text" name="password_confirmation" id="conf_password" class="form-control" placeholder="Conform Password">
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="hidden_password" value="{{ Auth::user()->id }}">
                            <input type="submit" name="password_btn" id="password_btn" class="btn btn-primary btn-sm" value="Change Password">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection