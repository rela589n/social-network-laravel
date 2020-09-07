@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center content-main0">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Восстановление доступа к странице</div>

        <div class="card-body">
          @if ( session('status') )
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif

          <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group row">
              <div class="col-md-4 text-md-right"></div>

              <div class="col-md-6">
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}"
                       required
                       autocomplete="email"
                       placeholder="Email"
                       autofocus>

                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  Восстановить пароль
                </button>
              </div>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
