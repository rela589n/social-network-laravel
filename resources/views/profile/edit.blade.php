@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-4 card card-body mx-auto">

    <h3>Редактировать</h3>
    <form method="POST" action="{{ route('profile.edit') }}" novalidate>
        @csrf

        <div class="form-group">
            <label for="first_name">Имя</label>
            <input type="text" name="first_name" 
                    class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" 
                    id="first_name"
                    value="{{ Request::old('first_name') ?: Auth::user()->first_name }}">

            @if ($errors->has('first_name'))
                <span class="help-block text-danger">
                  {{ $errors->first('first_name') }}
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="last_name">Фамилия</label>
            <input type="text" name="last_name" 
                    class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" 
                    id="last_name"
                    value="{{ Request::old('last_name') ?: Auth::user()->last_name }}">
            
            @if ($errors->has('last_name'))
                <span class="help-block text-danger">
                  {{ $errors->first('last_name') }}
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="location">Страна</label>
            <input type="text" name="location" 
                    class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}" 
                    id="location"
                    value="{{ Request::old('location') ?: Auth::user()->location }}">
            
            @if ($errors->has('location'))
                <span class="help-block text-danger">
                  {{ $errors->first('location') }}
                </span>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Обновить профиль</button>
    </form>

  </div>
</div>
@endsection