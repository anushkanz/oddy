@extends('layouts.master_instructor')

@section('title', 'Home Page')
@php dd($location->user_id) @endphp
@section('content') 

<form method='post'  enctype='multipart/form-data'  action="{{ route('instructor.location.update') }}">
@csrf
<input type='hidden' name='task' value="update">
<input type='hidden' name='user' value="{{$user->_id}}">
<section class="section main-section">
  <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="fa-solid fa-location-dot"></i></span>
            Location Details
          </p>
        </header>
        <div class="card-content">
          <div class="field">
            <label class="label">Location Name</label>
            <div class="control">
              <input type="text" autocomplete="on" name="location_name" value="{{ isset($location->name) ? $location->name : '' }}" class="input" required>
            </div>
            <p class="help">Required. Course Location name</p>
          </div>
   
          <div class="field">
            <label class="label">Address</label>
            <div class="control">
            <input type="text" autocomplete="on" name="location_address" value="{{ isset($location->address) ? $location->address : '' }}" class="input" required>
            </div>
            <p class="help">Required. Course address</p>
          </div>
     
          <div class="field">
            <label class="label">City</label>
            <div class="control">
            <input type="text" autocomplete="on" name="location_city" value="{{ isset($location->city) ? $location->city : '' }}" class="input" required>
            </div>
            <p class="help">Required. Course City</p>
          </div>
          <div class="field">
            <label class="label">Country</label>
            <div class="control">
            <input type="text" autocomplete="on" name="location_country" readonly value="NZ" class="input" required>
            </div>
            <p class="help">Required. Course country</p>
          </div>
        </div>
      </div>
</section>
</form>


@endsection