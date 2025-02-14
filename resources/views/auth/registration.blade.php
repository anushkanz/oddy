@extends('layouts.master_open_header')
@section('content')
<div id="app">
    <section class="section main-section"> 
    <div class="card login-form-card">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="fa-solid fa-lock"></i></span>
          Login
        </p>
      </header>
      <div class="card-content">
        <form method="POST" action="{{ route('login.custom') }}">
          @csrf <!-- {{ csrf_field() }} -->
          <input type="hidden" id="token" class="form-control" name="token" value="{{request()->route()->parameters['type']}}">
            <div class="field spaced">
              <label class="label">Name</label>
              <div class="control icons-left">
                <input class="input" type="text" name="name"  id="name" placeholder="Name" autocomplete="name"  required autofocus>
                <span class="icon is-small left"><i class="fa-regular fa-user"></i></span>
              </div>
              <p class="help">
                Please enter your name
              </p>
            </div>
            <div class="field spaced">
              <label class="label">Login</label>
              <div class="control icons-left">
                <input class="input" type="email" name="email"  id="email" placeholder="user@example.com" autocomplete="username"  required autofocus>
                <span class="icon is-small left"><i class="fa-regular fa-envelope"></i></span>
              </div>
              <p class="help">
                Please enter your login
              </p>
            </div>
            <div class="field spaced">
              <label class="label">Mobile</label>
              <div class="control icons-left">
                <input class="input" type="text" name="mobile"  id="name" placeholder="Mobile" autocomplete="mobile"  required autofocus>
                <span class="icon is-small left"><i class="fa-solid fa-mobile-screen-button"></i></span>
              </div>
              <p class="help">
                Please enter your mobile
              </p>
            </div>
            <div class="field spaced">
              <label class="label">Password</label>
              <p class="control icons-left">
                  <input type="password" placeholder="Password" id="password" class="input" name="password" required>
                  <span class="icon is-small left"><i class="fa-solid fa-passport"></i></span>
                  @if ($errors->has('emailPassword'))
                      <span class="text-danger">{{ $errors->first('emailPassword') }}</span>
                  @endif
              </p>
              <p class="help">
                Please enter your password
              </p>
            </div>
            <div class="field spaced">
              <label class="label">Password</label>
              <p class="control icons-left">
                  <input type="password" placeholder="Password" id="password_confirmation" class="input" name="password_confirmation" required>
                  <span class="icon is-small left"><i class="fa-solid fa-passport"></i></span>
                  @if ($errors->has('emailPassword'))
                      <span class="text-danger">{{ $errors->first('emailPassword') }}</span>
                  @endif
              </p>
              <p class="help">
                Please re enter your password
              </p>
            </div>
            
          <hr>
          <div class="field grouped">
            <div class="control">
              <button type="submit" class="button blue">
                Sign up
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    </section> 
</div>
@endsection