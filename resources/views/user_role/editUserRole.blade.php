@extends("layouts.master")
@section("title")
{{__('project.edit user role')}}
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
                <h4 class="card-title" id="basic-layout-form">{{__('project.edit user role')}}</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"> </i></a>

              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  <div class="card-text">

                  </div>
                  <form class="form" method="post" action="{{route('userRole.update',$role->id)}}">
                    @csrf
                    @method('put')

                    <div class="form-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group redAstric">
                            <label for="name"> {{__('project.name of user role')}}</label>
                            <input type="text" class="form-control" id="name" placeholder="name" name="name"
                              value="{{old('name',$role->name)}}">
                            @error('name')
                            <div class="text-600  text-danger">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>



                        {{--  --}}
                        <div class="container">
                          <h3>{{__('project.Permissions')}}</h3>
                          <div class="row pt-2">



                            @foreach ($permissions as $key => $value)
                            <div class="col-2  col-md-4">
                              <h4>{{ $key }}</h4>
                              <div class="d-flex flex-column">
                                @if (count($value) > 0)
                                @foreach ($value as $item)
                                <div class="form-group  d-flex" style="margin-bottom:12px">
                                  @foreach ($item as $permission => $short)
                                  <input type="checkbox" class="form-control"
                                    {{($hasPermission->contains($permission))?'checked':" "}} style="width:18px"
                                    name="permissions[]" id="{{ 'permission-' . $key . $permission }}"
                                    value="{{ $permission }}">
                                  <label for="{{ 'permission-' . $key . $permission }}" class="" style="padding-left: 11px;
                                             padding-right: 11px;">{{$short}} </label>

                                  @endforeach
                                </div>
                                @endforeach

                                @else
                                <p>No permissions available.</p> <!-- Optional: Message if no permissions -->
                                @endif
                              </div>

                            </div>
                            @endforeach


                          </div>
                        </div>
                        {{--  --}}
                      </div>

                    </div>
                    <div class="form-actions">
                      <a href="{{route('userRole.index')}}" class="btn btn-warning mr-1">
                        <i class="ft-x"></i> {{__('back')}}
                      </a>
                      <button type="submit" class="btn  " style="background-color: #1E9FF2;color:white">
                        <i class="la la-check-square-o"></i> {{__('Save')}}
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