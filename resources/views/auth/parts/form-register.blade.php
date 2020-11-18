<div class="text-center mb-2">
  <h3>Вперше {{ config('app.name') }}?</h3>
  <h6 class="text-secondary">Миттєва реєстрація</h6>
</div>

<form method="POST" action="{{ route('register') }}"
      class="needs-validation mb-4" novalidate>
  @csrf

  <div class="form-group">
    <input type="email"
           name="register_email"
           class="form-control @error('register_email') is-invalid @enderror"
           placeholder="Email"
           value="{{ old('register_email') }}"
           autofocus>

    @error('register_email')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-group">
    <input type="text"
           name="register_username"
           class="form-control @error('register_username') is-invalid @enderror"
           placeholder="Логін"
           value="{{ old('register_username') }}">

    @error('register_username')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-group">
    <input type="password"
           name="register_password"
           class="form-control @error('register_password') is-invalid @enderror"
           placeholder="Пароль">

    @error('register_password')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
    @enderror
  </div>

  <div class="form-group">
    <div class="row col-md-7">
      <select name="gender"
              class="custom-select @error('gender') is-invalid @enderror">
        <option value="">Ваша стать</option>
        <option value="m" {{ old('gender') === 'm' ? 'selected' : '' }}>Чоловік</option>
        <option value="f" {{ old('gender') === 'f' ? 'selected' : '' }}>Жінка</option>
      </select>
    </div>
  </div>

  <button type="submit" class="btn btn-primary btn-block">Зареєструватись</button>
</form>
