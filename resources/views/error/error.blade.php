@extends('layouts.master_open_header')
@section('content')
<section class="is-hero-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="title">
      Profile
    </h1>
    <button class="button light">Button</button>
  </div>
</section>
<section class="section main-section">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
        <div class="card">
            <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="fa-solid fa-bug"></i></span>
                Error
            </p>
            </header>
            <div class="card-content">
                <div class="field">
                    <!--Display error/success/warnning-->
                    @if(session('error-page'))
                    <div class="notification red">
                        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                        <div>
                            <span class="icon"><i class="fa-solid fa-circle-exclamation"></i></span>
                            <b> {{session('error-page')}}</b>
                        </div>
                        <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
                        </div>
                    </div>
                    @endif
                    @if(session('success-page'))
                    <div class="notification green">
                        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                        <div>
                            <span class="icon"><i class="fa-solid fa-check"></i></span>
                            <b> {{session('success-page')}}</b>
                        </div>
                        <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
                        </div>
                    </div>
                    @endif
                </div>    
            </div>     
        </div>    
    </div>
</section>          
@endsection