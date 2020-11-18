@extends('layouts.app')

@section('content')
<div class="row content-main0">
  <div class="col-lg-6 card card-body mx-auto">

    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="home-tab"
          data-toggle="tab" href="#home" role="tab"
          aria-controls="home" aria-selected="true">Основне</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="profile-tab"
          data-toggle="tab" href="#profile" role="tab"
          aria-controls="profile" aria-selected="false">Про мене</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="contact-tab"
          data-toggle="tab" href="#contact" role="tab"
          aria-controls="contact" aria-selected="false">Контакти</a>
      </li>
    </ul>

    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="home"
           role="tabpanel" aria-labelledby="home-tab">

          <form method="POST" action="{{ route('profile.edit') }}"
                class="needs-validation" novalidate>
            @csrf
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                    <input type="text"
                           name="first_name"
                           class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                           placeholder="Ім'я"
                           value="{{ Request::old('first_name') ?: Auth::user()->first_name }}">

                    @if ( $errors->has('first_name') )
                      <span class="invalid-feedback">
                        {{ $errors->first('first_name') }}
                      </span>
                    @endif
                </div>

                <div class="form-group">
                    <input type="text"
                           name="last_name"
                           class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                           placeholder="Фамілія"
                           value="{{ Request::old('last_name') ?: Auth::user()->last_name }}">

                    @if ( $errors->has('last_name') )
                      <span class="invalid-feedback">
                        {{ $errors->first('last_name') }}
                      </span>
                    @endif
                </div>

                <div class="form-group">
                    <input type="text"
                           name="location"
                           class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}"
                           placeholder="Звідки"
                           value="{{ Request::old('location') ?: Auth::user()->location }}">

                    @if ( $errors->has('location') )
                      <span class="invalid-feedback">
                        {{ $errors->first('location') }}
                      </span>
                    @endif
                </div>

              </div>

              <div class="col-sm-6">
                <div class="form-group">
                  <select name="gender"
                          class="custom-select @error('gender') is-invalid @enderror">
                    <option value="">Ваша стать</option>
                    <option value="m" {{ Auth::user()->gender === 'm' ? 'selected' : '' }}>Чоловік</option>
                    <option value="f" {{ Auth::user()->gender === 'f' ? 'selected' : '' }}>Жінка</option>
                  </select>
                </div>
              </div>

            </div>

            <button type="submit" class="btn btn-primary">Оновити профіль</button>
          </form>
      </div>

      <div class="tab-pane fade" id="profile"
           role="tabpanel" aria-labelledby="profile-tab">
      Про мене</div>

      <div class="tab-pane fade" id="contact"
           role="tabpanel" aria-labelledby="contact-tab">
      Контакти</div>

    </div>

  </div>
</div>
@endsection
