@extends('administrator.layouts.default')

@section('content')

<!-- Main content -->
<div class="main-content" id="panel">
    <!-- Topnav -->
    @include('administrator.includes.top_nav')
    <!-- Header -->
    @include('administrator.includes.navigation')
    <!-- Page content -->
 <!-- Page content -->
 <div class="container-fluid mt--6">

  <div class="col-md-12">
        <client-detail :user="{{ $user }}"></client-detail>
  </div>

  <div class="col-lx-12">
      <linked-in></linked-in>
  </div>    

  <!-- Footer -->
  @include('staff.includes.footer')
</div>
</div>

@endsection