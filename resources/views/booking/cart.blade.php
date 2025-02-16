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
                        {{$booking->course->title}}
                    </h1>
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
                        $7,770
                    </h1>
                </div>
                <span class="icon widget-icon text-blue-500"><i class="mdi mdi-cart-outline mdi-48px"></i></span>
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
                        $7,770
                    </h1>
                </div>
                <span class="icon widget-icon text-blue-500"><i class="mdi mdi-cart-outline mdi-48px"></i></span>
            </div>
        </div>
    </div>
</div>
@endsection