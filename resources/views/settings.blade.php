@extends("layouts.master")

@section("title")
    {{ __("project.settings") }}
@endsection

@section("css")
    <!-- يمكن إضافة أكواد CSS هنا إذا لزم الأمر -->
@endsection

@section("content")
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row"></div>
    <div class="content-body">

      <section id="settings-section">
        <div class="row match-height">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">{{ __("project.general_settings") }}</h4>
              </div>
              <div class="card-content collapse show">
                <div class="card-body">
                  <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- الإضافة لكل ساعة إضافية -->
                    <div class="form-group">
                      <label for="overtime">{{ __("project.overtime") }}</label>
                      <input type="number" id="overtime" name="overtime" class="form-control" value="{{ $settings->overtime ?? '' }}">
                    </div>

                    <!-- الخصم لكل ساعة تأخير -->
                    <div class="form-group">
                      <label for="discount">{{ __("project.discount") }}</label>
                      <input type="number" id="discount" name="discount" class="form-control" value="{{ $settings->discount ?? '' }}">
                    </div>

                    <!-- يوم الإجازة الأسبوعية 1 -->
                    <div class="form-group">
                      <label for="day_off_1">{{ __("project.day_off_1") }}</label>
                      <select id="day_off_1" name="day_off_1" class="form-control">
                        <option value="Friday" {{ ($settings->day_off_1 ?? '') == 'Friday' ? 'selected' : '' }}>Friday</option>
                        <option value="Saturday" {{ ($settings->day_off_1 ?? '') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                        <option value="Sunday" {{ ($settings->day_off_1 ?? '') == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                        <option value="Monday" {{ ($settings->day_off_1 ?? '') == 'Monday' ? 'selected' : '' }}>Monday</option>
                        <option value="Tuesday" {{ ($settings->day_off_1 ?? '') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                        <option value="Wednesday" {{ ($settings->day_off_1 ?? '') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                        <option value="Thursday" {{ ($settings->day_off_1 ?? '') == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                      </select>
                    </div>

                    <!-- يوم الإجازة الأسبوعية 2 -->
                    <div class="form-group">
                      <label for="day_off_2">{{ __("project.day_off_2") }}</label>
                      <select id="day_off_2" name="day_off_2" class="form-control">
                        <option value="">No Holiday</option>
                        <option value="Friday" {{ ($settings->day_off_2 ?? '') == 'Friday' ? 'selected' : '' }}>Friday</option>
                        <option value="Saturday" {{ ($settings->day_off_2 ?? '') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                        <option value="Sunday" {{ ($settings->day_off_2 ?? '') == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                        <option value="Monday" {{ ($settings->day_off_2 ?? '') == 'Monday' ? 'selected' : '' }}>Monday</option>
                        <option value="Tuesday" {{ ($settings->day_off_2 ?? '') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                        <option value="Wednesday" {{ ($settings->day_off_2 ?? '') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                        <option value="Thursday" {{ ($settings->day_off_2 ?? '') == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                      </select>
                    </div>

                    <!-- يوم الإجازة البديل -->
                    <!-- <div class="form-group">
                      <label for="alternative_day_off">{{ __("project.alternative_day_off") }}</label>
                      <select id="alternative_day_off" name="alternative_day_off" class="form-control">
                        <option value="">No Alternative Day</option>
                        <option value="Friday" {{ ($settings->alternative_day_off ?? '') == 'Friday' ? 'selected' : '' }}>Friday</option>
                        <option value="Saturday" {{ ($settings->alternative_day_off ?? '') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                        <option value="Sunday" {{ ($settings->alternative_day_off ?? '') == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                        <option value="Monday" {{ ($settings->alternative_day_off ?? '') == 'Monday' ? 'selected' : '' }}>Monday</option>
                        <option value="Tuesday" {{ ($settings->alternative_day_off ?? '') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                        <option value="Wednesday" {{ ($settings->alternative_day_off ?? '') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                        <option value="Thursday" {{ ($settings->alternative_day_off ?? '') == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                      </select>
                    </div> -->

                    <!-- زر الحفظ -->
                    <button type="submit" class="btn btn-primary">{{ __("project.save_changes") }}</button>
                  </form>

                  <!-- أزرار إدارة الأقسام والمسميات الوظيفية -->
                  <div class="mt-4">
                    <a href="{{ route('departments.index') }}" class="btn btn-success">Department Management</a>
                    <a href="{{ route('job_positions.index') }}" class="btn btn-info">Job Title Management</a>
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
    <!-- يمكن إضافة أكواد JavaScript هنا إذا لزم الأمر -->
@endsection
