@extends('layouts.app')

@section('content')
<div class="row content-main">

  <div class="col-lg-6">
    <h3>Ваши друзья</h3>

    @if ( ! $friends->count() )
        <p>У вас нет друзей.</p>
    @else
        @foreach ($friends as $user)

          @include('user.partials.userblock')

        @endforeach
    @endif
  </div>

  <div class="col-lg-6">
    <h3>Запросы в друзья</h3>

    @if ( ! $requests->count() )
        <p>У вас нет запросов в друзья.</p>
    @else
        @foreach ($requests as $user)

          @include('user.partials.userblock')
          
        @endforeach
    @endif
  </div>

</div>
@endsection