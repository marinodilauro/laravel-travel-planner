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

        <span class="material-symbols-rounded">
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
          <span class="material-symbols-rounded">
            add
          </span>
        </a>
      </button>

    </div>

    {{-- Travel list --}}
    <div class="row justify-content-center">
      @forelse ($travels as $travel)
        <div class="col">
          <div class="card">
            <div class="card-header">{{ __('User Dashboard') }}</div>

            <div class="card-body">

            </div>
          </div>
        </div>
      @empty
        <div class="container d-flex flex-column align-items-center">
          <div class="image_container mt-3">
            <img class="img-fluid" src="{{ asset('storage/img/not_found.png') }}" alt="">
          </div>
          <span class="roboto-bold fs-1 text-center mb-3">No travel yet</span>
          <span class="roboto-regular text-center mb-5">Create a new tour for your magic travel!</span>
          <button class="btn button_style btn_primary w-100">
            <a class="text-decoration-none w-100" href="{{ route('user.travels.create') }}">Create new tour</a>
          </button>
        </div>
      @endforelse
    </div>



  </div>
@endsection
