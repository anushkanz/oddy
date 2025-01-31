@extends('layouts.master_open_header')
@section('content')
<div id="app">

  <section class="section main-section">
    <div class="card">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-lock"></i></span>
          Login
        </p>
      </header>
      <div class="card-content">
      <form method="POST" action="{{ route('login.custom') }}">
        @csrf <!-- {{ csrf_field() }} -->
            <div class="field spaced">
            <label class="label">Login</label>
            <div class="control icons-left">
              <input class="input" type="text"  id="email" placeholder="user@example.com" autocomplete="username"  required autofocus>
              <span class="icon is-small left"><i class="mdi mdi-account"></i></span>
            </div>
            <p class="help">
              Please enter your login
            </p>
            </div>

            <div class="field spaced">
            <label class="label">Password</label>
            <p class="control icons-left">
                <input type="password" placeholder="Password" id="password" class="input" name="password" required>
                <span class="icon is-small left"><i class="mdi mdi-asterisk"></i></span>
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
            </div>
            <div class="control">
              <a href="/forget_password" class="button">
                Forget password
              </a>
            </div>
          </div>

        </form>
      </div>
    </div>

  </section>


</div>

@endsection