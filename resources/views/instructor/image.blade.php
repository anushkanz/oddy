@extends('layouts.master_instructor')

@section('title', 'Home Page')

@section('content')
<div class="grid gap-6 grid-cols-1 md:grid-cols-1 mb-6">
    <div class="card mb-6">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="fa-regular fa-image"></i></span>
          Images of {{$course_images->title}}
        </p>
      </header>
      <div class="card-content">
        <div class="chart-area">
          <div class="h-full">
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div></div>
              </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 listing-images-z">
            <input type='hidden' name='user' value="{{$user->_id}}">
            <input type='hidden' name='id' value="{{$course_images->id}}">
            <input type="hidden" id="token" name="token" value="{{csrf_token()}}"/>
                @foreach(json_decode($course_images->photo_gallery,true) as $imges)
                    <div class="image">
                    <input type="checkbox" id="removelist" name="removelist" value="{{$imges['name']}}" class="remove_list" />
                        <img src="{{$imges['path']}}">
                    </div>
                @endforeach    
            </div>
 
          </div>
        </div>
      </div>
      <hr>
        <div class="field">
        <div class="control">
            <a id="deleteButton" type="submit" class="button red">
                Delete Images
            </a>
        </div>
        </div>
    </div>
</div>
<script>
        $(document).ready(function(){

            $('#deleteButton').click(function(e) {
                e.preventDefault();
                let array = []; 
                $("input:checkbox[name=removelist]:checked").each(function() { 
                    array.push($(this).val()); 
                });
            
                var token =  $("input[name=token]").val();
                var id =  $("input[name=id]").val();
            
                console.log(array);
                
                if(array.length > 0){
                    $.ajax({
                        type:'POST',
                        url:"{{ route('instructor.image.ajax') }}",
                        data:{
                            _token:token, 
                            listingId:id,
                            images:array
                        },
                        success:function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: "success",
                                    title: "Update message",
                                    text: "You have successfully deleted images.",
                                    showCancelButton: false,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });    
                            }
                        }
                    });
                }else{
                    Swal.fire({
                        icon: "error",
                        title: "Error message",
                        text: "You have not select any image.",
                        showCancelButton: false,
                    }).then((result) => {
                        
                    });   
                }
                 
            });
        });
    </script>
@endsection