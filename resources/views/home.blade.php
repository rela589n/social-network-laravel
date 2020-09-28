@extends('layouts.app')

@section('content')
<div class="row">

  <div class="col-lg-6 mt-3 text-center">
    <h3 class="pt-4 text-primary font-weight-bold">
      {{ config('app.name') }} для мобильных устройств</h3>
    <p class="text-secondary">
      Установите официальное мобильное приложение и оставайтесь в курсе новостей Ваших друзей,
      где бы Вы ни находились.
    </p>
    <h5>Нас уже: {{ $count_reg_user }}</h5>
    
    <div class="apps-block">
      <div class="app-block">
        <a href="#android"
           target="_blank">
          <img class="phone" src="{{ asset('images/android.png') }}" alt="Android">
        </a>
        <a href="#android"
           target="_blank" class="btn-app">
          <i class="fab fa-android"></i> Android
        </a>
      </div>

      <div class="app-block">
        <a href="#iphone"
           target="_blank">
          <img class="phone" src="{{ asset('images/iphone.png') }}" alt="iPhone">
        </a>
        <a href="#iphone"
           target="_blank" class="btn-app">
          <i class="fab fa-apple"></i> iPhone
        </a>
      </div>
    </div>
  </div>

  <div class="offset-lg-2 col-lg-4 mt-3">
    <div class="row">
      <div class="card card-body">

        @include('auth.parts.form-login')

      </div>
    </div>

    <div class="row mt-3">
      <div class="card card-body">

        @include('auth.parts.form-register')

      </div>
    </div>
  </div>

</div>
@endsection