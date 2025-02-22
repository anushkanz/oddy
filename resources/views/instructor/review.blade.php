@extends('layouts.master_instructor')

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
            Create Review for {{$review->classes->title}} by {{$booking->classes->instructor->name}}.
          </p>
        </header>
        <div class="card-content">
          <form method="POST">

                <div class="field">
                    <label class="label">Rating</label>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <div class="select">
                                    <select name="rating">
                                        <option value="1" @php ( !empty($review->rating) && ($review->rating == 1) ? 'selected="selected' : '' ) @endphp > 1 <i class="fa-solid fa-star"></i></option>
                                        <option value="2" @php ( !empty($review->rating) && ($review->rating == 2) ? 'selected="selected' : '' ) @endphp > 2 <i class="fa-solid fa-star"></i></option>
                                        <option value="3" @php ( !empty($review->rating) && ($review->rating == 3) ? 'selected="selected' : '' ) @endphp > 3 <i class="fa-solid fa-star"></i></option>
                                        <option value="4" @php ( !empty($review->rating) && ($review->rating == 4) ? 'selected="selected' : '' ) @endphp > 4 <i class="fa-solid fa-star"></i></option>
                                        <option value="5" @php ( !empty($review->rating) && ($review->rating == 5) ? 'selected="selected' : '' ) @endphp > 5 <i class="fa-solid fa-star"></i></option>
                                    </select>
                                </div>
                            </div>
                            <p class="help">Required. Rating</p>
                        </div>
                    </div>
                </div>
             
              <div class="field">
                <label class="label">Comment</label>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                        <textarea id="comment" placeholder="Tel us about your experience" class="textarea" name="comment" rows="4" cols="50">
                            @php if(!empty($review->comment)){ @endphp
                                {{$review->comment}}
                            @php } @endphp
                        </textarea>
                    </div>
                    <p class="help">Required. Comment</p>
                  </div>
                </div>
              </div>
              <hr>
            </form>
        </div>
      </div>
  </section>
@endsection