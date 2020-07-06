@if ( ! $status->user->avatar )
    <img class="avatar-sm media-object img-thumbnail rounded-circle"
         src="{{ $status->user->getAvatarUrl() }}"
         alt="{{ $status->user->getNameOrUsername() }}">
@else
    <img src="{{ $status->user->getAvatarsPath($status->user->id)
               . $status->user->avatar }}"
         class="avatar-sm media-object img-thumbnail rounded-circle"
         alt="{{ $status->user->getNameOrUsername() }}">
@endif