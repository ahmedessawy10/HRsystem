<nav
  class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light bg-info navbar-shadow">
  <div class="navbar-wrapper">
    <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
        <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
            href="#"><i class="ft-menu font-large-1"></i></a></li>
        <li class="nav-item">
          <a class="navbar-brand" href="{{route('dashboard')}}">
            <img class="brand-logo" alt="modern admin logo" src="{{asset('uploads/'.$appSetting->logo)}}"
              style="max-width:200px">
          </a>
        </li>
        <li class="nav-item d-md-none">
          <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i
              class="la la-ellipsis-v"></i></a>
        </li>
      </ul>
    </div>
    <div class="navbar-container content">
      <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="nav navbar-nav mr-auto float-left">
          <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                class="ft-menu"></i></a></li>

          </li>
          {{-- <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i class="ficon ft-search"></i></a>
            <div class="search-input">
              <input class="input" type="text" placeholder="Explore Modern...">
            </div>
          </li> --}}
        </ul>
        <ul class="nav navbar-nav float-right">
          <li class="dropdown dropdown-user nav-item">
            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
              <span class="mr-1">{{__("project.hello")}},
                @auth()
                <span class=" text-bold-700">{{auth()->user()->name}}</span>
                @endauth
              </span>
              <span class="avatar avatar-online">
                <img src="https://ui-avatars.com/api/?name={{auth()->user()->name}}&background=0D8ABC&color=fff"
                  alt="avatar"><i></i></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">

              <a class="dropdown-item" href=""><i class="ft-user"></i>{{  __('project.Profile')}}</a>

              {{-- <a class="dropdown-item" href="#"><i class="ft-mail"></i> My Inbox</a> --}}
              {{-- <a class="dropdown-item" href="#"><i class="ft-check-square"></i> Task</a> 
              <a class="dropdown-item" href="#"><i class="ft-message-square"></i> Chats</a> --}}
              <div class="dropdown-divider"></div>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="dropdown-item" type="submit"><i class="ft-power"></i> {{__("project.logout")}}</button>
              </form>
            </div>
          </li>
          <li class="dropdown dropdown-language nav-item">
            <a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false">

              <i class="flag-icon flag-icon-{{(config('app.locale')=="ar")?"sa":'gb'}}"></i><span
                class="selected-language"></span></a>
            <div class="dropdown-menu trans" aria-labelledby="dropdown-flag">
              @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
              @if($localeCode !=config('app.locale'))
              <a rel="alternate" class="dropdown-item" hreflang="{{ $localeCode }}"
                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                @if($localeCode =='ar')
                <i class="flag-icon flag-icon-sa"></i>
                @elseif ($localeCode =='en')
                <i class="flag-icon flag-icon-gb"></i>
                @else
                <i class="flag-icon flag-icon-gb"></i>
                @endif
                {{ $properties['native'] }}
              </a>

              @endif
              @endforeach


            </div>

          </li>
          @livewire('notification-card')
          <li class="dropdown dropdown-notification nav-item">
            <a class="nav-link nav-link-label" href="{{ route("chats.index") }}"><i class="ficon ft-mail"> </i></a>
            {{-- <a class="nav-link nav-link-label" href="{{ route("chats.index") }}" data-toggle="dropdown"><i
              class="ficon ft-mail"> </i></a> --}}
            {{-- <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
              <li class="dropdown-menu-header">
                <h6 class="dropdown-header m-0">
                  <span class="grey darken-2">Messages</span>
                </h6>
                <span class="notification-tag badge badge-default badge-warning float-right m-0">4 New</span>
              </li>
              <li class="scrollable-container media-list w-100">
                <a href="javascript:void(0)">
                  <div class="media">
                    <div class="media-left">
                      <span class="avatar avatar-sm avatar-online rounded-circle">
                        <img src="../../../app-assets/images/portrait/small/avatar-s-19.png" alt="avatar"><i></i></span>
                    </div>
                    <div class="media-body">
                      <h6 class="media-heading">Margaret Govan</h6>
                      <p class="notification-text font-small-3 text-muted">I like your portfolio, let's start.</p>
                      <small>
                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time>
                      </small>
                    </div>
                  </div>
                </a>
                <a href="javascript:void(0)">
                  <div class="media">
                    <div class="media-left">
                      <span class="avatar avatar-sm avatar-busy rounded-circle">
                        <img src="../../../app-assets/images/portrait/small/avatar-s-2.png" alt="avatar"><i></i></span>
                    </div>
                    <div class="media-body">
                      <h6 class="media-heading">Bret Lezama</h6>
                      <p class="notification-text font-small-3 text-muted">I have seen your work, there is</p>
                      <small>
                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Tuesday</time>
                      </small>
                    </div>
                  </div>
                </a>
                <a href="javascript:void(0)">
                  <div class="media">
                    <div class="media-left">
                      <span class="avatar avatar-sm avatar-online rounded-circle">
                        <img src="../../../app-assets/images/portrait/small/avatar-s-3.png" alt="avatar"><i></i></span>
                    </div>
                    <div class="media-body">
                      <h6 class="media-heading">Carie Berra</h6>
                      <p class="notification-text font-small-3 text-muted">Can we have call in this week ?</p>
                      <small>
                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Friday</time>
                      </small>
                    </div>
                  </div>
                </a>
                <a href="javascript:void(0)">
                  <div class="media">
                    <div class="media-left">
                      <span class="avatar avatar-sm avatar-away rounded-circle">
                        <img src="../../../app-assets/images/portrait/small/avatar-s-6.png" alt="avatar"><i></i></span>
                    </div>
                    <div class="media-body">
                      <h6 class="media-heading">Eric Alsobrook</h6>
                      <p class="notification-text font-small-3 text-muted">We have project party this saturday.</p>
                      <small>
                        <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">last month</time>
                      </small>
                    </div>
                  </div>
                </a>
              </li>
              <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                  href="javascript:void(0)">Read all messages</a></li>
            </ul> --}}
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>