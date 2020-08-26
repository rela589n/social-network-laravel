@extends('layouts.app')

@section('content')
<div class="row">
 
  <div class="col-lg-6">
    <h1>Social для мобильных устройств</h1>
    <p>Установите официальное мобильное приложение Social и оставайтесь в курсе новостей Ваших друзей,
    где бы Вы ни находились.</p>
    <h3>Зарегистрированно: {{ $count_register_users }}</h3>
    
    <img class="phone" src="{{ asset('images/phone.png') }}" alt="App mobile">
  </div>

  <div class="offset-lg-2 col-lg-4">
    @include('auth.partials.form-login')
    <div class="mb-3"></div>
    @include('auth.partials.form-register')
  </div>

</div>
@endsection