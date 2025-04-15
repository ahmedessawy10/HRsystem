<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="main-menu-content">
    <ul class="navigation navigation-main mt-2" id="main-menu-navigation" data-menu="menu-navigation">

      <!-- Attendance Section -->
      @can('employee_attendance show')

      <li class=" nav-item {{ request()->routeIs('attendanceHome.index') ? 'active' : '' }} ">
        <a href="{{ route('attendanceHome.index') }}">
          <i class="la la-calendar"></i>
          <span class="menu-title" data-i18n="nav.templates.main">{{ __('app.my Attendance') }}</span>
        </a>
      </li>
      @endcan

      <!-- General Holidays Section -->
      <li class="nav-item">
        <a href="#">
          <i class="fa fa-user"></i>
          <span class="menu-title" data-i18n="nav.templates.main">{{ __('app.hr Module') }}</span>
        </a>

        @canany(['holiday view',
        'holiday create_and_view',
        'holiday update'])
        <ul class="menu-content">
          <li class="nav-item {{ request()->routeIs('holiday.index') ? 'active' : '' }}">
            <a href="{{ route('holiday.index') }} ">
              <i class="la la-list"></i>
              <span class="menu-title" data-i18n="nav.templates.main">{{ __('app.holiday list') }}</span>
            </a>
          </li>

          @can('attendance view_all')

          <li class=" nav-item {{ request()->routeIs('attendance.index') ? 'active' : '' }} ">
            <a href=" {{ route('attendance.index') }}">
              <i class="fa fa-business-time"></i>
              <span class="menu-title" data-i18n="nav.templates.main">{{ __('app.attendances') }}</span>
            </a>
          </li>
          @endcan
          @canany(['salaries view_all', 'salaries view_own', 'salaries update', 'salaries print'])

          <li class=" nav-item {{ request()->routeIs('salaries.*') ? 'active' : '' }} ">
            <a href="{{ route('salaries.index') }}">
              <i class="fa fa-wallet "></i>
              <span class="" data-i18n="nav.templates.main">{{ __('app.salaries') }}</span>
            </a>
          </li>
          @endcanany
          @canany(['careers view_all', 'careers view_own', 'careers update', 'salaries print'])

          <li class=" nav-item {{ request()->routeIs('careers.*') ? 'active' : '' }} ">
            <a href="{{ route('careers.index') }}">
              <i class="fa fa-suitcase"></i>
              <span class="" data-i18n="nav.templates.main">{{ __('app.careers') }}</span>
            </a>
          </li>
          @endcanany

          <!-- CV Analysis Section -->
          @can("cv analysis")
          <li class="nav-item {{ request()->routeIs('cv.upload', 'cv-analysis.*') ? 'active' : '' }}">
            <a href="#">
              <i class="fa fa-file-alt"></i>
              <span class="menu-title" data-i18n="nav.templates.main">{{ __('CV Analysis') }}</span>
            </a>
            <ul class="menu-content">
              <li class="{{ request()->routeIs('cv.upload') ? 'active' : '' }}">
                <a href="{{ route('cv.upload') }}">
                  <i class="fa fa-upload"></i>
                  {{ __('Upload CV') }}
                </a>
              </li>
              <li class="{{ request()->routeIs('cv-analysis.index') ? 'active' : '' }}">
                <a href="{{ route('cv-analysis.index') }}">
                  <i class="fa fa-list"></i>
                  {{ __('CV List') }}
                </a>
              </li>
            </ul>
          </li>
          @endcan
          @canany(['employees view','employees create_and_view','employees update'])
          <li class="nav-item {{ request()->routeIs('employees.*') ? 'active' : '' }}">
            <a href="{{ route('employees.index') }}">
              <i class="la la-users"></i>
              {{ __('app.employees') }}
            </a>
          </li>
          @endcanany
        </ul>
        @endcanany
      </li>

      <!-- Settings Section -->
      @canany(['user view_only', 'user create_and_view', 'permission view_only', 'permission create_and_view',
      'role view_only', 'role create_and_view', 'appSetting manage', 'hrSetting manage',
      'department view', 'department create', 'jobposition view', 'jobposition create_and_view',"company manage"])
      <li class=" nav-item {{ request()->routeIs('user.*', 'userRole.*', 'permission.*', 'appSettings.*',       
      'hrSettings.*', 'departments.*', 'jobpositions.*') ? 'active' : '' }}">

        <a href="#">
          <i class="la la-television"></i>
          <span class="menu-title" data-i18n="nav.templates.main">{{ __('project.Settings') }}</span>
        </a>
        <ul class=" menu-content">
          @canany(['user view_only', 'user create_and_view'])
          <li class="nav-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
            <a href="{{ route('admin.user.index') }}">
              <i class="la la-user"></i>
              <span class="menu-title" data-i18n="nav.templates.main">{{ __('project.Users') }}</span>
            </a>
          </li>
          @endcanany

          <!-- Roles & Permissions Section -->
          @canany(['permission view_only', 'permission create_and_view', 'role view_only',
          'role create_and_view','department create','department view','department edit'])
          <li class="nav-item {{ request()->routeIs('userRole.*', 'permission.*') ? 'active' : '' }}">
            <a href="#">
              <i class="la la-key"></i>
              <span class="menu-title" data-i18n="nav.templates.horz.main">{{ __('project.Permissions') }}</span>
            </a>
            <ul class="menu-content">
              @canany(['role view_only', 'role create_and_view'])
              <li class="nav-item {{ request()->routeIs('userRole.index') ? 'active' : '' }}">
                <a href="{{ route('userRole.index') }}">
                  <i class="la la-users"></i>
                  {{ __('project.Roles') }}
                </a>
              </li>
              @endcanany

              @canany(['permission view_only', 'permission create_and_view'])
              <li class="nav-item {{ request()->routeIs('permission.index') ? 'active' : '' }}">
                <a href="{{ route('permission.index') }}">
                  <i class="la la-lock"></i>
                  {{ __('project.Permissions') }}
                </a>
              </li>
              @endcanany
            </ul>
          </li>
          @endcanany











          {{-- app --}}


          <!-- Roles & Permissions Section -->
          {{-- @canany(['department view','department create','department update'])
            <li class="nav-item {{ request()->routeIs('userRole.*', 'permission.*') ? 'active' : '' }}">
          <a href="#">
            <i class="la la-key"></i>
            <span class="menu-title" data-i18n="nav.templates.horz.main">{{ __('app.appSetting') }}</span>
          </a>
          <ul class="menu-content">



          </ul>
      </li>
      @endcanany --}}




      @canany(['appSetting manage'])
      <li class="nav-item {{ request()->routeIs('appSettings.*') ? 'active' : '' }}">
        <a href="{{ route('appSettings.index') }}">
          <i class="la la-gear"></i>
          {{ __('app.appSetting') }}
        </a>
      </li>
      @endcanany
      @canany(['hrSetting manage'])
      <li class="nav-item {{ request()->routeIs('hrSettings.*') ? 'active' : '' }}">
        <a href="{{ route('hrSettings.index') }}">
          <i class="la la-users"></i>
          {{ __('app.hrSetting') }}
        </a>
      </li>
      @endcanany
      @canany(['company manage'])
      <li class="nav-item {{ request()->routeIs('companySetting.*') ? 'active' : '' }}">
        <a href="{{ route('companySetting.index') }}">
          <i class="la la-building"></i>
          {{ __('app.company setting') }}
        </a>
      </li>
      @endcanany


      @canany(['department view', 'department create'])
      <li class="nav-item {{ request()->routeIs('departments.*') ? 'active' : '' }}">
        <a href="{{ route('departments.index') }}">
          <i class="la la-building"></i>
          {{ __('app.departments') }}
        </a>
      </li>
      @endcanany

      @canany(['jobposition view', 'jobposition create_and_view','jobposition update'])
      <li class="nav-item {{ request()->routeIs('jobpositions.*') ? 'active' : '' }}">
        <a href="{{ route('jobpositions.index') }}">
          <i class="la la-suitcase"></i>
          {{ __('app.jobpositions') }}
        </a>
      </li>
      @endcanany
    </ul>
    </li>



    @endcanany



    </ul>
  </div>
</div>