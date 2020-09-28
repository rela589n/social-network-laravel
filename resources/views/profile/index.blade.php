@extends('layouts.app')

@section('content')
<div class="row content-main">

  <div class="col-lg-8">

    @include('user.partials.userblock')

    <hr>

    @if ( Auth::user()->id === $user->id )
    <form action="{{ route('profile.upload-avatar',
                     ['username' => Auth::user()->username ]) }}"
          enctype="multipart/form-data"
          class="my-4"
          method="POST">
      @csrf
        <label for="avatar">Загрузить аватар</label><br>
        <input type="file" name="avatar" id="avatar">
        <input type="submit" class="btn btn-primary" value="Загрузить">
    </form>
    @endif

    @if ( ! $walls->count() )
      <div class="alert alert-primary" role="alert">
        Пока нет ни одной записи на стене.
      </div>
    @else
      @foreach ($walls as $wall)
      <div class="media">
        <a class="mr-3" href="{{ route('profile.index',
                                 ['username' => $wall->user->username ]) }}">

        @include('user.partials.avatar', ['wall' => $wall->user])

        </a>

        <div class="media-body">

        @include('user.partials.username')

        <p>{{ $wall->body }}</p>
        <ul class="list-inline">
          @if ( $wall->user->id !== Auth::user()->id )
            <li class="list-inline-item">
              <a href="{{ route('wall.like',
                      ['id' => $wall->id ]) }}">Лайк</a>
            </li>
          @endif
          <li class="list-inline-item">
            <i class="far fa-heart"></i> {{ $wall->likes->count() }}
          </li>
          <li class="list-inline-item">{{ $wall->created_at->diffForHumans() }}</li>
        </ul>

        @foreach ($wall->replies as $reply)
          <div class="media">
            <a class="mr-3" href="{{ route('profile.index',
                                     ['username' => $reply->user->username ]) }}">

               @include('user.partials.avatar', ['wall' => $reply->user])

            </a>
            <div class="media-body">

            @include('user.partials.username')

            <p>{{ $reply->body }}</p>
            <ul class="list-inline">
              @if ($reply->user->id !== Auth::user()->id)
                <li class="list-inline-item">
                  <a href="{{ route('wall.like',
                              ['id' => $reply->id ]) }}">Лайк</a>
                </li>
              @endif
              <li class="list-inline-item">
                <i class="far fa-heart"></i> {{ $reply->likes->count() }}
              </li>
              <li class="list-inline-item">{{ $reply->created_at->diffForHumans() }}</li>
            </ul>

            </div>
          </div>
        @endforeach

        @if ($authUserIsFriend || Auth::user()->id === $wall->user->id)
          <form method="POST" action="{{ route('wall.reply',
                                         ['id' => $wall->id ]) }}"
                class="mb-4"
                class="needs-validation" novalidate>
          @csrf
            <div class="form-group">
              <textarea name="reply-{{ $wall->id }}"
                        class="form-control{{ $errors->has("reply-{$wall->id}") ? ' is-invalid' : '' }}"
                        placeholder="Прокомментировать" rows="3"></textarea>

              @if ($errors->has("reply-{$wall->id}") )
                <span class="invalid-feedback">
                  {{ $errors->first("reply-{$wall->id}") }}
                </span>
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

  <div class="col-lg-4">
    @if ( Auth::user()->hasFriendRequestPending($user) )
      <p>В ожидании подтверждения запроса в друзья.</p>
    @elseif ( Auth::user()->hasFriendRequestReceived($user) )
      <a href="{{ route('friend.accept', ['username' => $user->username ]) }}"
         class="btn btn-primary mb-2">Подтвердить дружбу</a>
    @elseif ( Auth::user()->isFriendWith($user) )
      {{ $user->getFirstNameOrUsername() }} у Вас в друзьях.

      <form action="{{ route('friend.delete',
                        ['username' => $user->username ]) }}"
        method="POST">
        @csrf
        <input type="submit"
               class="btn btn-primary my-2"
               value="Удалить из друзей">
      </form>
    @elseif ( Auth::user()->id !== $user->id )
      <a href="{{ route('friend.add',
                  ['username' => $user->username ]) }}"
         class="btn btn-primary mb-2">Добавить в друзья</a>
    @endif

    <h4>Друзья</h4>
    @if ( ! $user->friends()->count() )
      <p>У @name($user->getFirstNameOrUsername(),
                 $user->gender, 'родительный') нет друзей</p>
    @else
      @foreach ( $user->friends() as $user )

        @include('user.partials.userblock')

      @endforeach
    @endif
     
  </div>
</div>
@endsection