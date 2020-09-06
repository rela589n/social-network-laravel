@extends('layouts.app')

@section('content')
<div class="row">
 
  <div class="col-lg-6 mt-3 text-center">
    <h1>{{ config('app.name') }} для мобильных устройств</h1>
    <p>Установите официальное мобильное приложение и оставайтесь в курсе новостей Ваших друзей,
    где бы Вы ни находились.</p>
    <h3>Нас уже: {{ $count_register_users }}</h3>
    
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
        @include('auth.partials.form-login')
      </div>
    </div>

    <div class="row mt-3">
      <div class="card card-body">
        @include('auth.partials.form-register')
      </div>
    </div>
  </div>

</div>
@endsection