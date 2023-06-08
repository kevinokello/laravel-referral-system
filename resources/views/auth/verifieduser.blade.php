@extends('masters.master')
@section('content')
    <div class="text-center" style="font-size: 20px; text-align:center;">
       <h4>{{ $message }}</h4>
       <a href="{{ $url }}">Login</a>
    </div>
@endsection