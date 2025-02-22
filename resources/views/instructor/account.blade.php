@extends('layouts.master_instructor')

@section('title', 'Home Page')

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
            <span class="icon"><i class="fa-regular fa-user"></i></span>
            Edit Profile
          </p>
        </header>
        <div class="card-content">
        <form method="POST" enctype="multipart/form-data" action="{{ route('instructor.account.update') }}">
              @csrf
              <input type='hidden' name='task' value="details"> 
              <input type='hidden' name='id' value="{{$user->_id}}"> 
              <div class="field">
                <label class="label">Profile Images</label>
                <div class="field-body">
                  <div class="field file">
                    <label class="upload control">
                      <a class="button blue">
                        Upload
                      </a>
                      <input type="file" name="file_upload[]">
                    </label>
                  </div>
                </div>
              </div>
              <hr>
              <div class="field">
                <label class="label">Name</label>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                      <input type="text" autocomplete="on" name="name" value="{{ isset($user->name) ? $user->name : '' }}" class="input" required>
                    </div>
                    <p class="help">Required. Your name</p>
                  </div>
                </div>
              </div>
              <div class="field">
                <label class="label">Phone</label>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                      <input type="text" autocomplete="on" name="phone" value="{{ isset($user->phone) ? $user->phone : '' }}" class="input" required>
                    </div>
                    <p class="help">Required. Your phone</p>
                  </div>
                </div>
              </div>
              <div class="field">
                <label class="label">E-mail</label>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                      <input type="email" autocomplete="on" name="email" value="{{ isset($user->email) ? $user->email : '' }}" class="input" required>
                    </div>
                    <p class="help">Required. Your e-mail</p>
                  </div>
                </div>
              </div>
              <hr>
              <div class="field">
                <div class="control">
                  <button type="submit" class="button green">
                    Submit
                  </button>
                </div>
              </div>
              <!--Display error/success/warnning-->
              @if(session('error-account'))
                <div class="notification red">
                  <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                    <div>
                      <span class="icon"><i class="fa-solid fa-circle-exclamation"></i></span>
                      <b> {{session('error-account')}}</b>
                    </div>
                    <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
                  </div>
                </div>
              @endif
              @if(session('success-account'))
                <div class="notification green">
                  <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                    <div>
                      <span class="icon"><i class="fa-solid fa-check"></i></span>
                      <b> {{session('success-account')}}</b>
                    </div>
                    <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
                  </div>
                </div>
              @endif
            </form>
        </div>
      </div>
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="fa-regular fa-address-card"></i></span>
            Profile
          </p>
        </header>
        <div class="card-content">
          <div class="image w-48 h-48 mx-auto">
            @php 
            if(!empty($user->photo_gallery)){
              $images_array = json_decode($user->photo_gallery,true);
            @endphp
              <img src="{{$images_array[0]['path']}}" alt="{{$images_array[0]['name']}}" class="rounded-full">
            @php
              }
            @endphp
          </div>
          <hr>
          <div class="field">
            <label class="label">Name</label>
            <div class="control">
              <input type="text" readonly value="{{ isset($user->name) ? $user->name : '' }}" class="input is-static">
            </div>
          </div>
          <hr>
          <div class="field">
            <label class="label">Phone</label>
            <div class="control">
              <input type="text" readonly value="{{ isset($user->phone) ? $user->phone : '' }}" class="input is-static">
            </div>
          </div>
          <hr>
          <div class="field">
            <label class="label">E-mail</label>
            <div class="control">
              <input type="text" readonly value="{{ isset($user->email) ? $user->email : '' }}" class="input is-static">
            </div>
          </div>
        </div>
      </div>
    </div>
    


    
  </section>


  <div class="card">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="fa-solid fa-passport"></i></span>
          Change Password
        </p>
      </header>
      <div class="card-content">
      <form method='post' action="{{ route('instructor.account.update') }}">
        <input type='hidden' name='task' value="password"> 
        <input type='hidden' name='id' value="{{$user->_id}}"> 
        @csrf
          <div class="field">
            <label class="label">Current password</label>
            <div class="control">
              <input type="password" name="password_current" autocomplete="current-password" class="input" required>
            </div>
            <p class="help">Required. Your current password</p>
          </div>
          <hr>
          <div class="field">
            <label class="label">New password</label>
            <div class="control">
              <input type="password" autocomplete="password" name="password" class="input" required>
            </div>
            <p class="help">Required. New password</p>
          </div>
          <div class="field">
            <label class="label">Confirm password</label>
            <div class="control">
              <input type="password" autocomplete="new-password" name="password_confirmation" class="input" required>
            </div>
            <p class="help">Required. New password one more time</p>
          </div>
          <hr>
          <div class="field">
            <div class="control">
              <button type="submit" class="button green">
                Submit
              </button>
            </div>
          </div>
            <!--Display error/success/warnning-->
            @if(session('error-password'))
                <div class="notification red">
                  <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                    <div>
                      <span class="icon"><i class="fa-solid fa-circle-exclamation"></i></span>
                      <b> {{session('error-password')}}</b>
                    </div>
                    <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
                  </div>
                </div>
              @endif
              @if(session('success-password'))
                <div class="notification green">
                  <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                    <div>
                      <span class="icon"><i class="fa-solid fa-check"></i></span>
                      <b> {{session('success-password')}}</b>
                    </div>
                    <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
                  </div>
                </div>
              @endif
        </form>
      </div>
    </div>
    
  @endsection