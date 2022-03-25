@extends('public.layouts.default')
@section('content')
    <div class="container">
        <forgot-password :user="{{ $user }}"></forgot-password>
    </div>
@endsection