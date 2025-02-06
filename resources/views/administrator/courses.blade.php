@extends('layouts.master_administrator')

@section('title', 'Home Page')

@section('content')

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
                  <a href="{{ route('administrator.course',[$course->_id]) }}" class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
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