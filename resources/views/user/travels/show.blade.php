@extends('layouts.app')

@section('title', 'Travel Page')

@section('styles')
  @vite('resources/scss/partials/views/travel.scss')
@endsection

@section('content')
  {{-- Travel image --}}
  <div class="travel_image">
    @if ($travel->photo)
      <img loading="lazy" src="{{ asset('storage/' . $travel->photo) }}" alt="">
    @else
      <img loading="lazy" src="/storage/img/placeholder_image.png" alt="">
    @endif
    <div class="foreground"></div>
    <div class="travel_details">
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
@endsection
