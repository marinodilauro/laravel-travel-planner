@extends('layouts.app')

@section('title', 'Welcome Page')

@section('content')
  <div class="container d-flex flex-column align-items-center">
    <h1 class="text-center roboto-bold">Welcome!</h1>

    <div class="image_container">
      <img class="img-fluid" src="/storage/img/hello.png" alt="">
    </div>

    <div class="caption text-center roboto-medium p-3 mb-3">
      Benvenuto su Travelog, la soluzione ideale per organizzare i tuoi viaggi.
      Accedi o iscriviti per gestire facilmente i tuoi itinerari e pianificare ogni dettaglio con precisione ed
      efficienza.
    </div>

    <div class="d-flex flex-column align-items-center gap-3 flex-row-md w-100">

      <button class="btn button_style btn_primary w-100">
        <a class="text-decoration-none d-block w-100" href="{{ route('register') }}">Crea un account</a>
      </button>

      <button class="btn button_style btn_secondary w-100">
        <a class="text-decoration-none d-block w-100" href="{{ route('login') }}">Login</a>
      </button>

      <a class="link roboto-medium" href="#">Password dimenticata?</a>

    </div>
  </div>
@endsection
