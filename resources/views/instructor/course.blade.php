@extends('layouts.master_instructor')

@section('title', 'Home Page')

@section('content')

<form method='post'  enctype='multipart/form-data'  action="{{ route('instructor.course.update') }}">
@csrf
<input type='hidden' name='task' value="update">
<input type='hidden' name='user' value="{{$user->_id}}">
<input type='hidden' name='id' value="{{$course->id}}">
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
                        <input type="text" autocomplete="on" name="title" value="{{ isset($course->title) ? $course->title : '' }}" class="input" required>
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
                        <textarea type="text" rows="4" cols="50" autocomplete="on" name="description" value="" class="input" required>
                       {{ isset($course->description) ? strip_tags($course->description) : '' }}
                        </textarea>
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
                        <input type="text" autocomplete="on" name="price" value="{{ isset($course->price) ? $course->price : '' }}" class="input" required>
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
                  <label class="label">Update Course Images</label>
                  <div class="field-body">
                    <div class="field file">
                      <label class="upload control">
                        <a href="/instructor/course/image/{{ isset($course->_id) ? $course->_id : '' }}" class="button blue">
                          Update
                        </a>
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
                <select name="location_selected" id="location_selected">
                  <option value="select_address">Select Location</option>
                  <option value="create_new">Create new Location</option>
                  @php
                  foreach($locations as $location){
                    if(isset($course->location->_id) &&  ($location->_id == $course->location->_id)){
                  @endphp  
                      <option value="{{$location->_id}}" selected="selected">{{$location->name}}</option>
                  @php
                    }else{
                  @endphp  
                      <option value="{{$location->_id}}">{{$location->name}}</option>
                  @php       
                    }
                  }  
                  @endphp 
                </select>
                <p class="help">You can select previous location</p>
              </div>
            </div>
          </div>
            <div class="field">
                <label class="label">Edit address</label>
                <div class="field-body">
                <div class="field edit-address">
                    <label class="edit-address control">
                    <a class="button blue" id="edit_address">
                        Address Actions
                    </a>
                    </label>
                </div>
                </div>
            </div>
          <div class="field">
            <input type="hidden" id="selected_location" name="selected_location" value="{{ isset($course->location->_id) ? $course->location->_id : '' }}">
            <label class="label">Location Name</label>
            <div class="control">
              <input type="text" autocomplete="on" id="location_name" name="location_name" value="{{ isset($course->location->name) ? $course->location->name : '' }}" class="input" required readonly>
            </div>
            <p class="help">Required. Course Location name</p>
          </div>
   
          <div class="field">
            <label class="label">Address</label>
            <div class="control">
            <input type="text" autocomplete="on" id="location_address" name="location_address" value="{{ isset($course->location->address) ? $course->location->address : '' }}" class="input" required readonly>
            </div>
            <p class="help">Required. Course address</p>
          </div>
     
          <div class="field">
            <label class="label">City</label>
            <div class="control">
            <input type="text" autocomplete="on" id="location_city"  name="location_city" value="{{ isset($course->location->city) ? $course->location->city : '' }}" class="input" required readonly>
            </div>
            <p class="help">Required. Course City</p>
          </div>
          <div class="field">
            <label class="label">Country</label>
            <div class="control">
            <input type="text" autocomplete="on" id="location_country" name="location_country" readonly value="NZ" class="input" required>
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
              <input type="text" autocomplete="on" name="duration" value="{{ isset($course->duration) ? $course->duration : '' }}" class="input" required>
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
            <p class="help">You can delete previously added date and time</p>
            <div class="control">
                <div id="fieldsUpdateContainer">
                    <ul>
                        @foreach($classdates as $dates)
                            <li>
                                <p><i class="fa-regular fa-calendar-days"></i>{{$dates->class_date}}</p>
                                <p><i class="fa-regular fa-clock"></i>{{$dates->start_at}}</p>
                                <p><i class="fa-solid fa-clock"></i>{{$dates->end_at}}</p>
                                <p><i class="fa-solid fa-chair"></i>{{$dates->max_capacity}}</p>
                                <p><a href="#" data-value="{{$dates->_id}}" class="class_date_edit"><i class="fa-solid fa-circle-xmark"></i></a>
                            </li>
                        @endforeach    
                    </ul>
                </div>
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

          </div>  
    <script type="text/javascript">

      $(function() {
            //Disable button
            $("#edit_address").prop('disabled', true);

            //Adding class dates
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

            //Remove class dates
            $(document).on("click", ".remove-btn", function () {
                $(this).parent().remove();
            });

            //Location selecting
            $("#location_selected").change(function () {
                let selectedValue = $(this).val();  // Get selected dropdown value
                let href = "/instructor/locations/";
                

                if( selectedValue == 'create_new'){
                    $("#edit_address").attr("href", href);
                    $("#edit_address").html('Create New Location');   
                    $("#edit_address").prop('disabled', false);
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

            //Delete class dates
            $(".class_date_edit").click(function (e) {
                e.preventDefault();
                let clickedElement = $(this); // Store reference to the clicked element
                let clickedValue = clickedElement.attr("data-value");
                
                Swal.fire({
                    title: "Do you want to delete this date and time?",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Yes",
                    denyButtonText: `Cancel`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        let listItems = $("#fieldsUpdateContainer ul li").length;
                        if (listItems <= 1) {
                            Swal.fire("Cannot delete the last item!", "", "warning");
                            return;
                        }
                        $.ajax({
                            url: "{{ route('instructor.classdatedeleted.ajax') }}",
                            type: "POST",
                            data: { 
                                "classdate_id": clickedValue,
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function (response) {
                                console.log(response.status);
                                if(response.status){
                                    Swal.fire("Deleted!", "", "success");
                                    clickedElement.closest("li").remove(); 
                                }
                            },
                            error: function () {
                                Swal.fire("Error fetching data", "", "info");
                            }
                        });
                        
                    } else if (result.isDenied) {
                        Swal.fire("Not deleted", "", "info");
                    }
                });
            });
      });

</script>

@endsection