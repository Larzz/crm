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
                       
                            <li> <a class="{{ $active === 'dashboard' ? 'active' : '' }}"
                               href="{{ route('staff.home') }}">Dashboard</a> </li>
                  
                            {{-- <li> <a class="{{ $active === 'presentation' ? 'active' : '' }}"
                            href="{{ route('admin.presentations') }}">Presentations</a> </li> --}}
                            <li> <a class="{{ $active === 'backend' ? 'active' : '' }}"
                                    href="{{ route('general.admin.client') }}">Client</a> </li>
                            <li> <a class="{{ $active === 'website_domains' ? 'active' : '' }}"
                                    href="{{ route('website.index') }}">Website</a> </li>
                            <li> <a class="{{ $active === 'newsletter' ? 'active' : '' }}"
                                    href="{{ route('newsletter.index') }}">Newsletter</a> </li>
                            <li> <a class="{{ $active === 'tutorials' ? 'active' : '' }}"
                                    href="{{ route('tutorial.index') }}">Tutorials</a> </li>
                            <li> <a href="https://creativouae.com/articles-and-newsletters/">Blog</a> </li>
    
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
                <general-bulletin-card> </general-bulletin-card>
            </div>
            <div class="col-xl-6">
                <staff-leave-application :leave="{{ $leave }}"> </staff-leave-application>
            </div>
        </div>
        <div class="row">

            <div class="col-xl-4">
                <staff-profile :employee="{{ Auth::User() }}"></staff-profile>
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
