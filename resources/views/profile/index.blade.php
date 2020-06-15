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