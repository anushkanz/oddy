@extends('layouts.master_administrator')

@section('title', 'Home Page')

@section('content')
<section class="is-hero-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="title">
      Profile {{$member->name}}
    </h1>
    <button class="button light">Button</button>
  </div>
</section>

<section class="section main-section">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account-circle"></i></span>
            Edit Profile
          </p>
        </header>
        <div class="card-content">
            <form>
              @csrf
              <div class="field">
                <label class="label">Avatar</label>
                <div class="field-body">
                  <div class="field file">
                    <label class="upload control">
                      <a class="button blue">
                        Upload
                      </a>
                      <input type="file">
                    </label>
                  </div>
                </div>
              </div>
            </form>
            <hr>
            <form method='post' action="{{ route('administrator.member.update') }}">
            <input type='hidden' name='task' value="details"> 
            <input type='hidden' name='id' value="{{$member->_id}}"> 
              @csrf
              <div class="field">
                <label class="label">Name</label>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                      <input type="text" autocomplete="on" name="name" value="{{ isset($member->name) ? $member->name : '' }}" class="input" required>
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
                      <input type="text" autocomplete="on" name="phone" value="{{ isset($member->phone) ? $member->phone : '' }}" class="input" required>
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
                      <input type="email" autocomplete="on" name="email" value="{{ isset($member->email) ? $member->email : '' }}" class="input" required>
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
            </form>
        </div>
      </div>
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            Profile
          </p>
        </header>
        <div class="card-content">
          <div class="image w-48 h-48 mx-auto">
            <img src="https://avatars.dicebear.com/v2/initials/john-doe.svg" alt="John Doe" class="rounded-full">
          </div>
          <hr>
          <div class="field">
            <label class="label">Name</label>
            <div class="control">
              <input type="text" readonly value="{{ isset($member->name) ? $member->name : '' }}" class="input is-static">
            </div>
          </div>
          <hr>
          <div class="field">
            <label class="label">Phone</label>
            <div class="control">
              <input type="text" readonly value="{{ isset($member->phone) ? $member->phone : '' }}" class="input is-static">
            </div>
          </div>
          <hr>
          <div class="field">
            <label class="label">E-mail</label>
            <div class="control">
              <input type="text" readonly value="{{ isset($member->email) ? $member->email : '' }}" class="input is-static">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection