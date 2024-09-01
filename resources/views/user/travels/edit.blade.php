@extends('layouts.app')

@section('title', 'New travel')

@section('styles')
  @vite('resources/scss/partials/views/homepage.scss')
  @vite('resources/scss/partials/views/register.scss')
@endsection

@section('content')
  <div class="container d-flex flex-column">

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
        Modifica viaggio:
      </h2>

    </div>

    <h3>{{ $travel->name }}</h3>

    <form action="{{ route('user.travels.update', $travel) }}" method="post" class="w-100">
      @csrf
      @method('PUT')
      <div class="input_wrapper mb-4 row">
        <label for="name" class="input_label">{{ __('Nome') }}</label>

        <div class="col-md-6">
          <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
            value="{{ old('name', $travel->name) }}" required autocomplete="name" autofocus>

          @error('name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="input_wrapper mb-4 row">
        <label for="destination" class="input_label">{{ __('Destinazione') }}</label>

        <div class="col-md-6">
          <input id="destination" type="text" class="form-control @error('destination') is-invalid @enderror"
            name="destination" value="{{ old('destination', $travel->destination) }}" required autocomplete="destination"
            autofocus>

          @error('destination')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="row">

        <div class="col-6">
          <div class="input_wrapper mb-4 row">
            <label for="start_date" class="input_label">{{ __('Data inizio') }}</label>

            <div class="col-md-6">

              <input id="start_date" type="date" min="2024-01-01T00:00" max="2030-12-31T23:59" step="1"
                class="form-control @error('start_date') is-invalid @enderror" name="start_date"
                value="{{ old('start_date', $travel->start_date) }}" required autocomplete="start_date" autofocus>

              @error('start_date')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
        </div>

        <div class="col-6">
          <div class="input_wrapper mb-4 row">
            <label for="end_date" class="input_label">{{ __('Data fine') }}</label>

            <div class="col-md-6">
              <input id="end_date" type="date" min="2024-01-01T00:00" max="2030-12-31T23:59" step="1"
                class="form-control @error('end_date') is-invalid @enderror" name="end_date"
                value="{{ old('end_date', $travel->end_date) }}" required autocomplete="new-end_date" autofocus>

              @error('end_date')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
        </div>

      </div>

      <div class="input_wrapper mb-5 row">
        <label for="description" class="input_label">{{ __('Descrizione') }}</label>

        <div class="col-md-6">
          <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" autofocus>
            {{ old('description', $travel->description) }}
            </textarea>

          @error('description')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>

      <div class="my-4 row">
        <div class="col-md-6 offset-md-4">
          <button type="submit" class="btn button_style btn_primary w-100">
            Conferma
          </button>
        </div>
      </div>
    </form>
  </div>
@endsection
