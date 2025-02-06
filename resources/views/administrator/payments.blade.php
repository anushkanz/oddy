@extends('layouts.master_administrator')

@section('title', 'Home Page')

@section('content')

<div class="card has-table">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
          Payments
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <table id="payments">
          <thead>
          <tr>
            <th></th>
            <th>Booking Id</th>
            <th>Amount</th>
            <th>Payment method</th>
            <th>Status</th>
            <th>Transaction id</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          @php
            foreach($payments as $payment){
          @endphp
            <tr>
              <td class="image-cell"></td>
              <td data-label="Name" class="--name">{{$payment->booking_id}}</td>
              <td data-label="Email" class="--email">{{$payment->amount}}</td>
              <td data-label="Status" class="--status">{{$payment->payment_method}}</td>
              <td data-label="Role" class="--role">{{$payment->status}}</td>
              <td data-label="Role" class="--role">{{$payment->transaction_id}}</td>
              <td class="actions-cell">
                <div class="buttons right nowrap">
                  <a href="{{ route('administrator.payment',[$payment->_id]) }}" class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
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
          $('#payments').DataTable( {
              paging: true,
              responsive: true,
              pageLength: 10
          } );
          
      });

</script>

@endsection