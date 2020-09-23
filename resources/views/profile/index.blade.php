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

    @if ( ! $statuses->count() )
      <div class="alert alert-primary" role="alert">
        Пока нет ни одной записи на стене.
      </div>
    @else
      @foreach ($statuses as $status)
      <div class="media">
        <a class="mr-3" href="{{ route('profile.index',
                                 ['username' => $status->user->username ]) }}">

        @include('user.partials.avatar', ['wall' => $status->user])

        </a>

        <div class="media-body">

        @include('user.partials.username')

        <p>{{ $status->body }}</p>
        <ul class="list-inline">
          @if ( $status->user->id !== Auth::user()->id )
            <li class="list-inline-item">
              <a href="{{ route('status.like',
                      ['statusId' => $status->id ]) }}">Лайк</a>
            </li>
          @endif
          <li class="list-inline-item">
            <i class="far fa-heart"></i> {{ $status->likes->count() }}
          </li>
          <li class="list-inline-item">{{ $status->created_at->diffForHumans() }}</li>
        </ul>

        @foreach ($status->replies as $reply)
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
                  <a href="{{ route('status.like',
                              ['statusId' => $reply->id ]) }}">Лайк</a>
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

        @if ($authUserIsFriend || Auth::user()->id === $status->user->id)
          <form method="POST" action="{{ route('status.reply',
                                         ['statusId' => $status->id ]) }}"
                class="mb-4"
                class="needs-validation" novalidate>
          @csrf
            <div class="form-group">
              <textarea name="reply-{{ $status->id }}"
                        class="form-control{{ $errors->has("reply-{$status->id}") ? ' is-invalid' : '' }}"
                        placeholder="Прокомментировать" rows="3"></textarea>

              @if ($errors->has("reply-{$status->id}") )
                <span class="invalid-feedback">
                  {{ $errors->first("reply-{$status->id}") }}
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
      <p>В ожидании {{ $user->getFirstNameOrUsername() }} 
      подтверждения запроса в друзья.</p>
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