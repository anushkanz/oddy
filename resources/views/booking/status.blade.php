@extends('layouts.master_open_header')
@section('content')
<section class="is-hero-bar">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
        <h1 class="title">
            Transaction Status 
        </h1>
    </div>
</section>
<div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
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
                        <p>Selected time : {{$booking->classdate->class_date}} {{$booking->classdate->start_at}} to {{$booking->classdate->end_at}}</p>
                    </div>
                </div>
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
            <div class="field">
            <label class="label">Name</label>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            {{$user->name}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
            <label class="label">Email</label>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                        {{$user->email}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
            <label class="label">Phone</label>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            {{$user->phone}}
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
                        Payment Details
                    </h3>
                    <h1>
                        &nbsp;
                    </h1>
                </div>
            </div>
            <div class="field">
            <label class="label">Amount</label>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            {{$payment->amount}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
            <label class="label">Payment Status</label>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            {{$payment->status}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
            <label class="label">Payment Method</label>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                                {{$payment->payment_method}}
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="field">
            <label class="label">Details</label>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <p>All infromation we have emailed to {{$user->email}}, If you  have any problem with this, please contact our support service with your booking id #{{$booking->_id}}.</p>
                            <p><i class="fa-solid fa-download"></i><a href="{{ route('student.booking.payment.pdf',$booking->_id) }}" target="_blank">Download Report</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection