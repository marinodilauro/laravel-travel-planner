@extends('layouts.app')

@section('title', 'Home Page')

@section('styles')
  @vite('resources/scss/partials/views/homepage.scss')
@endsection

@section('content')
  <div class="container">

    {{-- Title bar --}}
    <div class="title_bar d-flex justify-content-between align-items-center">

      <div class="dropdown d-flex align-items-center gap-2 ps-2 p-1">

        <span data-bs-toggle="dropdown" aria-expanded="false" class="account_icon material-symbols-outlined">
          account_circle
        </span>

        <ul class="dropdown-menu">

          <li class="d-flex align-items-center ms-3">
            <a class="dropdown-item" href="{{ url('profile') }}">{{ __('Edit profile') }}</a>
          </li>

          <li class="d-flex align-items-center ms-3">
            <i class="fa-solid fa-right-from-bracket fa-xs"></i>
            <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>

          </li>

        </ul>

      </div>

      <h2 class="fs-4 my-4 flex-fill text-center">
        {{ __('I miei viaggi') }}
      </h2>

      <button class="add_btn">
        <a class="text-decoration-none text-dark" href="{{ route('user.travels.create') }}">
          <span class="material-symbols-outlined">
            add
          </span>
        </a>
      </button>

    </div>
  </div>

  {{-- Travel list --}}

  <div class="row row-cols-1">
    @forelse ($travels as $travel)
      <div class="col">
        <div class="travel_card">

          <a class="d-flex gap-3 text-decoration-none text-dark p-0 flex-fill"
            href="{{ route('user.travels.show', $travel) }}">

            {{-- Card image --}}
            <div class="card_image">
              @if ($travel->photo)
                @if (Str::startsWith($travel->photo, 'http'))
                  <!-- Se la foto è un URL esterno -->
                  <img loading="lazy" class="travel_image" src="{{ $travel->photo }}" alt="{{ $travel->name }}">
                @else
                  <!-- Se la foto è un percorso locale -->
                  <img loading="lazy" class="travel_image" src="{{ asset('storage/' . $travel->photo) }}"
                    alt="{{ $travel->name }}">
                @endif
              @else
                <!-- Se non c'è alcuna foto -->
                <img loading="lazy" class="travel_image img-fluid" src="/storage/img/placeholder_image.png"
                  alt="{{ $travel->name }}">
              @endif
            </div>

            {{-- Card body --}}
            <div class="card_body d-flex flex-column justify-content-between flex-fill">
              <span class="travel_name">
                {{ $travel->name }}
              </span>

              <div class="d-flex flex-column gap-1">
                <div class="roboto-regular d-flex justify-content-start align-items-center">
                  <span class="destination_icon material-symbols-outlined me-1">location_on</span>
                  <span class="text-secondary">{{ $travel->destination }} </span>
                </div>

                <div class="roboto-regular d-flex justify-content-start align-items-center">
                  <span class="calendar_icon material-symbols-outlined me-1">today</span>
                  <span class="text-secondary">{{ date('d/m/y', strtotime($travel->start_date)) }} &bullet;
                    {{ date('d/m/y', strtotime($travel->end_date)) }}</span>
                  </span>
                </div>
              </div>

            </div>

          </a>

          {{-- Card actions --}}
          <div class="card_actions">

            <div class="dropdown d-flex align-items-center gap-2 ps-2 p-1">

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
                  <a class="dropdown-item" href="{{ route('user.travels.edit', $travel) }}">{{ __('Modifica') }}</a>
                </li>

                {{-- Delete action --}}
                <li class="d-flex align-items-center ms-3">

                  <!-- Modal trigger button -->
                  <span class="material-symbols-outlined">
                    delete
                  </span>
                  <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalId-{{ $travel->id }}">
                    Elimina
                  </a>

                </li>

              </ul>


              <!-- Modal Body -->
              <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
              <div class="modal fade" id="modalId-{{ $travel->id }}" tabindex="-1" data-bs-backdrop="static"
                data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId-{{ $travel->id }}"
                aria-hidden="true">

                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                  <div class="modal-content">

                    <div class="modal-header border-0">
                      <h5 class="modal-title" id="modalTitleId-{{ $travel->id }}">
                        Elimina itinerario
                      </h5>
                    </div>

                    <div class="modal-body p-0">
                      Stai per eliminare <strong>{{ $travel->name }}</strong>
                      <br>
                      Sei sicuro/a?
                    </div>

                    <div class="d-flex justify-content-end gap-3 p-3">
                      <form action="{{ route('user.travels.destroy', $travel) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn modal_btn">
                          Conferma
                        </button>
                      </form>

                      <button type="button" class="btn modal_btn" data-bs-dismiss="modal">
                        Chiudi
                      </button>
                    </div>

                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>
    @empty
      <div class="container">
        <div class="container d-flex flex-column align-items-center">
          <div class="image_container mt-3">
            <img class="img-fluid" src="{{ asset('storage/img/not_found.png') }}" alt="">
          </div>
          <span class="roboto-bold fs-1 text-center mb-3">Non hai creato ancora nessun viaggio</span>
          <span class="roboto-regular text-center mb-5">Cra un nuovo itinerario per il tuo fantastico vbiaggio!</span>
          <button class="btn button_style btn_primary w-100">
            <a class="text-decoration-none d-block w-100" href="{{ route('user.travels.create') }}">Crea nuovo
              itinerario</a>
          </button>
        </div>
      </div>
    @endforelse
  </div>

  {{-- Message --}}
  @include('partials.action-confirmation')



@endsection
