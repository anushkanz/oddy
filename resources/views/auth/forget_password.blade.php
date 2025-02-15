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
        <form method="POST" action="{{ route('login.forget_password.update') }}">
          @csrf <!-- {{ csrf_field() }} -->
            <div class="field spaced">
              <label class="label">Login</label>
              <div class="control icons-left">
                <input class="input" type="email" name="email"  id="email" placeholder="user@example.com" autocomplete="username"  required autofocus>
                <span class="icon is-small left"><i class="fa-regular fa-user"></i></span>
              </div>
              <p class="help">
                Please enter your email
              </p>
            </div>
          <hr>
          <div class="field grouped">
            <div class="control">
              <button type="submit" class="button blue">
                Request to Reset password
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

@endsection