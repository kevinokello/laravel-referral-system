@extends('masters.master')
@section('content')
    <main class="register-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card my-3">
                        <div class="card-header"><h4 class="card-title">Register</h4></div>
                        <div class="card-body">
                            @if(Session::has('success'))
                                <div class="text-success text-center" style="font-size: 19px;">{{ Session::get('success') }}</div>
                            @endif
                            @if(Session::has('error'))
                                <div class="text-danger text-center" style="font-size: 19px;">{{ Session::get('error') }}</div>
                            @endif
                            <form action="{{ route('user.register') }}" method="post" class="my-2">
                                @csrf
                                <div class="form-group">
                                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}">
                                    @if($errors->has('username'))
                                        <pre class="text-danger my-1">{{ $errors->first('username') }}</pre>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                                    @if($errors->has('email'))
                                        <pre class="text-danger my-1">{{ $errors->first('email') }}</pre>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="text" id="referral_code" name="referral_code" class="form-control" placeholder="Referral Code (Optional)" value="{{ old('email') }}">
                                </div>
                                <div class="form-group">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                                    @if($errors->has('password'))
                                        <pre class="text-danger my-1">{{ $errors->first('password') }}</pre>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="password" id="cnf_password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block">Register</button>
                                </div>
                            </form>
                            <div class="text-right">
                                <a href="login">Already have an account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
