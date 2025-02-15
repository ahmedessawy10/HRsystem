<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow " data-scroll-to-active="true">
  <div class="main-menu-content">
    <ul class="navigation navigation-main mt-2" id="main-menu-navigation" data-menu="menu-navigation">


  


      <li class=" nav-item">
        <a href="#">
          <i class="la la-television"></i>
          <span class="menu-title" data-i18n="nav.templates.main">{{ __('project.Settings')}}</span>
        </a>
        <ul class="menu-content">
          @canany(['user view_only','user create_and_view'])
          <li class="nav-item {{request()->routeIs('user.*')?'active': ''}}">
            <a href="{{route('admin.user.index')}}">
              <span class="menu-title" data-i18n="nav.templates.main">{{ __('project.Users') }}</span>
            </a>
          </li>
          @endcanany


          @canany([
          'permission view_only',
          'permission create_and_view',
          'role view_only',
          'role create_and_view',
          ])
          <li class="{{request()->routeIs('userRole.*', 'permission.*') ? 'active' : ''}}">
            <a class="menu-item" href="#"
              data-i18n="nav.templates.horz.main">{{ __('project.Roles & Permissions') }}</a>
            <ul class="menu-content">

              @canany(['role view_only','role create_and_view'])
              <li class="{{request()->routeIs('userRole.index')?'active': ''}}">
                <a class="menu-item" href="{{route('userRole.index')}}">{{ __('project.Roles') }}</a>
              </li>
              @endcanany
              @canany(['permission view_only', 'permission create_and_view'])
              <li class="{{request()->routeIs('permission.index')?'active': ''}}">
                <a class="menu-item" href="{{route('permission.index')}}">{{ __('project.Permissions') }}</a>
              </li>
              @endcanany
              @endcanany



            </ul>
          </li>
        




        </ul>

        <li class="nav-item">
            <a href="{{ route('attendance.index') }}">
              <i class="la la-clock-o"></i>
              <span class="menu-title" data-i18n="nav.templates.main">{{ __('project.Attendance') }}</span>
            </a>
          </li>
    

  </div>
</div>