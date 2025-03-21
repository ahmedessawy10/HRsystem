<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="main-menu-content">
    <ul class="navigation navigation-main mt-2" id="main-menu-navigation" data-menu="menu-navigation">

      <!-- Attendance Section -->
      @can('employee_attendance show')

      <li class=" nav-item {{ request()->routeIs('attendanceHome.index') ? 'active' : '' }} ">
        <a href="{{ route('attendanceHome.index') }}">
          <i class="la la-calendar"></i>
          <span class="menu-title" data-i18n="nav.templates.main">{{ __('My Attendance') }}</span>
        </a>
      </li>
      @endcan

      <!-- General Holidays Section -->
      <li class="nav-item">
        <a href="#">
          <i class="fa fa-user"></i>
          <span class="menu-title" data-i18n="nav.templates.main">{{ __('hr Module') }}</span>
        </a>
        <ul class="menu-content">
          <li class="nav-item {{ request()->routeIs('holiday.index') ? 'active' : '' }}">
            <a href="{{ auth()->user()->hasRole('admin') ? route('holiday.index') : 'javascript:void(0)' }}"
              class="{{ auth()->user()->hasRole('admin') ? '' : 'disabled-link' }}"
              @if(!auth()->user()->hasRole('admin')) data-toggle="tooltip" title="Access restricted to admin only"
              @endif>
              <i class="la la-list"></i>
              <span class="menu-title" data-i18n="nav.templates.main">{{ __('Holiday List') }}</span>
            </a>
          </li>

          @can('attendance view_all')

          <li class=" nav-item {{ request()->routeIs('attendance.index') ? 'active' : '' }} ">
            <a href="{{ route('attendance.index') }}">
              <i class="fa fa-business-time"></i>
              <span class="menu-title" data-i18n="nav.templates.main">{{ __('attendance') }}</span>
            </a>
          </li>
          @endcan
          @canany(['salaries view_all', 'salaries view_own', 'salaries update', 'salaries print'])

          <li class=" nav-item {{ request()->routeIs('salaries.*s') ? 'active' : '' }} ">
            <a href="{{ route('salaries.index') }}">
              <i class="fa fa-wallet "></i>
              <span class="" data-i18n="nav.templates.main">{{ __('Salaries') }}</span>
            </a>
          </li>
          @endcanany


          @canany(['employees view','employees create_and_view','employees update'])
          <li class="nav-item {{ request()->routeIs('employees.*') ? 'active' : '' }}">
            <a href="{{ route('employees.index') }}">
              <i class="la la-users"></i>
              {{ __('app.employees') }}
            </a>
          </li>
          @endcanany
        </ul>
      </li>

      <!-- Settings Section -->
      <li class="nav-item">
        <a href="#">
          <i class="la la-television"></i>
          <span class="menu-title" data-i18n="nav.templates.main">{{ __('project.Settings') }}</span>
        </a>
        <ul class="menu-content">
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






    </ul>
  </div>
</div>