@extends('layouts.master_administrator')

@section('title', 'Home Page')

@section('content')
<section class="is-hero-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="title">
      Review
    </h1>
  </div>
</section>

<section class="section main-section">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="fa-regular fa-user"></i></span>
            Create Review for {{$review->classes->title}} by {{$review->classes->instructor->name}}.
          </p>
        </header>
        <div class="card-content">
                <div class="field">
                    <label class="label">Rating</label>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <div class="select">
                                    {{$review->rating}} Stars
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             
              <div class="field">
                <label class="label">Comment</label>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                        <textarea id="comment" placeholder="Tel us about your experience" class="textarea" name="comment" rows="4" cols="50" disabled>
                            @php if(!empty($review->comment)){ @endphp
                                {{$review->comment}}
                            @php } @endphp
                        </textarea>
                    </div>
                  </div>
                </div>
              </div>
        </div>
      </div>
  </section>
@endsection