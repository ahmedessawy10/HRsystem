@extends("front-pages.layout.app")


@section("title","careers")


@section("content")

<!-- Service Start -->

<div class="container-fluid py-5 wow fadeInUp  " style="background-color: #ccc" data-wow-delay="0.1s">
    <div class="container " style=" padding-top: 150px;">


        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px;">
            <h5 class="fw-bold text-primary text-uppercase">{{$career->title}}</h5>
            <h1 class="mb-0"></h1>
        </div>
        <div class="row g-5">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-times-circle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle"></i> {{ session('info') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="col-md-8">

                <div class="card">
                    <div class="">
                        <h4 class="text-center text-primary py-2">description</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-center">{{ $career->description }}</p>

                    </div>
                </div>
            </div>
            <div class="col-md-4">

                <div class="card">
                    <div class="">
                        <h4 class="text-center text-primary py-2">Career Apply</h4>
                    </div>
                    <div class="card-body">
                        <div class=" wow slideInUp" data-wow-delay="0.3s">
                            <form action="{{ route('home.career.apply',$career->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="" class="px-1 py-2 fs-6">Name </label>
                                        <input type="text" class="form-control border-0 bg-light px-4" name="name"
                                            placeholder="Your Name" value="{{ old('name') }}" style="height: 55px;">
                                        @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="" class="px-1 py-2 fs-6">Email </label>
                                        <input type="email" class="form-control border-0 bg-light px-4" name="email"
                                            value="{{ old('email') }}" placeholder="Your Email" style="height: 55px;">
                                        @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="" class="px-1 py-2 fs-6">Phone </label>
                                        <input type="text" class="form-control border-0 bg-light px-4" name="phone"
                                            placeholder="Your phone" value="{{ old('phone') }}" style="height: 55px;">
                                        @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="" class="px-1 py-2 fs-6">Cv</label>
                                        <input type="file" name="cv" class="form-control border-0 bg-light px-4"
                                            value="{{ old("cv") }}" placeholder="cv " style="height: 55px;">
                                        @error('cv')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="" class="px-1 py-2 fs-6">cover letter</label>
                                        <textarea class="form-control border-0 bg-light px-4 py-3" rows="4"
                                            name="cover_letter" placeholder="cover letter">
                                        {{ old('cover_letter') }}
                                        </textarea>
                                        @error('cover_letter')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" type="submit">Apply</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>




        </div>
    </div>
</div>
<!-- Service End -->












@endsection