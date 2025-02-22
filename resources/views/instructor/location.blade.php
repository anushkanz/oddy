@extends('layouts.master_instructor')

@section('title', 'Home Page')

@section('content') 

<form method='post'  enctype='multipart/form-data'  action="{{ route('instructor.location.update') }}">
@csrf
<input type='hidden' name='task' value="update">
<input type='hidden' name='user' value="{{$user->_id}}">
<input type='hidden' name='id' value="{{ isset($location->_id) ? $location->_id : '' }}">
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
          <hr>
          <div class="field">
            <div class="control">
              <button type="submit" class="button green">
                Submit
              </button>
            </div>
          </div>
          <hr>
          <!--Display error/success/warnning-->
          @if(session('error-location'))
            <div class="notification red">
              <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                <div>
                  <span class="icon"><i class="fa-solid fa-circle-exclamation"></i></span>
                  <b> {{session('error-location')}}</b>
                </div>
                <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
              </div>
            </div>
          @endif
          @if(session('success-location'))
            <div class="notification green">
              <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                <div>
                  <span class="icon"><i class="fa-solid fa-check"></i></span>
                  <b> {{session('success-location')}}</b>
                </div>
                <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
              </div>
            </div>
          @endif
        </div>
      </div>
</section>
</form>


@endsection