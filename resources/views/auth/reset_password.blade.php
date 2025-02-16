@extends('layouts.master_open_header')
@section('content')
<div id="app">
  <section class="section main-section">
    <div class="card login-form-card">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="fa-solid fa-lock"></i></span>
          Reset Password
        </p>
      </header>
      <div class="card-content">
        <form method="POST" action="{{ route('login.forget_password.update') }}">
            @csrf <!-- {{ csrf_field() }} -->
            <input type="hidden" id="token" class="form-control" name="token" value="{{request()->route()->parameters['token']}}">
            <input type="hidden" id="email" class="form-control" name="email" value="{{request()->route()->parameters['email']}}">
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
              <label class="label">Confrim Password</label>
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
              Reset Password
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
@endsection