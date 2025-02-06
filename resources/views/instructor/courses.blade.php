@extends('layouts.master_instructor')

@section('title', 'Home Page')

@section('content')

<form method='post' action="{{ route('instructor.course.update') }}">
@csrf
<input type='hidden' name='task' value="create">
<section class="section main-section">
  <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account-circle"></i></span>
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
                        <textarea type="text" autocomplete="on" name="description" value="" class="input" required></textarea>
                      </div>
                      <p class="help">Required. Course description</p>
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
                        <input type="file" name="file_upload[]">
                      </label>
                    </div>
                  </div>
                </div>
          </div>
      </div>
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account-circle"></i></span>
            Location Details
          </p>
        </header>
        <div class="card-content">
          <div class="field">
            <label class="label">Location Selection</label>
            <div class="control">
              <div class="select">
                <select name="location">
                  <option value="">Select Location</option>
                  @foreach($locations as $location)
                    <option value="{{$location->_id}}">{{$location->name}}</option>
                  @endforeach  
                </select>
                <p class="help">You can select previous location</p>
              </div>
            </div>
          </div>
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
        </div>
      </div>

      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account-circle"></i></span>
            Location Details
          </p>
        </header>
        <div class="card-content">
          <div class="field">
            <label class="label">Location Selection</label>
            <div class="control">
              <div class="select">
                <select name="location">
                  <option value="">Select Location</option>
                  @foreach($locations as $location)
                    <option value="{{$location->_id}}">{{$location->name}}</option>
                  @endforeach  
                </select>
                <p class="help">You can select previous location</p>
              </div>
            </div>
          </div>
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
        </div>
      </div>




      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account-circle"></i></span>
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
        </div>
      </div>
    </div>
</section>
</form>
<div class="card has-table">  
<header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
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
            <th></th>
          </tr>
          </thead>
          <tbody>
          @php
            foreach($courses as $course){
          @endphp
            <tr>
              <td class="image-cell"></td>
              <td data-label="Name" class="--name">{{$course->instructor()->name}}</td>
              <td data-label="Title" class="--title">{{$course->title}}</td>
              <td data-label="Category" class="--category">{{$course->category()->name}}</td>
              <td data-label="Price" class="--role">{{$course->price}}</td>
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
                        <input type="date" name="dates[]"  class="input"  required>
                        <input type="time" name="times[]"  class="input"  required>
                        <button type="button" class="remove-btn button red">Remove</button>
                    </div>
                `;
                $("#fieldsContainer").append(fieldHtml);
            });

            $(document).on("click", ".remove-btn", function () {
                $(this).parent().remove();
            });

      });

</script>

@endsection