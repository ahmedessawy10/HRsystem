@extends("back.layouts.master")
@section("title",__('project.create user role'))

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
                    <h4 class="card-title" id="basic-layout-form">{{__('project.create user role')}}</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                  </div>
                  <div class="card-content collapse show">
                    <div class="card-body">
                      <div class="card-text">
                       
                      </div>
                      <form class="form" action="{{route('admin.userRole.store')}}" method="post">

                        @csrf 
                        <div class="form-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group redAstric">
                                <label for="projectinput1">{{__('project.name of user role')}} </label>
                                <input type="text" id="projectinput1" class="form-control" name="name" value="{{old('name')}}">
                              </div>
                              @error('name')

                              <div class="text-red-600 text-danger">
                                {{ $message }}</div>  
                            @enderror
                            </div>
                           
                            <div class="container">
                              <h3>{{__('project.Permissions')}}</h3>
                              <div class="row pt-2" >
 

                                
                                  @foreach ($permissions as $key => $value)
                                  <div class="col-2  col-md-4">
                                  <h4>{{ $key }}</h4>
                                  <div class="d-flex flex-column">
                                    @if (count($value) > 0)
                                    @foreach ($value  as $item)
                                    <div class="form-group  d-flex" style="margin-bottom:12px">
                                    @foreach ($item as $permission => $short)
                                    <input type="checkbox" class="form-control" style="width:18px" name="permissions[]" id="{{ 'permission-' . $key . $permission }}" value="{{ $permission }}">
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
                          
                          </div>
                          
                        </div>
                        <div class="form-actions">
                          <a href="{{route('admin.userRole.index')}}" class="btn btn-warning mr-1">
                            <i class="ft-x"></i> {{__('project.back')}}
                          </a>
                          <button type="submit" class="btn btn-primary">
                            <i class="la la-check-square-o"></i>{{__('project.save')}} 
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

@endsection

