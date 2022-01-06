@extends('staff.layouts.default')

@section('content')
 
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    @include('staff.includes.top_nav')
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
          <div class="header-body">
              <div class="row align-items-center py-4">
                  <div class="col-lg-12 col-7">
                      <ul class="nav-sub-sx">
                          <li> <a href="">Blog</a> </li>
                          <li> <a href="">Presentations</a> </li>
                          <li> <a href="">Client Backend</a> </li>
                          <li> <a href="">Website</a> </li>
                          <li> <a href="">Newsletter</a> </li>
                          <li> <a href="">Tutorials</a> </li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
    
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-6">
          {{-- bulettin --}}
          <general-bulletin-card> </general-bulletin-card>
        </div>
        <div class="col-xl-6">
          <staff-leave-application> </staff-leave-application>
        </div>
      </div>
      <div class="row">

        <div class="col-xl-4">
          <staff-profile></staff-profile>
        </div>

        <div class="col-xl-4">
          <staff-document></staff-document>
        </div>

        <div class="col-xl-4">
          <general-client-card></general-client-card>
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