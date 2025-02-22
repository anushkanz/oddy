@extends('layouts.master_student')

@section('title', 'Home Page')

@section('content')

<div class="card has-table">
    <!--Display error/success/warnning-->
    @if(session('error-review'))
        <div class="notification red">
          <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
            <div>
              <span class="icon"><i class="fa-solid fa-circle-exclamation"></i></span>
              <b> {{session('error-review')}}</b>
            </div>
            <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
          </div>
        </div>
      @endif
      @if(session('success-review'))
        <div class="notification green">
          <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
            <div>
              <span class="icon"><i class="fa-solid fa-check"></i></span>
              <b> {{session('success-review')}}</b>
            </div>
            <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
          </div>
        </div>
      @endif
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
              <td data-label="Receiver" class="--receiver">{{$review->receiver->name}}</td>
              <td data-label="Reviewer" class="--reviewer">{{$review->reviewer->name}}</td>
              <td data-label="Course" class="--course">{{$review->classes->title}}</td>
              <td data-label="Status" class="--status">{{$review->rating}}</td>
              <td class="actions-cell">
                <div class="buttons right nowrap">
                  <a href="{{ route('student.review.edit',[$review->_id]) }}" class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
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