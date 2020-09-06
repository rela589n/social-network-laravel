<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <div class="container">

    @if ( Auth::check() )
      <a class="navbar-brand"
         href="{{ route('profile.index',
                  ['username' => Auth::user()->username ]) }}">
      {{ config('app.name') }}</a>
    @else
      <a class="navbar-brand"
         href="{{ route('home') }}">{{ config('app.name') }}</a>
    @endif

    <button type="button"
            class="navbar-toggler"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse"
         id="navbarSupportedContent">

      @if ( Auth::check() )
      <ul class="navbar-nav mr-auto">
        <li class="nav-item {{ Route::currentRouteNamed('home') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-comments"></i> Стена
          </a>
        </li>
        <li class="nav-item {{ Route::currentRouteNamed('friend.index') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('friend.index') }}">
            <i class="fas fa-user-friends"></i> Друзья
          </a>
        </li>
        <form method="GET" action="{{ route('search.results') }}"
              class="form-inline ml-2">
          <input type="search"
            class="search"
            name="query"
            placeholder="Поиск..."
            aria-label="Search">
          <button type="submit" class="btn-search">
            <i class="fas fa-search"></i>
          </button>
        </form>
      </ul>
      @endif

      <ul class="navbar-nav ml-auto">
      @if ( Auth::check() )
        <li class="nav-item dropdown {{ Request::is('user/' . Auth::user()->username) ? 'active' : '' }}">
          <a class="nav-link dropdown-toggle"
             href="#"
             id="navbarDropdownMenuLink"
             role="button"
             data-toggle="dropdown"
             aria-haspopup="true"
             aria-expanded="false">
            
            @if ( ! Auth::user()->avatar )
              <img src="{{ Auth::user()->getAvatarUrl() }}"
                   class="rounded-circle nav-avatar">
            @else
              <img src="{{ Auth::user()->getAvatarsPath(Auth::user()->id)
                         . Auth::user()->avatar }}"
                   class="rounded-circle nav-avatar">
            @endif

            <span class="nav-username">{{ Auth::user()->getNameOrUsername() }}</span>
          </a>

          <div class="dropdown-menu"
               aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item"
               href="{{ route('profile.index',
                        ['username' => Auth::user()->username ]) }}">
              <i class="fas fa-user-circle"></i> Профиль
            </a>
            <a class="dropdown-item" href="{{ route('profile.edit') }}">
              <i class="fas fa-user-edit"></i> Редактировать
            </a>
            <a href="{{ route('logout') }}"
               class="dropdown-item"
               onclick="event.preventDefault();
                        document.getElementById('logout-form').submit()">
              <i class="fas fa-sign-out-alt"></i> Выйти
            </a>
            
            <form id="logout-form"
                  action="{{ route('logout') }}"
                  method="POST">
              @csrf
            </form>
          </div>

        </li>
      @else
        <li class="nav-item {{ Route::currentRouteNamed('register') ? 'active' : '' }}">
          <a href="{{ route('register') }}" class="nav-link">Зарегистрироваться</a>
        </li>
        <li class="nav-item {{ Route::currentRouteNamed('login') ? 'active' : '' }}">
          <a href="{{ route('login') }}" class="nav-link">Войти</a>
        </li>
      @endif
      </ul>
      
    </div>
  </div>
</nav>