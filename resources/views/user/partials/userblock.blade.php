<div class="row">
  <div class="col-sm-2">
    <a href="{{ route('profile.index', ['username' => $user->username ]) }}">
      @if ( ! $user->avatar )
        <img src="{{ $user->getAvatarUrl() }}"
            class="avatar img-thumbnail rounded-circle mr-3"
            alt="{{ $user->getNameOrUsername() }}">
      @else
        <img src="{{ $user->getAvatarsPath($user->id) . $user->avatar }}"
            class="avatar img-thumbnail rounded-circle mr-3"
            alt="{{ $user->getNameOrUsername() }}">
      @endif
    </a>
  </div>

  <div class="col-sm-10">
    <div class="d-flex align-items-center media-body">
      <a href="{{ route('profile.index', ['username' => $user->username ]) }}"
        class="profile-link">
        {{ $user->getNameOrUsername() }}
      </a>

      @include('user.partials.verify', ['verify' => $user->verify ] )

    </div>

    @if ($user->location)
      <p>Откуда: {{ $user->location }}</p>
    @endif

  </div>
</div>