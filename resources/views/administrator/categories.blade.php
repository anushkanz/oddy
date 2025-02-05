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
          <div class="field">
            <label class="label">Category</label>
            <div class="control">
              <input type="text" name="category" class="input" required>
            </div>
            </div>
          <div class="field">
            <label class="label">Slug</label>
            <div class="control">
              <input type="text" name="slug" class="input" required>
            </div>
          </div>
          <div class="field">
            <label class="label">Description</label>
            <div class="control">
              <textarea type="text" name="description" class="input" required></textarea>
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


    <div class="card has-table">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
          Clients
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <table id="categories">
          <thead>
          <tr>
            <th></th>
            <th>Category</th>
            <th>Slug</th>
            <th>Description</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          @php
            foreach($categories as $category){
          @endphp
            <tr>
              <td class="image-cell"></td>
              <td data-label="Name">{{$category->name}}</td>
              <td data-label="Slug">{{$category->slug}}</td>
              <td data-label="Description">{{{{$category->description}}}}</td>
              <td class="actions-cell">
                <div class="buttons right nowrap">
                  <button class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                    <span class="icon"><i class="mdi mdi-eye"></i></span>
                  </button>
                  <button class="button small red --jb-modal" data-target="sample-modal" type="button">
                    <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                  </button>
                </div>
              </td>
            </tr>
          @php
            }
          @endphp
          </tbody>
        </table>
        
      </div>
    </div>
    <script type="text/javascript">

$(function() {
  $('#categories').DataTable( {
        paging: true,
        responsive: true,
        pageLength: 10
    } );
});

</script>
@endsection