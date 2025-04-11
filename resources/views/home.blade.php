@extends("layouts.master")
@section("title.create user")
@endsection
@section("css")




@endsection

@section("content")
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">

      {{--  --}}

      @if ($holiday)
      <div class="bs-callout-success callout-bordered mt-1 mb-2">
        <div class="media align-items-stretch">
          <div class="media-left media-middle bg-success p-2">
            <i class="fa fa-gift white font-medium-5 mt-1"></i>
          </div>
          <div class="media-body p-1" style="background-color: #fff">
            <strong class="mb-1">{{ __("app.congratulations") }}</strong>
            <p>{{$holiday->occation}}</p>
          </div>
        </div>
      </div>
      @endif

      {{--  --}}
      <section id="basic-form-layouts">
        <div class="row match-height">
          <div class="row">
            @can('statistics employee_count')
            <div class="col-xl-3 col-lg-6 col-12">
              <div class="card pull-up">
                <div class="card-content">
                  <div class="card-body">
                    <div class="media d-flex">
                      <div class="media-body text-left">
                        <h3 class="info">{{$employee_count}}</h3>
                        <h6> {{__('app.employees count')}}</h6>
                      </div>
                      <div>
                        <i class="la la-users info font-large-2 float-right"></i>
                      </div>
                    </div>
                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                      <div class="progress-bar bg-gradient-x-info" role="progressbar"
                        style="width: {{$employee_count}}%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endcan
            @can('statistics total_payroll')
            <div class="col-xl-3 col-lg-6 col-12">
              <div class="card pull-up">
                <div class="card-content">
                  <div class="card-body">
                    <div class="media d-flex">
                      <div class="media-body text-left">
                        <h3 class="info">{{$total_payroll}}</h3>
                        <h6> {{__('app.total payroll')}}</h6>
                      </div>
                      <div>
                        <i class="la la-cubes info font-large-2 float-right"></i>
                      </div>
                    </div>
                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                      <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: {{$total_payroll}}%"
                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endcan
            @can('statistics open_career_count')
            <div class="col-xl-3 col-lg-6 col-12">
              <div class="card pull-up">
                <div class="card-content">
                  <div class="card-body">
                    <div class="media d-flex">
                      <div class="media-body text-left">
                        <h3 class="info">{{$open_career_count}}</h3>
                        <h6> {{__('app.open_career_count')}}</h6>
                      </div>
                      <div>
                        <i class="la la-users info font-large-2 float-right"></i>
                      </div>
                    </div>
                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                      <div class="progress-bar bg-gradient-x-info" role="progressbar"
                        style="width: {{$open_career_count}}%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endcan
          </div>

          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title" id="basic-layout-form"> </h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  <div class="card-text">



                  </div>

                </div>
              </div>
            </div>
          </div>

        </div>

      </section>


    </div>
  </div>
</div>
@endsection




@section("js")



@endsection