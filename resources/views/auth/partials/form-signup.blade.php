<h3>Регистрация</h3>
<form method="POST" action="{{ route('auth.signup') }}" novalidate>
    @csrf

    <div class="form-group">
        <label for="email">Email <span class="required"></span></label>
        <input type="email" name="email" 
                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" 
                id="email" placeholder="Например user@gmail.com"
                value="{{ Request::old('email') ?: '' }}">

        @if ($errors->has('email'))
            <span class="help-block text-danger">
                {{ $errors->first('email') }}
            </span>
        @endif
    </div>

    <div class="form-group">
        <label for="username">Логин <span class="required"></span></label>
        <input type="text" name="username" 
                class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" 
                id="username" placeholder="Ваш никнэйм"
                value="{{ Request::old('username') ?: '' }}">

        @if ($errors->has('username'))
            <span class="help-block text-danger">
                {{ $errors->first('username') }}
            </span>
        @endif
    </div>

    <div class="form-group">
        <label for="password">Пароль <span class="required"></span></label>
        <input type="password" name="password" 
                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" 
                id="password" placeholder="Минимум 6 символов">
        
        @if ($errors->has('password'))
            <span class="help-block text-danger">
                {{ $errors->first('password') }}
            </span>
        @endif
    </div>
    
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
</form>