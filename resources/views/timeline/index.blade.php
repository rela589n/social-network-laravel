@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-8 content-main">
    <form method="POST" action="{{ route('status.post') }}"
          class="needs-validation" novalidate>
      @csrf
        <div class="form-group">
            <textarea name="status"
                      class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}"
                      placeholder="Что нового {{ Auth::user()->getFirstNameOrUsername() }}?"
                      rows="3"></textarea>

            @if ($errors->has('status'))
              <span class="invalid-feedback">
                {{ $errors->first('status') }}
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

  @if ( ! $statuses->count() )
    <div class="alert alert-primary" role="alert">
      Пока нет ни одной записи на стене.
    </div>
  @else
    @foreach ($statuses as $status)
    <div class="media">
      <a class="mr-3" href="{{ route('profile.index',
                            ['username' => $status->user->username]) }}">
         @include('user.partials.avatar')
      </a>
      <div class="media-body">

      @include('user.partials.username')

      <p>{{ $status->body }}</p>
      <ul class="list-inline">
        @if ($status->user->id !== Auth::user()->id)
          <li class="list-inline-item">
            <a href="{{ route('status.like',
                     ['statusId' => $status->id]) }}">Лайк</a>
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
                                  ['username' => $reply->user->username]) }}">
            <img class="media-object img-thumbnail rounded-circle"
                 src="{{ $reply->user->getAvatarUrl() }}"
                 alt="{{ $reply->user->getNameOrUsername() }}">
            </a>
            <div class="media-body">

            @include('user.partials.username')
            
            <p>{{ $reply->body }}</p>
            <ul class="list-inline">
              @if ($reply->user->id !== Auth::user()->id)
                <li class="list-inline-item">
                  <a href="{{ route('status.like',
                           ['statusId' => $reply->id]) }}">Лайк</a>
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

      <form method="POST" action="{{ route('status.reply',
                                  ['statusId' => $status->id]) }}"
            class="mb-4"
            class="needs-validation" novalidate>
        @csrf
        <div class="form-group">
          <textarea name="reply-{{ $status->id }}"
                    class="form-control{{ $errors->has("reply-{$status->id}") ? ' is-invalid' : '' }}"
                    placeholder="Прокомментировать"
                    rows="3"></textarea>

          @if ($errors->has("reply-{$status->id}"))
              <span class="invalid-feedback">
                {{ $errors->first("reply-{$status->id}") }}
              </span>
          @endif
        </div>

        <button type="submit" class="btn btn-primary btn-sm">Написать</button>
      </form>

      </div>
    </div>
    @endforeach
    {{ $statuses->links() }}
  @endif
  </div>
</div>
@endsection