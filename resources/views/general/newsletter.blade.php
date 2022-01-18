@extends('general.layouts.default')

@section('content')
 
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    @include('general.includes.top_nav')

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
    
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">{{ $title }}</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="#">{{ $title }}s</a></li>
                  {{-- <li class="breadcrumb-item active" aria-current="page">Default</li> --}}
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right d-none">
              <a href="#" class="btn btn-sm btn-neutral">New Client</a>
              <a href="#" class="btn btn-sm btn-neutral">New Employee</a>
            </div>
          </div>
          <!-- Card stats -->
         
        </div>
      </div>
    </div>
    <!-- Page content -->
     <div>
      <!-- Footer -->
      @include('general.includes.footer')
    </div> 
  </div>
@endsection