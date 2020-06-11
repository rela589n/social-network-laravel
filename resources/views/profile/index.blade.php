@extends('templates.default')

@section('content')
<div class="row">

  <div class="col-lg-5">
     @include('user.partials.userblock')
  </div>

  <div class="col-lg-4 col-lg-offset-3">

     @if ( Auth::user()->hasFriendRequestPending($user) )
         <p>В ожидании {{ $user->getFirstNameOrUsername() }} 
         подтверждения запроса в друзья.</p>
     @elseif ( Auth::user()->hasFriendRequestReceived($user) )
         <a href="#" class="btn btn-primary mb-2">Подтвердить дружбу</a>
     @elseif ( Auth::user()->isFriendWith($user) )
         {{ $user->getFirstNameOrUsername() }} у Вас в друзьях.
     @else
         <a href="#" class="btn btn-primary mb-2">Добавить в друзья</a>
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