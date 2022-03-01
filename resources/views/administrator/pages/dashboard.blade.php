@extends('administrator.layouts.default')

@section('content')

<!-- Main content -->
<div class="main-content" id="panel">
    <!-- Topnav -->
    @include('administrator.includes.top_nav')
    <!-- Header -->
    @include('administrator.includes.navigation')
    <!-- Page content -->
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-6">
                <general-bulletin-card> </general-bulletin-card>
            </div>
            <div class="col-xl-6">
                <bulletin-form></bulletin-form>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <leave-application> </leave-application>
            </div>
            <div class="col-xl-4">
                <employee-widget> </employee-widget>
        
            </div>
            <div class="col-xl-4">
                <general-client-card></general-client-card>
            </div>

            <div class="col-xl-4">
                <document-expiration-widget></document-expiration-widget>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <linked-in> </linked-in>
            </div>
        </div>

        <!-- Footer -->
        @include('administrator.includes.footer')

     
    </div>
</div>

@endsection
