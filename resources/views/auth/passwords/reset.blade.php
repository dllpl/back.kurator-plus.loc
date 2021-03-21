@extends('layouts.auth')

@section('auth')
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4">
                <h1>Сбросить пароль</h1>
                <p class="text-muted">Здесь вы пожете восстановить пароль</p>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>

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
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"  placeholder="{{ __('Password') }}" name="Пароль" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="icon-lock"></i>
                        </span>
                        </div>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Подтверждение пароля" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Изменить пароль
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
