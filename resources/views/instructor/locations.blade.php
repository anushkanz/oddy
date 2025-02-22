@extends('layouts.master_instructor')

@section('title', 'Home Page')

@section('content')

<form method='post'  enctype='multipart/form-data'  action="{{ route('instructor.location.update') }}">
@csrf
<input type='hidden' name='task' value="create">
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
              <input type="text" autocomplete="on" name="location_name" value="" class="input" required>
            </div>
            <p class="help">Required. Course Location name</p>
          </div>
   
          <div class="field">
            <label class="label">Address</label>
            <div class="control">
            <input type="text" autocomplete="on" name="location_address" value="" class="input" required>
            </div>
            <p class="help">Required. Course address</p>
          </div>
     
          <div class="field">
            <label class="label">City</label>
            <div class="control">
            <input type="text" autocomplete="on" name="location_city" value="" class="input" required>
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
<div class="card has-table">  
<header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="fa-solid fa-house"></i></span>
          Locations
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <table id="locations">
          <thead>
          <tr>
            <th></th>
            <th>Name</th>
            <th>Address</th>
            <th>City</th>
            <th>Country</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          @php
            foreach($locations as $location){
          @endphp
            <tr>
              <td class="image-cell"></td>
              <td data-label="Name" class="--name">{{$location->name}}</td>
              <td data-label="Address" class="--title">{{$location->address}}</td>
              <td data-label="City" class="--category">{{$location->city}}</td>
              <td data-label="Country" class="--role">{{$location->country}}</td>
              <td class="actions-cell">
                <div class="buttons right nowrap">
                  <a href="{{ route('instructor.location',[$location->_id]) }}" class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                    <span class="icon"><i class="fa-regular fa-eye"></i></span>
                  </a>
                </div>
              </td>
            </tr>
          @php
            }
          @endphp
          </tbody>
        </table>
        
      </div>
    </div>
          </div>  
    <script type="text/javascript">

      $(function() {
          $('#locations').DataTable( {
              paging: true,
              responsive: true,
              pageLength: 10
          } );

      });

</script>

@endsection