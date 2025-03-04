@extends('layouts.master_instructor')

@section('title', 'Home Page')

@section('content')
<section class="is-hero-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="title">
      Qualifications
    </h1>
  </div>
</section>

<section class="section main-section">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
    <div class="card">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="fa-solid fa-passport"></i></span>
         Add Qulifications
        </p>
      </header>
      <div class="card-content">
      <form method='post' enctype="multipart/form-data" action="{{ route('instructor.qualification.update') }}">
      <input type='hidden' name='task' value="create">
      <input type='hidden' name='user' value="{{$user->_id}}">
            @csrf

            <div class="field">
                <label class="label">Name</label>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                    <input type="text" name="title" class="input" style="width: 100%;" required>
                    </div>
                    <p class="help">Required. Qualification Title</p>
                  </div>
                </div>
            </div> 
            <div class="field">
                <label class="label">Description</label>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                    <textarea type="text" rows="4" cols="50" autocomplete="on" name="description" value="" class="input" required></textarea>
                    </div>
                    <p class="help">Required. Qualification Description</p>
                  </div>
                </div>
            </div>
            
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
            <hr>
            <div class="field">
                <div class="control">
                <button type="submit" class="button green">
                    Submit
                </button>
                </div>
            </div>
            <!--Display error/success/warnning-->
          @if(session('error-qualifications'))
            <div class="notification red">
              <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                <div>
                  <span class="icon"><i class="fa-solid fa-circle-exclamation"></i></span>
                  <b> {{session('error-qualifications')}}</b>
                </div>
                <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
              </div>
            </div>
          @endif
          @if(session('success-qualifications'))
            <div class="notification green">
              <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                <div>
                  <span class="icon"><i class="fa-solid fa-check"></i></span>
                  <b> {{session('success-qualifications')}}</b>
                </div>
                <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
              </div>
            </div>
          @endif
        </form>
      </div>
    </div>
  </section>
  <div class="card has-table">  
<header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="fa-solid fa-house"></i></span>
          Qualifications
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <table id="qualifications">
          <thead>
          <tr>
            <th></th>
            <th>Title</th>
            <th>Description</th>
            <th>Photo</th>
            <th></th>
          </tr>
          </thead>
          <tbody id="fieldsUpdateContainer">
          @php
            foreach($qualifications as $qualification){
          @endphp
            <tr>
              <td class="image-cell"></td>
              <td data-label="Title" class="--name">{{$qualification->title}}</td>
              <td data-label="Description" class="--title">{{$qualification->description}}</td>
              <td data-label="Photo" class="--category">
                @php 
                if(!empty($qualification->photo_gallery)){
                  $image = json_decode($qualification->photo_gallery,true);
                @endphp
                  <img src="{{$image[0]['path']}}" alt="{{$image[0]['name']}}">
                @php 
                  }else{
                @endphp
                  <i class="fa-solid fa-certificate"></i>
                @php 
                  }
                @endphp
              </td>
              <td class="actions-cell">
                <div class="buttons right nowrap">
                  <a data-value="{{$qualification->_id}}" href="#" class="button small blue --jb-modal class_qulification_edit class_date_edit"  data-target="sample-modal-2" type="button">
                    <span class="icon"><i class="fa-solid fa-circle-xmark"></i></span>
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
            $('#qualifications').DataTable( {
                paging: true,
                responsive: true,
                pageLength: 10
            });

            $(".class_qulification_edit").click(function (e) {
                e.preventDefault();
                let clickedElement = $(this); // Store reference to the clicked element
                let clickedValue = clickedElement.attr("data-value");
                console.log(clickedValue);
                Swal.fire({
                    title: "Do you want to delete this qualification?",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Yes",
                    denyButtonText: `Cancel`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('instructor.qualificationdelete.ajax') }}",
                            type: "POST",
                            data: { 
                                "qualification_id": clickedValue,
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function (response) {
                                console.log(response);
                                if(response.status){
                                    Swal.fire("Deleted!", "", "success");
                                    clickedElement.closest("tr").remove(); 
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