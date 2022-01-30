@extends('general.layouts.default')

@section('content')
 
<!-- Main content -->
<div class="main-content" id="panel">
  <!-- Topnav -->
  @include('general.includes.top_nav')
  <!-- Header -->
  <div class="header bg-primary pb-6">
      <div class="container-fluid">
          <div class="header-body">
              <div class="row align-items-center py-4">
                  <div class="col-lg-12 col-7">
                      <ul class="nav-sub-sx">
                          <li> <a href="https://creativouae.com/articles-and-newsletters/">Blog</a> </li>
                          <li> <a href="{{ route('admin.presentations') }}">Presentations</a> </li>
                          <li> <a href="{{ route('admin.client') }}">Client Backend</a> </li>
                          <li> <a href="{{ route('website.index') }}">Website</a> </li>
                          <li> <a href="{{ route('newsletter.index') }}">Newsletter</a> </li>
                          <li> <a href="{{ route('tutorial.index') }}">Tutorials</a> </li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
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