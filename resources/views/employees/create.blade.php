
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
            <div class="card" style="">
              <div class="card-header">
                <h4 class="card-title" id="basic-layout-form"> </h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  <div class="card-text">
                    {{-- content --}} 
                    
                    <div class="container mt-5">
                    <div class="container mt-5">
    <h1>Add Employee</h1>
    <form action="{{ route('employees.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3 col-md-6">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname">
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3 col-md-6">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
            <div class="mb-3 col-md-6">
                <label for="salary" class="form-label">Salary</label>
                <input type="number" class="form-control" id="salary" name="salary">
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="join_date" class="form-label">Join Date</label>
                <input type="date" class="form-control" id="join_date" name="join_date">
            </div>
            <div class="mb-3 col-md-6">
                <label for="nationality_id" class="form-label">National ID</label>
                <input type="text" class="form-control" id="nationality_id" name="nationality_id">
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" class="form-control" id="start_time" name="start_time">
            </div>
            <div class="mb-3 col-md-6">
                <label for="role" class="form-label">Role</label>
                <input type="text" class="form-control" id="role" name="role">
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-control" id="gender" name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

    
                    <!-- <h1>{{__('app.test')}}</h1> -->
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