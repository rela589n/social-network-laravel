@extends('layouts.app')

@section('content')
<div class="row content-main">
  <div class="col-lg-6">

    <h3>Результаты поиска: "{{ Request::input('query') }}"</h3>
    
    @if ( ! $users->count() )
      <p>Пользователь не найден<p>
    @else
      <div class="row">
        <div class="col-lg-12">
          @foreach ($users as $user)
            <div class="mb-2">

              @include('user.partials.userblock')

            </div>
          @endforeach
        </div>
      </div>
    @endif

  </div>
</div>
@endsection