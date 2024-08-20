@extends('layouts.app')

@section('title', 'Login')

@section('styles')
  @vite('resources/scss/partials/views/register.scss')
@endsection

@section('content')
  <div class="container d-flex flex-column align-items-center">

    <h1 class="text-center roboto-bold">Login</h1>

    <div class="image_container">
      <img class="img-fluid" src="{{ asset('storage/img/hello.png') }}" alt="">
    </div>

    <form method="POST" action="{{ route('login') }}" class="w-100">
      @csrf

      <div class="input_wrapper mb-4 row">
        <label for="email" class="input_label">{{ __('E-mail') }}</label>

        <div class="col-md-6">
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ old('email') }}" required autocomplete="email" autofocus>

          @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="input_wrapper mb-4 row">
        <label for="password" class="input_label">{{ __('Password') }}</label>

        <div class="col-md-6">
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" value="{{ old('password') }}" required autocomplete="new-password" autofocus>

          @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="mb-4 row">
        <div class="col-md-6 offset-md-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember"
              {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label" for="remember">
              {{ __('Remember me') }}
            </label>
          </div>
        </div>
      </div>

      <div class="my-4 row">
        <div class="col-md-6 offset-md-4">
          <button type="submit" class="btn button_style btn_primary w-100">
            Register
          </button>
        </div>
      </div>
    </form>
  </div>
@endsection
