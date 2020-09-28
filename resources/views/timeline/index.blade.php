@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-8 content-main">
    <form method="POST" action="{{ route('wall.post') }}"
          class="needs-validation" novalidate>
      @csrf
        <div class="form-group">
            <textarea name="wall"
                      class="form-control{{ $errors->has('wall') ? ' is-invalid' : '' }}"
                      placeholder="Что нового {{ Auth::user()->getFirstNameOrUsername() }}?"
                      rows="3"></textarea>

            @if ($errors->has('wall'))
              <span class="invalid-feedback">
                {{ $errors->first('wall') }}
              </span>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">
                <i class="fas fa-plus"></i> Опубликовать
        </button>
    </form>

    <hr>

  </div>
</div>

<div class="row">
  <div class="col-lg-8 content-main">

  @if ( ! $walls->count() )
    <div class="alert alert-primary" role="alert">
      Пока нет ни одной записи на стене.
    </div>
  @else
    @foreach ($walls as $wall)
    <div class="media">
      <a class="mr-3" href="{{ route('profile.index',
                            ['username' => $wall->user->username]) }}">

         @include('user.partials.avatar', ['wall' => $wall->user])

      </a>
      <div class="media-body">

      @include('user.partials.username')

      <p>{{ $wall->body }}</p>
      <ul class="list-inline">
        @if ($wall->user->id !== Auth::user()->id)
          <li class="list-inline-item">
            <a href="{{ route('wall.like',
                     ['id' => $wall->id]) }}">Лайк</a>
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
                                  ['username' => $reply->user->username]) }}">

               @include('user.partials.avatar', ['wall' => $reply->user])

            </a>
            <div class="media-body">

            @include('user.partials.username')
            
            <p>{{ $reply->body }}</p>
            <ul class="list-inline">
              @if ($reply->user->id !== Auth::user()->id)
                <li class="list-inline-item">
                  <a href="{{ route('wall.like',
                           ['id' => $reply->id]) }}">Лайк</a>
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

      <form method="POST" action="{{ route('wall.reply',
                                  ['id' => $wall->id]) }}"
            class="mb-4"
            class="needs-validation" novalidate>
        @csrf
        <div class="form-group">
          <textarea name="reply-{{ $wall->id }}"
                    class="form-control{{ $errors->has("reply-{$wall->id}") ? ' is-invalid' : '' }}"
                    placeholder="Прокомментировать"
                    rows="3"></textarea>

          @if ($errors->has("reply-{$wall->id}"))
              <span class="invalid-feedback">
                {{ $errors->first("reply-{$wall->id}") }}
              </span>
          @endif
        </div>

        <button type="submit" class="btn btn-primary btn-sm">Написать</button>
      </form>

      </div>
    </div>
    @endforeach
    {{ $walls->links() }}
  @endif
  </div>
</div>
@endsection