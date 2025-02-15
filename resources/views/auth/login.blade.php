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
            <div class="field spaced">
              <label class="label">Login</label>
              <div class="control icons-left">
                <input class="input" type="email" name="email"  id="email" placeholder="user@example.com" autocomplete="username"  required autofocus>
                <span class="icon is-small left"><i class="fa-regular fa-user"></i></span>
              </div>
              <p class="help">
                Please enter your login
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
              <div class="control">
                <label class="checkbox"><input type="checkbox" name="remember" value="1" checked>
                  <span class="check"></span>
                  <span class="control-label">Remember</span>
                </label>
              </div>
            </div>
          <hr>
          <div class="field grouped">
            <div class="control">
              <button type="submit" class="button blue">
                Login
              </button>
              <a href="/forget_password" class="button green">
                Forget password
              </a>
              <a href="/registration/student" class="button green">
                Student Sign up
              </a>
              <a href="/registration/tutor" class="button yellow">
                Tutor Sign up
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

@endsection