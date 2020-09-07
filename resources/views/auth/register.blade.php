@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-4 mt-3 card card-body mx-auto">
    @include('auth.parts.form-register')
  </div>
</div>
@endsection