@extends('layouts.master_instructor')

@section('title', 'Home Page')

@section('content')
<section class="is-hero-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="title">
      Qualifications
    </h1>
    <button class="button light">Button</button>
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
      <form method='post' action="{{ route('instructor.qualification.update') }}">
      <input type='hidden' name='task' value="create">
      <input type='hidden' name='user' value="{{$user->_id}}">
          @csrf
          <div id="fieldsContainer"> <!-- Dynamic fields will be added here --></div>
          <button type="button" class="button blue" id="addFieldBtn">Add Qulification</button>
          <hr>
          <div class="field">
            <div class="control">
              <button type="submit" class="button green">
                Submit
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
  
    <script type="text/javascript">

      $(function() {

        $('#qualifications').DataTable( {
              paging: true,
              responsive: true,
              pageLength: 10
        });


        $("#addFieldBtn").click(function () {
                let fieldHtml = `
                    <div class="field-container">
                      <div class="field">
                        <label class="label">Title</label>
                        <div class="control">
                          <input type="text" name="title[]" class="input" style="width: 100%;" required>
                        </div>  
                      </div>  
                      <div class="field">  
                        <label class="label">Description</label>
                        <div class="control">
                          <textarea type="text" rows="4" cols="50" autocomplete="on" name="description[]" value="" class="input" required></textarea>
                        </div>
                      </div>  
                      <div class="field">
                        <label class="label">Profile Images</label>
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
                      
                      <div class="field">  
                        <div class="control">
                          <button type="button" class="remove-btn button red">Remove</button>
                        </div>
                      </div>
                      <hr>  
                    </div>
                `;
                $("#fieldsContainer").append(fieldHtml);
            });

            //Remove class dates
            $(document).on("click", ".remove-btn", function () {
              $(this).closest(".field-container").remove();
            });

      });
      </script>
  @endsection