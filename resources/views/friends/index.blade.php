@extends('layouts.app')

@section('content')
    <div class="row content-main">

        <div class="col-lg-6">
            <h3>Ваші друзі</h3>

            @if ( ! $friends->count() )
                <p>У вас немає друзів.</p>
            @else
                @foreach ($friends as $user)

                    @include('user.partials.userblock')

                @endforeach
            @endif
        </div>

        <div class="col-lg-6">
            <h3>Запити на дружбу</h3>

            @if ( ! $requests->count() )
                <p>У вас немає запитів на дружбу</p>
            @else
                @foreach ($requests as $user)

                    @include('user.partials.userblock')

                @endforeach
            @endif
        </div>

    </div>
@endsection
