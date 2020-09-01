<div class="d-flex align-items-center">
    <a href="{{ route('profile.index',
             ['username' => $status->user->username ]) }}"
       class="profile-link">
    {{ $status->user->getNameOrUsername() }}</a>
    
    @include('user.partials.verify', ['verify' => $status->user->verify] )
</div>