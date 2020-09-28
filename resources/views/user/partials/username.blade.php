<div class="d-flex align-items-center">
  <a href="{{ route('profile.index',
              ['username' => $wall->user->username ]) }}"
     class="profile-link">
  {{ $wall->user->getNameOrUsername() }}</a>
  
  @include('user.partials.verify', ['verify' => $wall->user->verify ] )
</div>