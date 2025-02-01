@extends('layouts.master_open_header')
@section('content')
<div class="container mx-auto auth-pages">
    <div class="row justify-content-center">
        <div class="width-60z">
            <div class="card">
                <h1 class="mb-[40px]">Login.</h1>
                <p class="login-text-z">Login to your customer or transporter account to gain access to your dashboard where you can find all the relevant information needed to ship or drive. </p>
                <div class="card-body">
                    <p class="pre-form-text">Your details</p>
                    <form class="common-form-z login-form-z" method="POST" action="{{ route('login.custom') }}">
                @csrf <!-- {{ csrf_field() }} -->
                        <div class="form-group mb-3">
                            <input type="text" placeholder="Email" id="email" class="form-control" name="email" required autofocus>
                        </div>

                        <div class="form-group mb-3">
                            <input type="password" placeholder="Password" id="password" class="form-control" name="password" required>
                            @if ($errors->has('emailPassword'))
                            <span class="text-danger">{{ $errors->first('emailPassword') }}</span>
                            @endif
                        </div>

                        <div class="form-group mb-3 text-black mt-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="login-btns">
                            <div class="input-btn-a"><a href="/forget_password" type="submit">Password reset</a></div>
                            <button type="submit" class="input-btn-red">Signin</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection