@extends('layouts.master_open_header')
@section('content')

<section class="section main-section">
    <div class="card login-form-card">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="fa-solid fa-lock"></i></span>
          Verify Your Email Address
        </p>
      </header>
      <div class="card-content">
        <form method="POST" action="{{ route('login.verificaiton.send') }}">
          @csrf <!-- {{ csrf_field() }} -->
            <div class="field spaced">
              <label class="label">Before proceeding, please check your email for a verification link. If you did not receive the email,</label>
            </div>
          <hr>
          <div class="field grouped">
            <div class="control">
              <button type="submit" class="button blue">
              click here to request another
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
@endsection