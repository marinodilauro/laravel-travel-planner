@extends('layouts.app')

@section('title', 'Travel Page')

@section('styles')
  @vite('resources/scss/partials/views/travel.scss')
@endsection

@section('content')

  <div class="container">
    <h1>Crea una nuova tappa per il viaggio: {{ $travel->name }}</h1>

    <form action="{{ route('user.stages.store', $travel->slug) }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="place" class="form-label">Nome della Tappa</label>
        <input type="text" class="form-control" id="place" name="place" value="{{ old('place') }}" required>
      </div>

      <button type="submit" class="btn btn-primary">Crea Tappa</button>
    </form>
  </div>


@endsection

@section('scripts')
  @vite('resources/js/partials/accordion.js')
  @vite('resources/js/partials/day_badge.js')
  @vite('resources/js/partials/week_selector.js')
@endsection
