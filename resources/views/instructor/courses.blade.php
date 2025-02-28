@extends('layouts.master_instructor')

@section('title', 'Home Page')

@section('content')

<form method='post'  enctype='multipart/form-data'  action="{{ route('instructor.course.update') }}">
@csrf
<input type='hidden' name='task' value="create">
<input type='hidden' name='user' value="{{$user->_id}}">
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
                        <input type="text" autocomplete="on" name="title" value="" class="input" required>
                      </div>
                      <p class="help">Required. Course title</p>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Category</label>
                  <div class="control">
                    <div class="select">
                      <select name="category">
                        @foreach($categories as $category)
                          <option value="{{$category->_id}}">{{$category->name}}</option>
                        @endforeach  
                      </select>
                      <p class="help">Required. Course category</p>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Description</label>
                  <div class="field-body">
                    <div class="field">
                      <div class="control">
                        <textarea rows="4" cols="50" type="text" autocomplete="on" name="description" value="" class="input" required></textarea>
                      </div>
                      <p class="help">Required. Course description</p>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Cost per Seat</label>
                  <div class="field-body">
                    <div class="field">
                      <div class="control">
                        <input type="text" autocomplete="on" name="price" value="" class="input" required>
                      </div>
                      <p class="help">Required. Course cost per seat</p>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Course Level</label>
                  <div class="control">
                    <div class="select">
                      <select name="course_level">
                          <option value="beginner">Beginner</option>
                          <option value="intermediate">Intermediate</option>
                          <option value="advance">Advance</option>
                      </select>
                      <p class="help">Required. Course category</p>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Course Images</label>
                  <div class="field-body">
                    <div class="field file">
                      <label class="upload control">
                        <a class="button blue">
                          Upload
                        </a>
                        <input type="file" name="file_upload[]" multiple>
                      </label>
                    </div>
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
            <label class="label">Location Selection</label>
            <div class="control">
              <div class="select">
                <select name="location_selected"  id="location_selected">
                  <option value="select_address">Select Location</option>
                  <option value="create_new">Create new Location</option>
                  @foreach($locations as $location)
                    <option value="{{$location->_id}}">{{$location->name}}</option>
                  @endforeach  
                </select>
                <p class="help">You can select previous location</p>
              </div>
            </div>
          </div>
          
          <div class="field">
          <input type="hidden" id="selected_location" name="selected_location" value="">
            <label class="label">Location Name</label>
            <div class="control">
              <input type="text" autocomplete="on" id="location_name" name="location_name" value="" class="input" >
            </div>
            <p class="help">Required. Course Location name</p>
          </div>
   
          <div class="field">
            <label class="label">Address</label>
            <div class="control">
            <input type="text" autocomplete="on" id="location_address" name="location_address" value="" class="input" >
            </div>
            <p class="help">Required. Course address</p>
          </div>
     
          <div class="field">
            <label class="label">City</label>
            <div class="control">
            <input type="text" autocomplete="on" id="location_city" name="location_city" value="" class="input" >
            </div>
            <p class="help">Required. Course City</p>
          </div>
          <div class="field">
            <label class="label">Country</label>
            <div class="control">
            <input type="text" autocomplete="on" id="location_country" name="location_country" readonly value="NZ" class="input" >
            </div>
            <p class="help">Required. Course country</p>
          </div>

          
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
              <input type="text" autocomplete="on" name="duration" value="" class="input" required>
            </div>
            <p class="help">Required. Course Duration</p>
          </div>
          <div class="field">
            <label class="label">Duration Type</label>
            <div class="control">
              <div class="select">
                <select name="duration_type">
                  <option value="hours">Hours</option>
                  <option value="days">Days</option>
                  <option value="weeks">Weeks</option>
                </select>
                <p class="help">Required. Course Duration Type</p>
              </div>
            </div>
          </div>
          <div class="field">
            <label class="label">Date and Time </label>
            <div class="control">
              <div id="fieldsContainer">
                  <!-- Dynamic fields will be added here -->
              </div>
              <button type="button" class="button blue" id="addFieldBtn">Add Date & Time</button>
            </div>
            <p class="help">Required. Course date and time</p>
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
          @if(session('error-course'))
            <div class="notification red">
              <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                <div>
                  <span class="icon"><i class="fa-solid fa-circle-exclamation"></i></span>
                  <b> {{session('error-course')}}</b>
                </div>
                <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
              </div>
            </div>
          @endif
          @if(session('success-course'))
            <div class="notification green">
              <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                <div>
                  <span class="icon"><i class="fa-solid fa-check"></i></span>
                  <b> {{session('success-course')}}</b>
                </div>
                <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
              </div>
            </div>
          @endif

        </div>
      </div>
    </div>
</section>
</form>
<div class="card has-table">  
<header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="fa-solid fa-house"></i></span>
          Courses
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <table id="courses">
          <thead>
          <tr>
            <th></th>
            <th>Instructor</th>
            <th>Title</th>
            <th>Category</th>
            <th>Price</th>
            <th>Level</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          @php
            foreach($courses as $course){
          @endphp
            <tr>
              <td class="image-cell"></td>
              <td data-label="Name" class="--name">{{$course->instructor->name}}</td>
              <td data-label="Title" class="--title">{{$course->title}}</td>
              <td data-label="Category" class="--category">{{$course->category->name}}</td>
              <td data-label="Price" class="--role">{{$course->price}}</td>
              <td data-label="level" class="--role">{{$course->level}}</td>
              <td class="actions-cell">
                <div class="buttons right nowrap">
                  <a href="{{ route('instructor.course',[$course->_id]) }}" class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
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
          $('#courses').DataTable( {
              paging: true,
              responsive: true,
              pageLength: 10
          } );
          
          $("#addFieldBtn").click(function () {
                let fieldHtml = `
                    <div class="field-container">
                        <input type="date" name="dates[]"  class="input" style="width: 20%;" required>
                        <input type="time" name="start_times[]"  class="input" style="width: 20%;" required>
                        <input type="time" name="end_times[]"  class="input" style="width: 20%;" required>
                        <input type="number" name="max_capacity[]"  class="input" style="width: 20%;" required>
                        <button type="button" class="remove-btn button red">Remove</button>
                    </div>
                `;
                $("#fieldsContainer").append(fieldHtml);
            });

            $(document).on("click", ".remove-btn", function () {
                $(this).parent().remove();
            });

            //Location selecting
            $("#location_selected").change(function () {
                let selectedValue = $(this).val();  // Get selected dropdown value
                console.log(selectedValue);
                if( selectedValue == 'create_new'){
                    $("#location_name").prop("required", true);
                    $("#location_address").prop("required", true);
                    $("#location_city").prop("required", true);
                    
                    
                    $("#location_name").val("");
                    $("#location_address").val("");
                    $("#location_city").val("");
                    

                    $("#location_name").prop("readonly", false);
                    $("#location_address").prop("readonly", false);
                    $("#location_city").prop("readonly", false);

                }else if( (selectedValue != 'select_address') && (selectedValue != 'create_new') ){
                    $.ajax({
                        url: "{{ route('instructor.location.ajax') }}",
                        type: "POST",
                        data: { 
                            "location_id": selectedValue,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            console.log(response);
                            // Assuming response is { "name": "John Doe", "email": "john@example.com" }
                            $("#location_name").val(response.data.name).prop("readonly", true);
                            $("#location_address").val(response.data.address).prop("readonly", true);
                            $("#location_city").val(response.data.city).prop("readonly", true);
                            $("#location_country").val(response.data.country).prop("readonly", true);
                        },
                        error: function () {
                            alert("Error fetching data");
                        }
                    });
                    let href = "/instructor/location/"+selectedValue;
                    $("#edit_address").attr("href", href);
                    $("#edit_address").html('Update Location');  
                    $("#edit_address").prop('disabled', false);

                    //Set selected location id
                    $("#selected_location").val(selectedValue);
                }else{
                    $("#edit_address").prop('disabled', true);
                }
            });

      });

</script>

@endsection