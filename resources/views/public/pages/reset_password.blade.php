@extends('public.layouts.default')
@section('content')
    <div class="container">
        <login login_route="{{ route('login.submit') }}"></login>
    </div>
@endsection