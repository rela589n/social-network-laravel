<h3>Регистрация</h3>
<form method="POST" action="{{ route('register') }}"
      class="needs-validation" novalidate>
    @csrf

    <div class="form-group">
        <label for="register_email">Email <span class="required"></span></label>
        <input type="email"
               name="register_email" 
               class="form-control @error('register_email') is-invalid @enderror" 
               id="register_email"
               value="{{ old('register_email') }}"
               autofocus>

        @error('register_email')
            <span class="invalid-tooltip">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="register_username">Логин <span class="required"></span></label>
        <input type="text"
               name="register_username" 
               class="form-control @error('register_username') is-invalid @enderror"
               id="register_username"
               value="{{ old('register_username') }}">

        @error('register_username')
            <span class="invalid-tooltip">
                {{ $message }}
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="register_password">Пароль <span class="required"></span></label>
        <input type="password"
               name="register_password" 
               class="form-control @error('register_password') is-invalid @enderror" 
               id="register_password">
        
        @error('register_password')
            <span class="invalid-tooltip">
                {{ $message }}
            </span>
        @enderror
    </div>
    
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
</form>