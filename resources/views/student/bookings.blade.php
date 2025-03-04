@extends('layouts.master_student')

@section('title', 'Home Page')

@section('content')



<div class="card has-table">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="fa-solid fa-bookmark"></i></span>
          Bookings
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
            <th>Name</th>
            <th>Course</th>
            <th>Seats</th>
            <th>Status</th>
            <th>Date</th>
            <th></th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          @php
            foreach($bookings as $booking){
          @endphp
            <tr>
              <td class="image-cell"></td>
              <td data-label="Name" class="--name">{{$booking->user->name}}</td>
              <td data-label="Title" class="--title">{{$booking->classes->title}}</td>
              <td data-label="Seats" class="--seats">{{$booking->seat_count}}</td>
              <td data-label="Status" class="--status">
                @php 
                  if($booking->status == 1){
                      echo 'Successfull booked';
                  }else{
                      echo 'Unsuccessfull';
                  }
                @endphp
              </td>
              <td data-label="date" class="--date">{{$booking->created_at}}</td>
              <td class="actions-cell">
                <div class="buttons right nowrap">
                  <a href="{{ route('student.review.create',$booking->_id) }}" class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                    <span class="icon">
                      <i class="fa-solid fa-comment"></i>
                    </span>
                  </a>
                </div>
              </td>
              <td class="actions-cell">
                <div class="buttons right nowrap">
                  <a href="{{ route('student.booking.payment.pdf',$booking->_id) }}" class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                    <span class="icon">
                    <i class="fa-solid fa-file-pdf"></i>
                    </span>
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
