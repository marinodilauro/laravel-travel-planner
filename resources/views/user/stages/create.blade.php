@extends('layouts.app')

@section('title', 'New stage')

@section('styles')
  @vite('resources/scss/partials/views/homepage.scss')
  @vite('resources/scss/partials/views/register.scss')
@endsection

@section('content')

  <div class="container">

    <h1>Crea una nuova tappa per il viaggio: {{ $travel->name }}</h1>

    {{-- Stage form --}}
    <form action="http://127.0.0.1:8000/user/travels/{{ $travel->slug }}/stages" method="POST"
      class="add_stage_form w-100 py-3">
      @csrf

      <div class="input_wrapper mb-1 row">
        <label for="place" class="input_label">{{ __('Tappa') }}</label>

        <div class="col-md-6">
          <input id="place" type="text" class="form-control @error('place') is-invalid @enderror" name="place"
            value="{{ old('place') }}" required autocomplete="place" autofocus>

          @error('place')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="input_wrapper mb-3 row">
        <label for="note" class="input_label">{{ __('Note') }}</label>

        <div class="col-md-6">
          <textarea id="note" name="note" class="form-control @error('note') is-invalid @enderror" autofocus>
            {{ old('note') }}
            </textarea>

          @error('note')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="d-flex align-items-center gap-3">

        <button type="submit" class="btn button_style btn_primary">
          Salva tappa
        </button>

        <button type="button" class="close_form_btn btn button_style btn_secondary">
          Elimina tappa
        </button>

      </div>
    </form>
  </div>
@endsection
