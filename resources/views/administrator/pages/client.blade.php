@extends('administrator.layouts.default')

@section('content')

<!-- Main content -->
<div class="main-content" id="panel">
    <!-- Topnav -->
    @include('administrator.includes.top_nav')
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
