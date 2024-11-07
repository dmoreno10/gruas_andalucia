@extends('layouts.auth')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-4">
                <img
                    src="{{ Vite::asset('resources/dist/img/logic-sistemas.png') }}"
                    alt="Logic Sistemas"
                    class="navbar-brand"
                    height="100"
                    width="100"
                />
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="text-center mb-4">Iniciar Sesión</h4>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <div class="d-flex justify-content-center mb-4">
                            <button type="submit" class="btn btn-primary me-2">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('¿Has olvidado tu contraseña?') }}
                                </a>
                            @endif
                        </div>
                    </form>

                    <hr class="my-4"> <!-- Línea horizontal -->

                    <div class="text-center" style="color: rgb(97, 79, 79);">
                        <p>¿Eres nuevo en Logic Sistemas?</p>
                        <a href="{{ route('users.create') }}" class="btn btn-outline-dark btn-sm">
                            Crear tu cuenta de Logic Sistemas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
