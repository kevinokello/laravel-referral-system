@extends('masters.master')
@section('content')
    <title>{{ $data['title'] }}</title>
    <div class="text-center" style="font-size: 20px; text-align:center;">
        <p>Hi {{ $data['name'] }}, Welcome to Referral System</p>
        <p><b>Username : </b>{{ $data['name'] }}</p>
        <p>Please <a href="{{ $data['url'] }}">Click Here</a> to verify your email</p>
        <p>Thank you.</p>
    </div>
@endsection