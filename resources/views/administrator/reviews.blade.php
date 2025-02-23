@extends('layouts.master_administrator')

@section('title', 'Home Page')

@section('content')


<div class="card has-table">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
          Reviews
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <table id="reviews">
          <thead>
          <tr>
            <th></th>
            <th>Reviewer</th>
            <th>Receiver</th>
            <th>Course</th>
            <th>Ratings</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          @php
            foreach($reviews as $review){
          @endphp
            <tr>
              <td class="image-cell"></td>
              <td data-label="Reviewer" class="--name">{{$review->reviewer->name}}</td>
              <td data-label="Receiver" class="--title">{{$review->receiver->name}}</td>
              <td data-label="Course" class="--category">{{$review->classes->title}}</td>
              <td data-label="Ratings" class="--category">{{$review->rating}} Stars</td>
              <td class="actions-cell">
                <div class="buttons right nowrap">
                  <a href="{{ route('administrator.review',[$review->_id]) }}" class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                    <span class="icon"><i class="fa-regular fa-eye"></i></span>
                  </a>
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
          $('#reviews').DataTable( {
              paging: true,
              responsive: true,
              pageLength: 10
          } );
          
      });

</script>

@endsection