@extends('general.layouts.default')

@section('content')
 
<!-- Main content -->
<div class="main-content" id="panel">
  <!-- Topnav -->
  @include('general.includes.top_nav')
  <!-- Header -->
    @include('general.includes.navigation')
  <!-- Page content -->
  <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-md-12">
            <newsletter> </newsletter>
        </div>
      </div>
      <!-- Footer -->
      @include('general.includes.footer')
  </div>
</div>

@endsection