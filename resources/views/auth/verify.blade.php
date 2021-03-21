@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Подтверждение почтового ящика</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                На Вашу электронную почту была отправлена новая ссылка для подтверждения.
                            </div>
                        @endif

                        Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения.
                        Если Вы не получили письмо, <a href="{{ route('verification.resend') }}">{{ __('нажмите здесь, чтобы запросить новую ссылку') }}</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
