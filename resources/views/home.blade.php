@extends('templates.default')

@section('content')
<div class="row">
 
  <div class="col-lg-6">
    <h1>Social для мобильных устройств</h1>
    <p>Установите официальное мобильное приложение Social и оставайтесь в курсе новостей Ваших друзей, где бы Вы ни находились.</p>
    <img class="phone" src="{{ asset('images/phone.png') }}" alt="App mobile">
  </div>

  <div class="offset-lg-2 col-lg-4">
    <h3>Войти на сайт</h3>
    <form method="POST" action="{{ route('auth.signin') }}" novalidate>
      @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" 
                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" 
                    id="email" placeholder="например, user@gmail.com"
                    value="{{ Request::old('email') ?: '' }}">

            @if ($errors->has('email'))
                <span class="help-block text-danger">
                  {{ $errors->first('email') }}
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" name="password" 
                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" 
                    id="password" placeholder="минимум 6 символов">
            
            @if ($errors->has('password'))
                <span class="help-block text-danger">
                  {{ $errors->first('password') }}
                </span>
            @endif
        </div>

        <div class="custom-control custom-checkbox mb-3">
            <input name="remember" type="checkbox" class="custom-control-input" id="remember">
            <label class="custom-control-label" for="remember">Запомнить меня</label>
        </div>

        <button type="submit" class="btn btn-primary">Войти</button>
    </form>

    <h3 class="mt-3">Регистрация</h3>
    <form method="POST" action="{{ route('auth.signup') }}" novalidate>
      @csrf

        <div class="form-group">
            <label for="reg_email">Email</label>
            <input type="email" name="reg_email" 
                    class="form-control{{ $errors->has('reg_email') ? ' is-invalid' : '' }}" 
                    id="reg_email" placeholder="например, user@gmail.com"
                    value="{{ Request::old('reg_email') ?: '' }}">

            @if ($errors->has('reg_email'))
                <span class="help-block text-danger">
                  {{ $errors->first('reg_email') }}
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="reg_username">Логин</label>
            <input type="text" name="reg_username" 
                    class="form-control{{ $errors->has('reg_username') ? ' is-invalid' : '' }}" 
                    id="reg_username" placeholder="ваш никнэйм"
                    value="{{ Request::old('reg_username') ?: '' }}">

            @if ($errors->has('reg_username'))
                <span class="help-block text-danger">
                  {{ $errors->first('reg_username') }}
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="reg_password">Пароль</label>
            <input type="password" name="reg_password" 
                    class="form-control{{ $errors->has('reg_password') ? ' is-invalid' : '' }}" 
                    id="reg_password" placeholder="минимум 6 символов">
            
            @if ($errors->has('reg_password'))
                <span class="help-block text-danger">
                  {{ $errors->first('reg_password') }}
                </span>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Создать аккаунт</button>
    </form>
  </div>

</div>
@endsection