<h3>Войти на сайт</h3>
<form method="POST" action="{{ route('login') }}" novalidate>
    @csrf

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" 
            class="form-control @error('email') is-invalid @enderror" 
            id="email"
            value="{{ old('email') }}" autofocus>

        @error('email')
            <span class="help-block text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Пароль</label>
        <input type="password" name="password" 
            class="form-control @error('password') is-invalid @enderror" 
            id="password">
        
        @error('password')
            <span class="help-block text-danger">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="custom-control custom-checkbox mb-3">
        <input name="remember" type="checkbox"
               class="custom-control-input" id="remember"
               {{ old('remember') ? 'checked' : '' }}
        >
        <label class="custom-control-label" for="remember">Запомнить меня</label>
    </div>
    
    <button type="submit" class="btn btn-primary">Войти</button>

    @if (Route::has('password.request'))
        <a class="btn btn-link" href="{{ route('password.request') }}">
            Забыли пароль?
        </a>
    @endif
</form>