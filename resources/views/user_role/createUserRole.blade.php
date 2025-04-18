@extends("layouts.master")
@section("title", __('project.create user role'))

@section("css")
@endsection

@section("content")
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row"></div>
    <div class="content-body">
      <section id="basic-form-layouts">
        <div class="row match-height">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">{{ __('app.create user role') }}</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  <form class="form" action="{{ route('userRole.store') }}" method="post">
                    @csrf

                    <div class="form-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group redAstric">
                            <label for="projectinput1">{{ __('app.role name') }}</label>
                            <input type="text" id="projectinput1" class="form-control" name="name"
                              value="{{ old('name') }}">
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>

                        <div class="container">
                          <h3>{{ __('project.Permissions') }}</h3>
                          <div class="row pt-2">
                            @foreach ($permissions as $key => $value)
                            <div class="col-6 col-md-4">
                              <h4>{{ $key }}</h4>
                              <div class="d-flex flex-column">
                                @if (count($value) > 0)
                                @foreach ($value as $item)
                                <div class="form-group d-flex" style="margin-bottom:12px">
                                  @foreach ($item as $permission => $short)
                                  <input type="checkbox" class="form-check-input" style="width:18px;height:18px"
                                    name="permissions[]" id="{{ 'permission-' . $key . $permission }}"
                                    value="{{ $permission }}"
                                    {{ in_array($permission, old('permissions', [])) ? 'checked' : '' }}>
                                  <label for="{{ 'permission-' . $key . $permission }}"
                                    class="pl-2 pr-2">{{ $short }}</label>
                                  @endforeach
                                </div>
                                @endforeach
                                @else
                                <p>{{ __('project.no permissions available') }}</p>
                                @endif
                              </div>
                            </div>
                            @endforeach
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-actions">
                      <a href="{{ route('userRole.index') }}" class="btn btn-warning mr-1">
                        <i class="ft-x"></i> {{ __('project.back') }}
                      </a>
                      <button type="submit" class="btn btn-primary">
                        <i class="la la-check-square-o"></i> {{ __('project.save') }}
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