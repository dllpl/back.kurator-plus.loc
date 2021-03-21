@extends('layouts.auth')

@section('auth')
    <style>
        .bg-brand{
            background:linear-gradient(to top left, #F9826D, #FFB88C);
        }
        .text-brand h2{
            font-size: 36px;
            font-weight: 200;
            font-family: 'Source Sans Pro', sans-serif;
        }
        .text-brand p{
            text-align: left;
            font-size: 16px;
            width: 288px;
            margin-top: 26px;
            font-weight: 600;
            font-family: 'Source Sans Pro', sans-serif;
        }
        .btn.btn-brand {
            background:linear-gradient(to top left, #F9826D, #FFB88C);
            color:#fff;
        }
    </style>
    <div class="col-md-8">
        <div class="card-group">
            <div class="card">
                <div class="card-body pb-3 p-md-5">
                    <h1>Войти</h1>
                    <p class="text-muted">Войдите под своим аккаунтом</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="E-mail или ИНН" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                            @endif
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-lock"></i>
                            </span>
                            </div>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Пароль" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                            @endif
                        </div>
                        <div class="input-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    Запомнить меня
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4 text-center text-md-left">
                                <button type="submit" class="btn btn-brand px4">
                                    Вход
                                </button>
                            </div>
                            <div class="col-8 text-right"></div>
                        </div>
                    </form>
                </div>
                <div class="text-left card-footer d-lg-none">
                    Горячая линия: <a href="tel:+79872206307" class="text-black-50">8 987 220 63 07</a>
                </div>
            </div>
            <div class="card text-white bg-brand py-5 d-md-down-none">
                <div class="card-body text-center">
                    <div class="text-brand px-3 h-100">
                        <h2>Добро пожаловать</h2>
                        <p>Система сбора данных и формирования отчетности в сфере образования.</p>
                    </div>
                    <div class="text-left px-3">
                        Горячая линия: <a href="tel:+79872206307" class="text-white">8 987 220 63 07</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
