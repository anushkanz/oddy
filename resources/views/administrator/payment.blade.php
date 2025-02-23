@extends('layouts.master_administrator')
@section('title', 'Home Page')
@section('content')

<section class="section main-section">
  <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="fa-solid fa-house"></i></span>
            Booking Details
          </p>
        </header>
          <div class="card-content">
                <div class="field">
                  <label class="label">Name</label>
                  <div class="field-body">
                    <div class="field">
                      <div class="control">
                        <input type="text" autocomplete="on" name="title" value="{{ isset($booking->user->name) ? $booking->user->name: '' }}" class="input" disabled>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Date</label>
                  <div class="control">
                    <div class="select">
                      <input type="text" autocomplete="on" name="title" value="{{ $booking->classdate->class_date}} / {{ $booking->classdate->start_at}}" class="input" disabled>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Seats</label>
                  <div class="control">
                    <div class="select">
                      <input type="text" autocomplete="on" name="title" value="{{ $booking->seat_count}}" class="input" disabled>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Total</label>
                  <div class="field-body">
                    <div class="field">
                      <div class="control">
                        <input type="text" autocomplete="on" name="price" value="{{ $booking->payment->amount }}" class="input" disabled>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Status</label>
                    <div class="control">
                    @php 
                    $status = '';
                    if($booking->status == 1){
                        $status = 'Successfull booked';
                    }else{
                        $status = 'Unsuccessfull';
                    }
                    @endphp
                      <input type="text" autocomplete="on" name="level" value="{{ $status }}" class="input" disabled>
                    </div>
                </div>
  
          </div>
      </div>
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="fa-solid fa-house"></i></span>
            Payment Details
          </p>
        </header>
          <div class="card-content">
                <div class="field">
                  <label class="label">Payment Method</label>
                  <div class="field-body">
                    <div class="field">
                      <div class="control">
                        <input type="text" autocomplete="on" name="title" value="{{ $payment->payment_method}}" class="input" disabled>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Payment Status</label>
                  <div class="control">
                    <div class="select">
                      <input type="text" autocomplete="on" name="title" value="{{ $payment->status}}" class="input" disabled>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Transaction id</label>
                  <div class="control">
                    <div class="select">
                      <input type="text" autocomplete="on" name="title" value="{{ $payment->transaction_id}}" class="input" disabled>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Description</label>
                  <div class="field-body">
                    <div class="field">
                      <div class="control">
                        @php print_r(json_decode($payment->transaction_return,true)); @endphp
                      </div>
                    </div>
                  </div>
                </div>
                
                
          </div>
      </div>
      

      

      
      
    </div>
</section>


 
    
@endsection