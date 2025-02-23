@extends('layouts.master_administrator')

@section('title', 'Home Page')

@section('content')

<div class="card has-table">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
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
            <th>Payment Id</th>
            <th>Status</th>
            <th>Date</th>
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
              <td data-label="Payment" class="--payment">{{$booking->payment->_id}}</td>
              <td data-label="Status" class="--status">
                @php 
                  if($booking->status == 1){
                      echo 'Successfull booked';
                  }else{
                      echo 'Unsuccessfull';
                  }
                @endphp
              </td>
              <td data-label="Date" class="--date">{{$booking->created_at}}</td>
              <td class="actions-cell">
                <div class="buttons right nowrap">
                  <a href="{{ route('administrator.booking',[$booking->_id]) }}" class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
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