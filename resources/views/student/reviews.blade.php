@extends('layouts.master_student')

@section('title', 'Home Page')

@section('content')

<div class="card has-table">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="fa-solid fa-comment"></i></span>
          Reviews
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <table id="reviews">
          <thead>
          <tr>
            <th></th>
            <th>Receiver</th>
            <th>Reviewer</th>
            <th>Course</th>
            <th>Ratings</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          @php
            foreach($reviews as $review){
          @endphp
            <tr>
              <td class="image-cell"></td>
              <td data-label="Name" class="--name">{{$review->receiver->name}}</td>
              <td data-label="Title" class="--title">{{$review->reviewer->title}}</td>
              <td data-label="Category" class="--category">{{$review->classes->title}}</td>
              <td data-label="Status" class="--status">{{$review->rating}}</td>
              <td class="actions-cell">
                <div class="buttons right nowrap">
                  <a href="{{ route('student.review',[$review->_id]) }}" class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
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
          $('#reviews').DataTable( {
              paging: true,
              responsive: true,
              pageLength: 10
          } );
          
      });

</script>

@endsection