<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow " data-scroll-to-active="true">
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

      <li class="nav-item">
        <a href="#">
          <i class="la la-television"></i>
          <span class="menu-title" data-i18n="nav.templates.main">{{ __('project.Settings')}}</span>
        </a>
        <ul class="menu-content">
          @canany(['user view_only','user create_and_view'])
          <li class="nav-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
            <a href="{{ route('admin.user.index') }}">
              <span class="menu-title" data-i18n="nav.templates.main">{{ __('project.Users') }}</span>
            </a>
          </li>
          @endcanany

          @canany(['permission view_only', 'permission create_and_view', 'role view_only', 'role create_and_view'])
          <li class="{{ request()->routeIs('userRole.*', 'permission.*') ? 'active' : '' }}">
            <a class="menu-item" href="#" data-i18n="nav.templates.horz.main">{{ __('project.Roles & Permissions') }}</a>
            <ul class="menu-content">
              @canany(['role view_only','role create_and_view'])
              <li class="{{ request()->routeIs('userRole.index') ? 'active' : '' }}">
                <a class="menu-item" href="{{ route('userRole.index') }}">{{ __('project.Roles') }}</a>
              </li>
              @endcanany
              @canany(['permission view_only', 'permission create_and_view'])
              <li class="{{ request()->routeIs('permission.index') ? 'active' : '' }}">
                <a class="menu-item" href="{{ route('permission.index') }}">{{ __('project.Permissions') }}</a>
              </li>
              @endcanany
            </ul>
          </li>
          @endcanany

          <!-- ✅ إضافة الأقسام (Departments) -->
          @canany(['department view_only', 'department create_and_view'])
          <li class="nav-item {{ request()->routeIs('departments.*') ? 'active' : '' }}">
            <a href="{{ route('departments.index') }}">
              <i class="la la-building"></i>
              <span class="menu-title">{{ __('project.Departments') }}</span>
            </a>
          </li>
          @endcanany

          <!-- ✅ إضافة المسميات الوظيفية (Job Titles) -->
          @canany(['job_title view_only', 'job_title create_and_view'])
          <li class="nav-item {{ request()->routeIs('job_titles.*') ? 'active' : '' }}">
            <a href="{{ route('job_titles.index') }}">
              <i class="la la-briefcase"></i>
              <span class="menu-title">{{ __('project.Job Titles') }}</span>
            </a>
          </li>
          @endcanany

        </ul>
      </li>
    </ul>
  </div>
</div>
