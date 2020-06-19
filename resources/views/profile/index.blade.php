@extends('templates.default')

@section('content')
<div class="row">

  <div class="col-lg-5">
     @include('user.partials.userblock')
     <hr>

      @if ( ! $statuses->count() )
            <p>{{ $user->getFirstNameOrUsername() }} пока ничего не опубликовал.</p>
      @else
         @foreach ($statuses as $status)
         <div class="media">
            <a class="mr-3" href="{{ route('profile.index', ['username' => $status->user->username]) }}">
            <img class="media-object rounded" src="{{ $status->user->getAvatarUrl() }}"
               alt="{{ $status->user->getNameOrUsername() }}">
            </a>
            <div class="media-body">
            <h4>
            <a href="{{ route('profile.index', ['username' => $status->user->username]) }}">
            {{ $status->user->getNameOrUsername() }}</a>
            </h4>
            <p>{{ $status->body }}</p>
            <ul class="list-inline">
               <li class="list-inline-item">{{ $status->created_at->diffForHumans() }}</li>
               @if ( $status->user->id !== Auth::user()->id )
                  <li class="list-inline-item">
                     <a href="{{ route('status.like', ['statusId' => $status->id]) }}">Лайк</a>
                  </li>
               @endif
               <li class="list-inline-item">
                  {{ $status->likes->count() }} {{ Str::plural('like', $status->likes->count()) }}
               </li>
            </ul>

            @foreach ($status->replies as $reply)
               <div class="media">
                  <a class="mr-3" href="{{ route('profile.index', ['username' => $reply->user->username]) }}">
                  <img class="media-object rounded" src="{{ $reply->user->getAvatarUrl() }}"
                     alt="{{ $reply->user->getNameOrUsername() }}">
                  </a>
                  <div class="media-body">
                  <h4>
                  <a href="{{ route('profile.index', ['username' => $reply->user->username]) }}">
                  {{ $reply->user->getNameOrUsername() }}</a>
                  </h4>
                  <p>{{ $reply->body }}</p>
                  <ul class="list-inline">
                  <li class="list-inline-item">{{ $reply->created_at->diffForHumans() }}</li>
                  @if ( $reply->user->id !== Auth::user()->id )
                     <li class="list-inline-item">
                        <a href="{{ route('status.like', ['statusId' => $reply->id]) }}">Лайк</a>
                     </li>
                  @endif
                     <li class="list-inline-item">
                        {{ $reply->likes->count() }} {{ Str::plural('like', $reply->likes->count()) }}
                     </li>
                  </ul>

                  </div>
               </div>
            @endforeach

            @if ( $authUserIsFriend || Auth::user()->id === $status->user->id )
               <form method="POST" action="{{ route('status.reply', ['statusId' => $status->id]) }}"
                     class="mb-4">
               @csrf
               <div class="form-group">
                  <textarea name="reply-{{ $status->id }}"
                           class="form-control{{ $errors->has("reply-{$status->id}") ? ' is-invalid' : '' }}"
                        placeholder="Прокомментировать" rows="3"></textarea>
                  @if ($errors->has("reply-{$status->id}"))
                     <div class="invalid-feedback">
                        {{ $errors->first("reply-{$status->id}") }}
                     </div>
                  @endif
               </div>
               <button type="submit" class="btn btn-primary btn-sm">Написать</button>
               </form>
            @endif

            </div>
         </div>
         @endforeach

      @endif

  </div>

  <div class="col-lg-4 col-lg-offset-3">

     @if ( Auth::user()->hasFriendRequestPending($user) )
         <p>В ожидании {{ $user->getFirstNameOrUsername() }} 
         подтверждения запроса в друзья.</p>
     @elseif ( Auth::user()->hasFriendRequestReceived($user) )
         <a href="{{ route('friend.accept', ['username' => $user->username]) }}"
            class="btn btn-primary mb-2">Подтвердить дружбу</a>
     @elseif ( Auth::user()->isFriendWith($user) )
         {{ $user->getFirstNameOrUsername() }} у Вас в друзьях.

         <form action="{{ route('friend.delete', ['username' => $user->username]) }}"
               method="POST">
            @csrf
            <input type="submit" class="btn btn-primary my-2" value="Удалить из друзей">
         </form>
     @elseif ( Auth::user()->id !== $user->id )
         <a href="{{ route('friend.add', ['username' => $user->username]) }}"
            class="btn btn-primary mb-2">Добавить в друзья</a>
     @endif

     <h4>{{ $user->getFirstNameOrUsername() }} друзья</h4>

     @if ( ! $user->friends()->count() )
        <p>{{ $user->getFirstNameOrUsername() }} нет друзей</p>
     @else
        @foreach ($user->friends() as $user)
          @include('user.partials.userblock')
        @endforeach
     @endif

  </div>

</div>
@endsection