@extends('administrator.layouts.default')

@section('content')

<!-- Main content -->
<div class="main-content" id="panel">
    <!-- Topnav -->
    @include('administrator.includes.top_nav')
    <!-- Header -->
    @include('administrator.includes.navigation')
    <!-- Page content -->
    <div class="container-fluid mt--6">

        <div class="row">

            <div class="col-md-3">
                <div class="card">
                    <img class="card-img-top"
                        src="https://banner2.cleanpng.com/20180531/rtf/kisspng-pdf-computer-icons-information-rpse-5b0fbe63918ea4.4536074215277584355962.jpg"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the card's content.</p>
                        <a href="#" class="btn btn-primary">View Document</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img class="card-img-top"
                        src="https://banner2.cleanpng.com/20180531/rtf/kisspng-pdf-computer-icons-information-rpse-5b0fbe63918ea4.4536074215277584355962.jpg"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the card's content.</p>
                        <a href="#" class="btn btn-primary">View Document</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img class="card-img-top"
                        src="https://banner2.cleanpng.com/20180531/rtf/kisspng-pdf-computer-icons-information-rpse-5b0fbe63918ea4.4536074215277584355962.jpg"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the card's content.</p>
                        <a href="#" class="btn btn-primary">View Document</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img class="card-img-top"
                        src="https://banner2.cleanpng.com/20180531/rtf/kisspng-pdf-computer-icons-information-rpse-5b0fbe63918ea4.4536074215277584355962.jpg"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the card's content.</p>
                        <a href="#" class="btn btn-primary">View Document</a>
                    </div>
                </div>
            </div>



        </div>





        <!-- Footer -->
        @include('administrator.includes.footer')
    </div>
</div>
@endsection
