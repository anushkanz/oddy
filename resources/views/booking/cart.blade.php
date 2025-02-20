@extends('layouts.master_open_header')
@section('content')
<section class="is-hero-bar">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
        <h1 class="title">
            Cart
        </h1>
    </div>
</section>
<form method="POST" action="{{ route('student.booking.cart.update') }}">
    @csrf
    <input type='hidden' name='task' value="cart"> 
    <input type='hidden' name='booking_id' value="{{$booking->_id}}"> 
    <input type='hidden' name='user_id' value="{{$user->_id}}"> 
    <div class="grid gap-6 grid-cols-1 md:grid-cols-3 mb-6">
        <div class="card">
            <div class="card-content">
                <div class="flex items-center justify-between">
                    <div class="widget-label">
                        <h3>
                            Course Details
                        </h3>
                        <h1>
                            {{$booking->classes->title}}
                        </h1>
                    </div>
                </div>
                <div class="field">
                    <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <p> {{$booking->classes->description}}</p>
                            <p> {{$booking->classes->instructor->name}}</p>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <div class="flex items-center justify-between">
                    <div class="widget-label">
                        <h3>
                            Course Dates
                        </h3>
                        <h1>
                            &nbsp;
                        </h1>
                    </div>
                </div>
                <div class="field">
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <select name="class_date_id" id="class_date_id" class="input" >
                                <option data-seat="0" value="select_date">Select date</option>
                                    @php 
                                        foreach($course_dates as $dates) { 
                                            if($dates->max_capacity != 0){
                                    @endphp
                                        <option data-seat="{{$dates->max_capacity}}" value="{{$dates->_id}}">{{$dates->class_date}} {{$dates->start_at}} to {{$dates->end_at}} Seats : {{$dates->max_capacity}} left</option>
                                    @php } } @endphp    
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Seats</label>
                    <div class="control">
                        <input type="number" min="1" max="" id="seat_count" name="seat_count" class="input" required/>
                    </div>
                    <p class="help">Required. Number of seats</p>
                </div>
               
                
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <div class="flex items-center justify-between">
                    <div class="widget-label">
                        <h3>
                            Cart Infromation 
                        </h3>
                        <h1>
                            &nbsp;
                        </h1>
                    </div>
                </div>
                <div class="field">
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <p>Course fee : ${{$booking->classes->price}}</p>
                                    @php 
                                        $fee_percentage = 0.963; // Change this value to set the desired fee percentage
                                        $payment_processing_fee =  (($booking->classes->price + 0.3)/0.963) - $booking->classes->price;
                                        $charge = round($booking->classes->price + $payment_processing_fee, 2);         
                                    @endphp
                                <p>Booking fee : ${{round($payment_processing_fee,4)}}</p>
                                <p>Total : ${{$charge}}
                                
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="field">
                    <div class="control">
                        <button type="submit" class="button green">
                            Pay now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>  
<script type="text/javascript">
    $(function() {
        $("#seat_count").val(0).prop("readonly", true);
        $("#class_date_id").change(function () {
            let selectedValue = $(this).find(':selected').attr('data-seat'); 
            console.log(selectedValue);
            if(selectedValue == 0){
                $("#seat_count").val(0).prop("readonly", true);
            }else{
                $("#seat_count").prop('max',selectedValue); 
                $("#seat_count").val(1).prop("readonly", false);
            }
            
        });
    });
</script>  
@endsection