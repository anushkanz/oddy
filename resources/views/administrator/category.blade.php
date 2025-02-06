@extends('layouts.master_administrator')

@section('title', 'Home Page')

@section('content')

<section class="section main-section">
    <div class="card">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="fa-solid fa-icons"></i></span>
          Category
        </p>
      </header>
      <div class="card-content">
        <form method='post' action="{{ route('administrator.category.update') }}">
        <input type='hidden' name='id' value="{{$category->_id}}"> 
        <input type='hidden' name='task' value="update"> 
        @csrf

          <div class="field">
            <label class="label">Category</label>
            <div class="control">
              <input type="text" name="name" value="{{ isset($category->name) ? $category->name : '' }}" class="input" required>
            </div>
            </div>
          <div class="field">
            <label class="label">Slug</label>
            <div class="control">
              <input type="text" name="slug" value="{{ isset($category->slug) ? $category->slug : '' }}" class="input" required>
            </div>
          </div>
          <div class="field">
            <label class="label">Description</label>
            <div class="control">
              <textarea type="text" name="description" class="input" required>{{ isset($category->description) ? $category->description : '' }}</textarea>
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
  </section>
@endsection