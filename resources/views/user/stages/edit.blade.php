@extends('layouts.app')

@section('title', 'Edit stage page')

@section('styles')
  @vite('resources/scss/partials/views/homepage.scss')
  @vite('resources/scss/partials/views/register.scss')
@endsection

@section('content')
  <div class="container mt-4">

    {{-- Title bar --}}
    <div class="title_bar d-flex justify-content-between align-items-center w-100">

      <button class="back_btn">
        <a class="text-decoration-none text-dark" href="{{ url()->previous() }}">
          <span class="material-symbols-outlined">
            arrow_back
          </span>
        </a>
      </button>

      <h2 class="fs-4 my-4 flex-fill text-center">
        Modifica tappa:
      </h2>

    </div>

    <h3>{{ $stage->place }}</h3>

    <form action="{{ route('user.stages.update', $stage) }}" method="post" class="add_stage_form w-100">
      @csrf
      @method('PUT')



      <div class="input_wrapper mb-1 row">
        <label for="place" class="input_label">{{ __('Tappa') }}</label>

        <div class="col-md-6">
          <input id="place" type="text" class="form-control @error('place') is-invalid @enderror" name="place"
            required autocomplete="place" autofocus placeholder="Inserisci il luogo"
            value="{{ old('place', $stage->place) }}">

          @error('place')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="input_wrapper mb-1 row">
        <label for="day" class="input_label">{{ __('Giorno') }}</label>

        <div class="col-md-6">
          <input id="day" type="date" min="2024-01-01T00:00" max="2030-12-31T23:59" step="1"
            class="form-control @error('day') is-invalid @enderror" name="day" required autocomplete="day" autofocus
            dayholder="Inserisci il luogo" value="{{ old('day', $stage->day) }}">

          @error('day')
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
          {{ old('note', $stage->note) }}
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


@section('scripts')
  @vite('resources/js/partials/day_badge.js')
@endsection
