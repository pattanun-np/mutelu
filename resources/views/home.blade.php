@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container">
        @livewire('sacred-places-list')
    </div>
@endsection

<style>
/* Airbnb-style CSS */
.filters-bar {
  position: sticky;
  top: 0;
  background-color: white;
  padding: 16px 0;
  border-bottom: 1px solid #EBEBEB;
  z-index: 10;
  display: flex;
  overflow-x: auto;
  gap: 12px;
  scrollbar-width: none;
}

.filters-bar::-webkit-scrollbar {
  display: none;
}

.filter-pill {
  background-color: #f7f7f7;
  border: 1px solid #EBEBEB;
  border-radius: 30px;
  padding: 8px 16px;
  font-size: 14px;
  white-space: nowrap;
  cursor: pointer;
  transition: all 0.2s;
}

.filter-pill:hover {
  background-color: #DDDDDD;
}

.sacred-places-grid {
  display: grid;
  grid-template-columns: repeat(1, 1fr);
  gap: 24px;
  padding: 24px 0;
}

@media (min-width: 550px) {
  .sacred-places-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 950px) {
  .sacred-places-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (min-width: 1200px) {
  .sacred-places-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

/* Ensure grid items are the same height */
.sacred-places-grid > * {
  height: 100%;
}

.place-card-wrapper {
  height: 100%;
}

.place-card {
  border-radius: 12px;
  overflow: hidden;
  transition: transform 0.2s;
  height: 100%;
  display: flex;
  flex-direction: column;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.place-card a {
  display: flex;
  flex-direction: column;
  height: 100%;
  text-decoration: none;
}

.place-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.place-image-container {
  position: relative;
  padding-top: 66.67%; /* 3:2 aspect ratio */
  overflow: hidden;
  border-radius: 12px 12px 0 0;
  width: 100%;
}

.place-image {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s;
}

.place-card:hover .place-image {
  transform: scale(1.05);
}

.place-info {
  padding: 16px;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  background-color: white;
}

.place-name {
  font-weight: 600;
  font-size: 16px;
  margin: 0 0 4px 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  color: #484848;
}

.place-location {
  color: #717171;
  margin: 0 0 8px 0;
  font-size: 14px;
}

.place-description {
  color: #717171;
  margin: 0;
  font-size: 14px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.loading-indicator {
  text-align: center;
  padding: 20px;
  font-size: 14px;
  color: #717171;
}
</style>

{{-- Removed JavaScript-based infinite scroll since we're using Livewire --}}
{{--
@push('scripts')
    <script src="{{ asset('js/airbnb-scroll.js') }}"></script>
@endpush
--}}