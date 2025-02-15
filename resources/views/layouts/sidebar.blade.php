<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      
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

          @canany(['permission view_only', 'permission create_and_view', 'role view_only', 'role create_and_view'])
          <li class="nav-item {{ request()->routeIs('userRole.*', 'permission.*') ? 'active' : '' }}">
            <a class="menu-item" href="#" data-i18n="nav.templates.horz.main">
              <i class="la la-key"></i>
              {{ __('project.Roles & Permissions') }}
            </a>
            <ul class="menu-content">
              @canany(['role view_only', 'role create_and_view'])
              <li class="nav-item {{ request()->routeIs('userRole.index') ? 'active' : '' }}">
                <a class="menu-item" href="{{ route('userRole.index') }}">
                  <i class="la la-users"></i>
                  {{ __('project.Roles') }}
                </a>
              </li>
              @endcanany
              
              @canany(['permission view_only', 'permission create_and_view'])
              <li class="nav-item {{ request()->routeIs('permission.index') ? 'active' : '' }}">
                <a class="menu-item" href="{{ route('permission.index') }}">
                  <i class="la la-lock"></i>
                  {{ __('project.Permissions') }}
                </a>
              </li>
              @endcanany
            </ul>
          </li>
          @endcanany 
        </ul>
      </li>

      <!-- General Holidays Section -->
      <li class="nav-item">
        <a href="#">
          <i class="la la-calendar"></i>
          <span class="menu-title" data-i18n="nav.templates.main">{{ __('project.General Holidays') }}</span>
        </a>
        <ul class="menu-content">
          <li class="nav-item {{ request()->routeIs('holiday.index') ? 'active' : '' }}">
            <a href="{{ route('holiday.index') }}">
              <i class="la la-list"></i>
              <span class="menu-title" data-i18n="nav.templates.main">{{ __('project.Holiday List') }}</span>
            </a>
          </li>
          <li class="nav-item {{ request()->routeIs('holiday.create') ? 'active' : '' }}">
            <a href="{{ route('holiday.create') }}">
              <i class="la la-plus"></i>
              <span class="menu-title" data-i18n="nav.templates.main">{{ __('project.Add Holiday') }}</span>
            </a>
          </li>
          <li class="nav-item {{ request()->routeIs('holiday.calendar') ? 'active' : '' }}">
            <a href="{{ route('holiday.calendar') }}">
              <i class="la la-calendar-check"></i>
              <span class="menu-title" data-i18n="nav.templates.main">{{ __('project.Holiday Calendar') }}</span>
            </a>
          </li>
          <li class="nav-item {{ request()->routeIs('holiday.report') ? 'active' : '' }}">
            <a href="{{ route('holiday.report') }}">
              <i class="la la-file-text"></i>
              <span class="menu-title" data-i18n="nav.templates.main">{{ __('project.Holiday Reports') }}</span>
            </a>
          </li>
        </ul>
      </li>
      
      <!-- Attendance Section: Restricted to Employee Role Only -->
      @role('employee')
      <li class="nav-item">
        <a href="#">
          <i class="la la-clock-o"></i>
          <span class="menu-title" data-i18n="nav.attendance.main">{{ __('project.Attendance') }}</span>
        </a>
        <ul class="menu-content">
          <li class="nav-item {{ request()->routeIs('attendance.index') ? 'active' : '' }}">
            <a href="{{ route('attendance.index') }}">
              <i class="la la-check-circle"></i>
              <span class="menu-title" data-i18n="nav.attendance.my">{{ __('project.My Attendance') }}</span>
            </a>
          </li>
        </ul>
      </li>
      @endrole

    </ul>
  </div>
</div>
