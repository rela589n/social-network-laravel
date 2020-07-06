<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm fixed-top">
<div class="container">
    @if ( Auth::check() )
      <a class="navbar-brand" href="{{ route('profile.index',
             ['username' => Auth::user()->username]) }}">Social</a>
    @else
      <a class="navbar-brand" href="{{ route('home') }}">Social</a>
    @endif
    <button class="navbar-toggler" type="button" data-toggle="collapse" 
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        @if ( Auth::check() )
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">Стена</a>
            </li>
            <li class="nav-item {{ Request::is('friends') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('friend.index') }}">Друзья</a>
            </li>
            <form method="GET" action="{{ route('search.results') }}" class="form-inline my-2 ml-2 my-lg-0">
              <input name="query" class="search mr-sm-2" type="search" 
                     placeholder="Поиск..." aria-label="Search">
              <button type="submit" class="btn btn-success btn-sm my-2 my-sm-0">Найти</button>
            </form>
        </ul>
        @endif
        <ul class="navbar-nav ml-auto">
        @if ( Auth::check() )
            <li class="nav-item dropdown {{ Request::is('user/' . Auth::user()->username) ? 'active' : '' }}">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                
                @if ( ! Auth::user()->avatar )
                  <img src="{{ Auth::user()->getAvatarUrl() }}"
                      width="40" height="40" class="rounded-circle">
                @else
                  <img src="{{ Auth::user()->getAvatarsPath(Auth::user()->id)
                             . Auth::user()->avatar }}"
                    width="40" height="40" class="rounded-circle">
                @endif

                {{ Auth::user()->getNameOrUsername() }}
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item"
                  href="{{ route('profile.index', ['username' => Auth::user()->username]) }}">Профиль</a>
                <a class="dropdown-item" href="{{ route('profile.edit') }}">Редактировать</a>
                <a href="{{ route('logout') }}" class="dropdown-item"
                    onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();"
                >Выйти</a>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
              </div>
            </li>
        @else
            <li class="nav-item {{ Request::is('register') ? 'active' : '' }}">
               <a href="{{ route('register') }}" class="nav-link">Зарегистрироваться</a>
            </li>
            <li class="nav-item {{ Request::is('login') ? 'active' : '' }}">
               <a href="{{ route('login') }}" class="nav-link">Войти</a>
            </li>
        @endif
        </ul>
    </div>
    </div>
</nav>