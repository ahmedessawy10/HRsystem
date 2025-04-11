@extends("front-pages.layout.app")


@section("title","careers")


@section("content")

<!-- Service Start -->

<div class="container-fluid py-5 wow fadeInUp  " style="background-color: #ccc" data-wow-delay="0.1s">
    <div class="container " style=" padding-top: 150px;">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h5 class="fw-bold text-primary text-uppercase">Our Careers</h5>
            <h1 class="mb-0"></h1>
        </div>
        <div class="row g-5">

            @forelse ( $careers as $career )

            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                <div
                    class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                    <div class="service-icon">
                        <i class="fa fa-shield-alt text-white"></i>
                    </div>
                    <h4 class="mb-3">{{$career->title}}</h4>

                    <a class=" btn-lg btn-primary rounded px-4 mt-5" href="{{ route('home.career.details',$career->id) }}">
                        apply
                    </a>
                </div>
            </div>

            @empty

            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                <div
                    class="service-item bg-light rounded d-flex flex-column align-items-center justify-content-center text-center">
                    <div class="service-icon">
                        <i class="fa fa-shield-alt text-white"></i>
                    </div>
                    <h4 class="mb-3">No Careers Available</h4>

                </div>
                @endforelse


            </div>
        </div>
    </div>
    <!-- Service End -->












    @endsection