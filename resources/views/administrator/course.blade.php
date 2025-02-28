@extends('layouts.master_administrator')

@section('title', 'Home Page')

@section('content')

<section class="section main-section">
  <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="fa-solid fa-house"></i></span>
            Course Details
          </p>
        </header>
          <div class="card-content">
                <div class="field">
                  <label class="label">Title</label>
                  <div class="field-body">
                    <div class="field">
                      <div class="control">
                        <input type="text" autocomplete="on" name="title" value="{{ isset($course->title) ? $course->title : '' }}" class="input" disabled>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Category</label>
                  <div class="control">
                    <div class="select">
                      <input type="text" autocomplete="on" name="title" value="{{ isset($course->category->name) ? $course->category->name : '' }}" class="input" disabled>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Description</label>
                  <div class="field-body">
                    <div class="field">
                      <div class="control">
                        <textarea type="text" rows="4" cols="50" autocomplete="on" name="description" value="" class="input" disabled>
                       {{ isset($course->description) ? strip_tags($course->description) : '' }}
                        </textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Cost per Seat</label>
                  <div class="field-body">
                    <div class="field">
                      <div class="control">
                        <input type="text" autocomplete="on" name="price" value="{{ isset($course->price) ? $course->price : '' }}" class="input" disabled>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Course Level</label>
                    <div class="control">
                      <input type="text" autocomplete="on" name="level" value="{{ isset($course->level) ? $course->level : '' }}" class="input" disabled>
                    </div>
                </div>
          </div>
      </div>
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
              <input type="text" autocomplete="on" id="location_name" name="location_name" value="{{ isset($course->location->name) ? $course->location->name : '' }}" class="input" required disabled>
            </div>
          </div>
   
          <div class="field">
            <label class="label">Address</label>
            <div class="control">
            <input type="text" autocomplete="on" id="location_address" name="location_address" value="{{ isset($course->location->address) ? $course->location->address : '' }}" class="input" disabled>
            </div>
          </div>
     
          <div class="field">
            <label class="label">City</label>
            <div class="control">
            <input type="text" autocomplete="on" id="location_city"  name="location_city" value="{{ isset($course->location->city) ? $course->location->city : '' }}" class="input" disabled>
            </div>
          </div>
          <div class="field">
            <label class="label">Country</label>
            <div class="control">
            <input type="text" autocomplete="on" id="location_country" name="location_country" readonly value="NZ" class="input" disabled>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="fa-solid fa-location-dot"></i></span>
            Course Image Details
          </p>
        </header>
        <div class="card-content">
            @foreach(json_decode($course->photo_gallery,true) as $imges)
              <div class="image">
                <img src="{{$imges['path']}}">
              </div>
            @endforeach 
        </div>
      </div>

      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="fa-regular fa-calendar-days"></i></span>
            Date / Time Details
          </p>
        </header>
        <div class="card-content">
          <div class="field">
            <label class="label">Duration</label>
            <div class="control">
              <input type="text" autocomplete="on" name="duration" value="{{ isset($course->duration) ? $course->duration : '' }}" class="input" disabled>
            </div>
          </div>
          <div class="field">
            <label class="label">Duration Type</label>
            <div class="control">
              <input type="text" autocomplete="on" name="duration_type" value="{{ isset($course->duration_type) ? $course->duration_type : '' }}" class="input" disabled>
            </div>
          </div>
        <div class="field">
            <label class="label">Date and Time </label>
            <div class="control">
                <div id="fieldsUpdateContainer">
                    <ul>
                        @foreach($classdates as $dates)
                            <li>
                                <p><i class="fa-regular fa-calendar-days"></i>{{$dates->class_date}}</p>
                                <p><i class="fa-regular fa-clock"></i>{{$dates->start_at}}</p>
                                <p><i class="fa-solid fa-clock"></i>{{$dates->end_at}}</p>
                                <p><i class="fa-solid fa-chair"></i>{{$dates->max_capacity}}</p>
                            </li>
                        @endforeach    
                    </ul>
                </div>
            </div>
        </div>
        </div>
      </div>
    </div>
</section>


 
    
@endsection