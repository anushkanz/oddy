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
                        <label class="label">Select your class date</label>
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
                                <p>Course fee : <span id="seat_fee_selected" data-fee="{{$booking->classes->price}}"></span>${{$booking->classes->price}}</p>
                                    @php 
                                        $fee_percentage = 0.963; // Change this value to set the desired fee percentage
                                        $payment_processing_fee =  (($booking->classes->price + 0.3)/0.963) - $booking->classes->price;
                                        $charge = round($booking->classes->price + $payment_processing_fee, 2);         
                                    @endphp
                                <p>Booking fee : $<span id="booking_fee_select"></span></p>
                                <p>Seats : <span id="seat_count_select" data-seat=""></span></p>
                                <p>Total :  <span id="total_select"></span></p>
                                
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
        let seatCost = $('#seat_fee_selected').data('fee'); 
        $("#seat_count").val(1).prop("readonly", true);
        $("#total_select").html(total_calculation(1,seatCost));
        console.log(total_calculation(1,seatCost));
        $("#seat_count_select").html(1);
        $("#booking_fee_select").html(booking_fee_calculator(total_calculation(1,seatCost)));

        $("#class_date_id").change(function () {
            let selectedValue = $(this).find(':selected').attr('data-seat'); 
            console.log(selectedValue);
            
            $("#total_select").html(total_calculation(1,seatCost));
            $("#booking_fee_select").html(booking_fee_calculator(total_calculation(1,seatCost)));
            if(selectedValue == 'select_date'){
                $("#seat_count").val(1).prop("readonly", true);
            }else{
                $("#seat_count").prop('max',selectedValue); 
                $("#seat_count").val(1).prop("readonly", false);
                $("#total_select").html(total_calculation(selectedValue,seatCost));
                $("#booking_fee_select").html(booking_fee_calculator(total_calculation(selectedValue,seatCost)));
            }
        });


        $("#seat_count").change(function() { 
            let selectedValue = $(this).val();  
            let max = $(this).attr('max');
            if(parseInt(selectedValue) > parseInt(max)){
                Swal.fire({
                    title: "Seat count need to change",
                    text: "We only have "+max+" seats, we are unable to book "+selectedValue+ " seats.",
                    icon: "error"
                });
                $("#seat_count").val(1);
                $("#seat_count_select").html(1);
                $("#total_select").html(total_calculation(1,seatCost));
                $("#booking_fee_select").html(booking_fee_calculator(total_calculation(1,seatCost)));
            }else{
                $("#seat_count_select").html(selectedValue);
                $("#total_select").html(total_calculation(selectedValue,seatCost));
                $("#booking_fee_select").html(booking_fee_calculator(total_calculation(selectedValue,seatCost)));
            }
        }); 

    });
    function total_calculation(seat_count,seat_cost){
        let feePercentage = parseFloat(0.963);
        let totalCost = parseFloat(seat_cost) * parseFloat(seat_count);
        let finalCost = ((parseFloat(totalCost) +parseFloat(0.3))/parseFloat(0.963)) - parseFloat(totalCost); 
        let printedCost = parseFloat(finalCost) +  parseFloat(totalCost);
        let return_cal = {'printedCost'=>printedCost,'bookingFee'=>finalCost}
        return return_cal;
    }

    function booking_fee_calculator(total){
        let feePercentage = 0.963;
        let finalCost = ((parseFloat(total) +parseFloat(0.3))/parseFloat(0.963)) - parseFloat(total); 
        return finalCost;
    }

</script>  
@endsection