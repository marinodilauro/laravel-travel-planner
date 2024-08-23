@extends('layouts.app')

@section('title', 'Travel Page')

@section('styles')
  @vite('resources/scss/partials/views/travel.scss')
@endsection

@section('content')

  {{-- Travel image --}}
  <div class="travel_image">

    <div class="title_bar d-flex align-items-center w-100 px-3">

      <button class="back_btn me-3">
        <a class="text-decoration-none text-dark" href="{{ url()->previous() }}">
          <span class="material-symbols-outlined">
            arrow_back
          </span>
        </a>
      </button>

      <h2 class="fs-4 my-4 flex-fill">
        {{ $travel->name }}
      </h2>

    </div>

    @if ($travel->photo)
      <img loading="lazy" src="{{ asset('storage/' . $travel->photo) }}" alt="">
    @else
      <img loading="lazy" src="/storage/img/placeholder_image.png" alt="">
    @endif

    <div class="foreground"></div>

    {{-- Chips --}}
    <div class="chips">
      <div class="custom_badge">
        <span class="destination_icon material-symbols-outlined me-1">location_on</span>
        <span>{{ $travel->destination }}</span>
      </div>
      <div class="custom_badge">
        <span class="calendar_icon material-symbols-outlined me-1">today</span>
        <span>{{ $travel->start_date }} &bullet; {{ $travel->end_date }}</span>
      </div>
    </div>

  </div>

  {{-- Travel details --}}
  <div class="container">

    <div class="top_bar d-flex align-items-center py-4">

      <span class="title roboto-medium me-auto">Organizza il tuo viaggio</span>

      <button class="back_btn">
        <a class="text-decoration-none text-dark" href="{{ url()->previous() }}">
          <span class="material-symbols-outlined">
            map
          </span>
        </a>
      </button>
    </div>

    {{-- Accordion: Travel Info --}}
    <div class="accordion">

      <div class="accordion_item">

        <div class="accordion_header d-flex align-items-center">

          <span class="me-auto">Info sul viaggio</span>

          <span class="triangle_icon material-symbols-outlined">
            arrow_drop_down
          </span>

        </div>

        <div class="accordion_content">
          <p>{{ $travel->description }} Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam libero eum in,
            dolor deserunt sit a doloremque quo earum tempora laboriosam dolorem aliquid numquam autem omnis, neque
            explicabo corrupti exercitationem?</p>
        </div>

      </div>
    </div>

    @if ($duration > 7)
      <input type="hidden" id="duration" value="{{ $duration }}">

      <select id="week-selector">

      </select>
    @else
      <span class="days_title">Giorni</span>
    @endif

    {{-- Accordion: Week days --}}
    {{-- <div class="accordion">

      <div class="accordion_item">

        <div class="accordion_header d-flex align-items-center mb-2">

          <span class="me-auto">Seleziona la settimana</span>

          <span class="triangle_icon material-symbols-outlined">
            arrow_drop_down
          </span>

        </div>

        <div class="accordion_content">

          <input type="hidden" id="duration" value="{{ $duration }}">

          <select id="week-selector">
            <option value="1">Seleziona la settimana</option>
          </select>
        </div>

      </div>

    </div> --}}

    {{-- Week days --}}
    <div class="week_days row row-cols-4 g-2 mt-2">

      @for ($i = 0; $i < $duration; $i++)
        <div class="col">
          <div class="day_badge {{ $i == 0 ? 'selected' : '' }}" id="day-{{ $i + 1 }}">
            {{ date('d/m', strtotime($travel->start_date . ' + ' . $i . ' days')) }}
          </div>
        </div>
      @endfor

    </div>

    {{-- Day --}}
    <div>
      <div class="top_bar d-flex align-items-center py-4">

        <span id="day_label" class="me-auto"></span>

        <button class="btn btn_add_stage">
          <span class="material-symbols-outlined me-2">
            add
          </span>
          Add
        </button>

      </div>

      <form action="{{ route('user.travels.store') }}" method="post" class="w-100">
        @csrf

        <div class="input_wrapper mb-4 row">
          <label for="name" class="input_label">{{ __('Nome') }}</label>

          <div class="col-md-6">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
              value="{{ old('name') }}" required autocomplete="name" autofocus>

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
              name="destination" value="{{ old('destination') }}" required autocomplete="destination" autofocus>

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
                  value="{{ old('start_date') }}" required autocomplete="start_date" autofocus>

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
                  value="{{ old('end_date') }}" required autocomplete="new-end_date" autofocus>

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
            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
              autofocus>
            {{ old('description') }}
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
  </div>


@endsection

@section('scripts')
  @vite('resources/js/partials/accordion.js')
  @vite('resources/js/partials/day_badge.js')
  @vite('resources/js/partials/week_selector.js')
@endsection
