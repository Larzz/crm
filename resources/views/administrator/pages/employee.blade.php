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

  <div class="row">

    <div class="col-xl-4">
      <staff-profile :employee="{{ $user }}"></staff-profile>
    </div>

    <div class="col-xl-4">
      <staff-document></staff-document>
    </div>

    <div class="col-xl-4">
      <general-employee-notes :user="{{ $user }}"></general-employee-notes>
    </div>

  </div>

  <div class="col-lx-12">
      <linked-in></linked-in>
  </div>    

  <!-- Footer -->
  @include('staff.includes.footer')
</div>
</div>

@endsection
