@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-3">
                <div class="card">
                    <div class="card-header">Перевірте свою електронну пошту</div>

                    <div class="card-body">
                        @if ( session('resent') )
                            <div class="alert alert-success" role="alert">
                                На вашу адресу електронної пошти була відправлено нове посилання для підтвердження.
                            </div>
                        @endif

                        Перш ніж продовжити, перевірте свою електронну пошту на наявність посилання для підтвердження.
                        Якщо ви не отримали листа,
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                натисніть тут, щоб відправити повторно
                            </button>
                            .
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
