@extends('layouts.master_instructor')

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
          if(!empty($bookings)){
            foreach($bookings as $key => $booking){
              foreach($booking  as $item){
          @endphp
            <tr>
              <td class="image-cell"></td>
              <td data-label="Name" class="--name">{{ isset($item->user->name) ? $item->user->name : '' }}</td>
              <td data-label="Title" class="--title">{{ isset($item->classes->title) ? $item->classes->title : '' }}</td>
              <td data-label="Category" class="--category">{{ isset($item->payment->_id) ? $item->payment->_id : '' }}</td>
              <td data-label="Status" class="--status">{{ isset($item->status) ? $item->status : '' }}</td>
              <td data-label="date" class="--date">{{ isset($item->booking_date) ? $item->booking_date : '' }}</td>
              <td class="actions-cell">
                <div class="buttons right nowrap">
                  <a href="{{ route('student.booking.payment.pdf',$item->_id) }}" class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                    <span class="icon">
                      <i class="fa-solid fa-download"></i>
                    </span>
                  </a>
                </div>
              </td>
            </tr>
          @php
            }}}
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
