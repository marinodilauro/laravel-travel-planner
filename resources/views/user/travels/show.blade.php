@extends('layouts.app')

@section('title', 'Travel Page')

@section('styles')
  @vite('resources/scss/partials/views/travel.scss')
  @vite('resources/scss/partials/views/register.scss')
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
    <div class="accordion p-2">

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

    <input type="hidden" id="duration" value="{{ $duration }}">

    @if ($duration > 7)
      {{-- Selector: Week days --}}
      <div class="mb-3">
        <select class="form-select form-select-lg weekselector py-3" name="" id="">

        </select>
      </div>
    @else
      <span class="days_title">Giorni</span>
    @endif

    {{-- Week days --}}
    <div class="week_days row row-cols-4 g-2 mt-2">

      @for ($i = 0; $i < $duration; $i++)
        <div class="col">
          <div class="day_badge {{ $i == 0 ? 'selected' : '' }}" id="day-{{ $i + 1 }}"
            data_date="{{ date('d/m/y', strtotime($travel->start_date . ' + ' . $i . ' days')) }}">
            {{ date('d/m', strtotime($travel->start_date . ' + ' . $i . ' days')) }}
          </div>
        </div>
      @endfor

    </div>

    {{-- Day --}}
    <div>
      <div class="top_bar d-flex align-items-center pt-4">

        <span id="day_label" class="me-auto"></span>

        <button class="btn btn_add_stage">
          <span class="material-symbols-outlined me-2">
            add
          </span>
          Add
        </button>
      </div>


      {{-- Stage form --}}
      <form action="{{ route('user.stages.store', $travel->slug) }}" method="POST"
        class="add_stage_form w-100 d-none py-3">
        @csrf

        {{-- <input type="hidden" name="travel_id" value="{{ $travel->id }}"> --}}
        {{-- Campo nascosto per la data selezionata --}}
        <input type="hidden" name="day" id="day_input" value="">
        <!-- Valore di default: Giorno 1 -->

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



      {{-- Stage list --}}
      <div class="row row-cols-1 gap-3 py-3">
        @forelse ($travel->stages as $stage)
          <div class="col">
            <div class="stage_card" data_day="{{ $stage->day }}">

              <a class="d-flex text-decoration-none text-dark p-0 flex-fill"
                href="{{ route('user.stages.show', $stage) }}">
                {{-- Card image --}}
                <div class="card_image">
                  @if ($stage->photo)
                    <img class="img-fluid" loading="lazy" src="{{ asset('storage/' . $stage->photo) }}" alt="">
                  @else
                    <img class="img-fluid" loading="lazy" src="/storage/img/placeholder_image.png" alt="">
                  @endif
                </div>

                {{-- Card body --}}
                <div class="card_body d-flex flex-column justify-content-between py-2 px-3">
                  <span class="travel_name pb-2">
                    {{ $stage->place }}
                  </span>

                  <div class="d-flex flex-column gap-1">
                    <div class="roboto-regular d-flex justify-content-start align-items-center">
                      <span class="destination_icon material-symbols-outlined me-1">today</span>
                      <span class="text-secondary">{{ $stage->day }}</span>
                    </div>

                    <div class="roboto-regular d-flex justify-content-start align-items-center">
                      <p>{{ $stage->note }}</p>
                    </div>
                  </div>

                </div>
              </a>

              {{-- Card actions --}}
              <div class="card_actions align-self-start mt-4">
                <div class="dropdown d-flex  align-items-center justify-content-start gap-2 ps-2 p-1">

                  <span data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    class="actions_icon material-symbols-outlined">
                    more_vert
                  </span>

                  <ul class="dropdown-menu">

                    {{-- Edit action --}}
                    <li class="d-flex align-items-center ms-3">
                      <span class="material-symbols-outlined">
                        edit
                      </span>
                      <a class="dropdown-item" href="{{ url('profile') }}">{{ __('Modifica') }}</a>
                    </li>

                    {{-- Delete actions --}}

                    <li class="d-flex align-items-center ms-3">

                      <!-- Modal trigger button -->
                      <span class="material-symbols-outlined">
                        delete
                      </span>
                      <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalId-{{ $stage->id }}">
                        Elimina
                      </a>

                    </li>

                  </ul>

                  <!-- Modal Body -->
                  <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                  <div class="modal fade" id="modalId-{{ $stage->id }}" tabindex="-1" data-bs-backdrop="static"
                    data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId-{{ $stage->id }}"
                    aria-hidden="true">

                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                      <div class="modal-content align-items-center">

                        <div class="modal-header">
                          <h5 class="modal-title" id="modalTitleId-{{ $stage->id }}">
                            ⚠️ ATTENZIONE ⚠️
                            <br>
                            Azione irreversibile
                          </h5>
                        </div>

                        <div class="modal-body text-center">
                          Stai per eliminare "{{ $stage->place }}"
                          <br>
                          Sei Sicuro/a di voler eliminare questa tappa?
                        </div>

                        <div class="d-flex justify-content-end gap-3 p-3">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Chiudi
                          </button>

                          <form action="{{ route('user.stages.destroy', $stage) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn_red">
                              Conferma
                            </button>
                          </form>
                        </div>

                      </div>
                    </div>
                  </div>

                  <!-- Optional: Place to the bottom of scripts -->
                  <script>
                    const myModal = new bootstrap.Modal(
                      document.getElementById("modalId"),
                      options,
                    );
                  </script>
                </div>
              </div>

            </div>
          </div>
        @empty
          <div class="container py-5">
            <h4 class="text-center">Non hai aggiunto ancora nessuna tappa</h4>
          </div>
        @endforelse
      </div>
    </div>
  </div>


@endsection

@section('scripts')
  @vite('resources/js/partials/accordion.js')
  @vite('resources/js/partials/day_badge.js')
  @vite('resources/js/partials/week_selector.js')
  @vite('resources/js/partials/add_stage.js')
@endsection
