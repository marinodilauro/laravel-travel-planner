@extends('layouts.app')

@section('title', 'New travel')

@section('styles')
  @vite('resources/scss/partials/views/welcome.scss')
@endsection

@section('content')
  <div class="container d-flex flex-column align-items-center">
    <h1 class="text-center roboto-bold">Welcome!</h1>

    <div class="image_container">
      <img class="img-fluid" src="{{ asset('storage/img/hello.png') }}" alt="">
    </div>

    <div class="caption text-center roboto-medium p-3 mb-3">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit, dolores illum et debitis deserunt eius ut, enim
      mollitia
      natus fuga doloremque unde fugit earum repellat ratione quisquam tempora? Incidunt, dolorum.
    </div>

    <div class="d-flex flex-column align-items-center gap-3 flex-row-md w-100">

      <button class="btn button_style btn_primary w-100">
        <a class="text-decoration-none" href="{{ route('register') }}">Create an account</a>
      </button>

      <button class="btn button_style btn_secondary w-100">
        <a class="text-decoration-none" href="{{ route('login') }}">Login</a>
      </button>

      <a class="link roboto-medium" href="#">Forgot password?</a>

    </div>
  </div>
@endsection
