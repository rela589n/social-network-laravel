@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-4 card card-body mx-auto">
        @include('auth.partials.form-login')
    </div>
</div>
@endsection