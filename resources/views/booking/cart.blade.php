@extends('layouts.master_open_header')
@section('content')
<section class="is-hero-bar">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
        <h1 class="title">
            Cart
        </h1>
    </div>
</section>
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
                                @php foreach($course_dates as $dates) { @endphp
                                    <option value="{{$dates->_id}}">{{$dates->class_date}} {{$dates->start_at}} to {{$dates->end_at}}</option>
                                @php } @endphp    
                            </select>
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
                        <p>Class fee : $ {{$booking->classes->price}}</p>
                            @php 
                                $fee_percentage = 0.963; // Change this value to set the desired fee percentage
                                $payment_processing_fee =  (($amount + 0.3)/0.963) - $booking->classes->price;
                                $charge = round($booking->classes->price + $payment_processing_fee, 2);         
                            @endphp
                        <p>Booking fee : $ {{$payment_processing_fee}}</p>
                        <p>Total : $ {{$charge}}
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection