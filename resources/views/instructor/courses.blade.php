@extends('layouts.master_instructor')

@section('title', 'Home Page')

@section('content')



<div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account-circle"></i></span>
            Edit Profile
          </p>
        </header>
        <div class="card-content">
            <form>
              @csrf
              
            </form>
            <hr>
            <form method='post' action="{{ route('instructor.course.update') }}">
            <input type='hidden' name='task' value="create"> 
              @csrf
              <div class="field">
                <label class="label">Name</label>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                      <input type="text" autocomplete="on" name="name" value="" class="input" required>
                    </div>
                    <p class="help">Required. Your name</p>
                  </div>
                </div>
              </div>
              <div class="field">
                <label class="label">Phone</label>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                      <input type="text" autocomplete="on" name="phone" value="" class="input" required>
                    </div>
                    <p class="help">Required. Your phone</p>
                  </div>
                </div>
              </div>
              <div class="field">
                <label class="label">E-mail</label>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                      <input type="email" autocomplete="on" name="email" value="" class="input" required>
                    </div>
                    <p class="help">Required. Your e-mail</p>
                  </div>
                </div>
              </div>
              <div class="field">
                <label class="label">Avatar</label>
                <div class="field-body">
                  <div class="field file">
                    <label class="upload control">
                      <a class="button blue">
                        Upload
                      </a>
                      <input type="file">
                    </label>
                  </div>
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
            </form>
        </div>
      </div>
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            Profile
          </p>
        </header>
        <div class="card-content">
          <div class="image w-48 h-48 mx-auto">
            <img src="https://avatars.dicebear.com/v2/initials/john-doe.svg" alt="John Doe" class="rounded-full">
          </div>
          <hr>
          <div class="field">
            <label class="label">Name</label>
            <div class="control">
              <input type="text" readonly value="{{ isset($user->name) ? $user->name : '' }}" class="input is-static">
            </div>
          </div>
          <hr>
          <div class="field">
            <label class="label">Phone</label>
            <div class="control">
              <input type="text" readonly value="{{ isset($user->phone) ? $user->phone : '' }}" class="input is-static">
            </div>
          </div>
          <hr>
          <div class="field">
            <label class="label">E-mail</label>
            <div class="control">
              <input type="text" readonly value="{{ isset($user->email) ? $user->email : '' }}" class="input is-static">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<section class="section main-section">  
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
    </section>  
    <script type="text/javascript">

      $(function() {
          $('#courses').DataTable( {
              paging: true,
              responsive: true,
              pageLength: 10
          } );
          
      });

</script>

@endsection