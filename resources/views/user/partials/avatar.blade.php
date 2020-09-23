@if ( ! $wall->avatar )
    <img class="avatar-sm media-object img-thumbnail rounded-circle"
         src="{{ $wall->getAvatarUrl() }}"
         alt="{{ $wall->getNameOrUsername() }}">
@else
    <img src="{{ $wall->getAvatarsPath($wall->id)
               . $wall->avatar }}"
         class="avatar-sm media-object img-thumbnail rounded-circle"
         alt="{{ $wall->getNameOrUsername() }}">
@endif