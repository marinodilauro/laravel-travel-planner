@extends('layouts.app')

@section('title', 'Register')

@section('styles')
  @vite('resources/scss/partials/views/register.scss')
@endsection

@section('content')
  <div class="container d-flex flex-column align-items-center">

    <h1 class="text-center roboto-bold">Login</h1>

    <div class="image_container">
      <img class="img-fluid" src="{{ asset('storage/img/hello.png') }}" alt="">
    </div>

    <form method="POST" action="{{ route('register') }}" class="w-100">
      @csrf

      <div class="input_wrapper mb-4 row">
        <label for="first_name" class="input_label">{{ __('First name') }}</label>

        <div class="col-md-6">
          <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
            name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

          @error('first_name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="input_wrapper mb-4 row">
        <label for="last_name" class="input_label">{{ __('Last name') }}</label>

        <div class="col-md-6">
          <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
            name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

          @error('last_name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

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

      <div class="input_wrapper mb-5 row">
        <label for="password-confirm" class="input_label">{{ __('Confirm Password') }}</label>

        <div class="col-md-6">
          <input id="password-confirm" type="password"
            class="form-control @error('password-confirm') is-invalid @enderror" name="password_confirmation"
            value="{{ old('password-confirm') }}" required autocomplete="new-password" autofocus>

          @error('password-confirm')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
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
