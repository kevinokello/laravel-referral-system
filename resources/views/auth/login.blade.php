@extends('masters.master')
@section('content')
    <main class="login-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card my-3">
                        <div class="card-header"><h4>Login</h4></div>
                        <div class="card-body">
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
                            <form action="{{ route('user.login') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                                    @if($errors->has('email'))
                                        <pre class="text-danger my-1">{{ $errors->first('email') }}</pre>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                                    @if($errors->has('password'))
                                        <pre class="text-danger my-1">{{ $errors->first('password') }}</pre>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block">Login</button>
                                </div>
                            </form>
                            <div class="text-right">
                                <a href="register">Create an account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection