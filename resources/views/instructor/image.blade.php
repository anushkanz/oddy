@extends('layouts.master_instructor')

@section('title', 'Home Page')

@section('content')
<div class="grid gap-6 grid-cols-1 md:grid-cols-3 mb-6">
    <div class="card mb-6">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="fa-regular fa-image"></i></span>
          Images of {{$course_images->title}}
        </p>
      </header>
      <div class="card-content">
        <div class="chart-area">
          <div class="h-full">
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div></div>
              </div>
            </div>
            <ul>
                @foreach(json_decode($course_images->photo_gallery,true) as $imges)
                    <li><img src="{{$imges['path']}}"></li>
                @endforeach           
            </ul>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection