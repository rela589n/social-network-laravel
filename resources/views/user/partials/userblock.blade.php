<div class="media mb-2">

  <a href="{{ route('profile.index', ['username' => $user->username]) }}">
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

  <div class="d-flex align-items-center media-body">
    <a href="{{ route('profile.index', ['username' => $user->username]) }}"
       class="profile-link">
      {{ $user->getNameOrUsername() }}
    </a>
    @widget('verify', ['id' => $user->id])
 
    @if ($user->location)
       <p>{{ $user->location }}</p>
    @endif
  </div>

</div>