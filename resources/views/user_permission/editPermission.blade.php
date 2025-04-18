@extends("layouts.master")
@section("title")
{{__('project.edit  permission')}}
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
            <div class="card" style="">
              <div class="card-header">
                <h4 class="card-title" id="basic-layout-form"> {{__('project.edit permission')}}</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"> </i></a>

              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  <div class="card-text">

                  </div>
                  <form class="form" method="post" action="{{route('permission.update',$permission->id)}}">
                    @csrf
                    @method('put')
                    <div class="form-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="email-addr">{{__('project.name')}} </label>
                            <input type="text" class="form-control" id="email-addr" placeholder="name" name="name"
                              value="{{old('name',$permission->name)}}">
                            @error('name')
                            <div class="text-600  text-danger">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="clear_name"> {{__('project.clear_name')}}</label>
                            <input type="text" class="form-control" id="clear_name" placeholder="name" name="clear_name"
                              value="{{old('clear_name',$permission->clear_name)}}">
                            @error('clear_name')
                            <div class="text-600  text-danger">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>

                      </div>

                    </div>
                    <div class="form-actions">

                      <button type="submit" class="btn  " style="background-color: #1E9FF2;color:white">
                        <i class="la la-check-square-o"></i> {{__('project.save')}}
                      </button>
                    </div>
                  </form>
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
{{-- <script src="{{asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}" type="text/javascript">
</script>
<script src="{{asset('app-assets/js/scripts/forms/form-repeater.js')}}" type="text/javascript"></script> --}}
@endsection