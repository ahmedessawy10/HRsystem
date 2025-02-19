@extends("layouts.master")
@section("title")
{{__("project.create user")}}
@endsection
@section("css")




@endsection

@section("content")
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">

      <section id="basic-form-layouts">
        <div class="row match-height">
          <div class="col-md-12">
            <div class="card" >
              <div class="card-header">
                <h4 class="card-title" id="basic-layout-form"> </h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  <div class="card-text">
                    {{-- content --}} <h1>{{__('app.failed')}}</h1>
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