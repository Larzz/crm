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
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <h2 class="card-title">{{ $tutorial->title }}</h2>
                        <div>
                            @php
                            echo $tutorial->content
                            @endphp
                        </div>
                        <a href="{{ route('tutorial.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        @include('general.includes.footer')
    </div>
</div>

<style>
    .card {
        height: auto;
    }
</style>

@endsection
