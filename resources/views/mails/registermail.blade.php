@extends('masters.master')
@section('content')
    <title>{{ $data['title'] }}</title>
    <div class="text-center" style="font-size: 20px; text-align:center;">
        <p>Hi {{ $data['name'] }}, Welcome to Referral System</p>
        <p><b>Username : </b>{{ $data['name'] }}</p>
        <p><b>Email :</b> {{ $data['email'] }}</p>
        <p><b>Password : </b>{{ $data['password'] }}</p>
        <p>You can add users to your network by share your <a href="{{ $data['url'] }}">Referal Link</a></p>
        <p>Thank you.</p>
    </div>
@endsection