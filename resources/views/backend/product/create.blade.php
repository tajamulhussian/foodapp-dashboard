@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Product</h5>
    <div class="card-body">
      <form method="post" action="{{route('product.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="name" placeholder="Enter title"  value="{{old('name')}}" class="form-control" required>
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
 

        <div class="form-group">
          <label for="description" class="col-form-label">Description</label>
          <textarea class="form-control" id="detail" name="detail"></textarea>
        </div>

        <div class="form-group">
          <label for="price" class="col-form-label">Price <span class="text-danger"></span></label>
          <input id="price" type="number" name="price" placeholder="Enter price"  class="form-control" required>

        </div>
         
       
              {{-- {{$categories}} --}}

        <div class="form-group">
          <label for="cat_id">Category <span class="text-danger">*</span></label>
          <select name="cat_id" id="cat_id" class="form-control" required>
              <option value="">--Select any category--</option>
              @foreach($get_categories as $key=>$cat_data)
                  <option value='{{$cat_data->id}}'>{{$cat_data->name}}</option>
              @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="menu_id">Menu <span class="text-danger">*</span></label>
          <select name="menu_id" id="menu_id" class="form-control" required>
              <option value="">--Select any category--</option>
              @foreach($parent_menus as $key=>$cat_data)
                  <option value='{{$cat_data->id}}'>{{$cat_data->name}}</option>
              @endforeach
          </select>
        </div>
        <div><b>Availability</b></div>
        <div class="row">
          <div class="col-md-6">
          <input  type="checkbox" name="weekend"><label><b>On Weekends</b></label>
         </div>
         <div class="col-md-6">
          <input  type="checkbox" name="weekday"><label><b>On Weekdays</b></label>
         </div>
        </div>
        <hr>
        <div><b>Add Promo Card</b></div>
        <div class="row">
          <div class="col-md-6">
          <input  type="checkbox" name="promo" id="promo_checkbox"><label><b>Promo Card</b></label>
         </div>
        </div>
        <div class="form-group" style="display: none" id="promo_desc">
          <label for="description" class="col-form-label">Promo Description</label>
          <textarea class="form-control" name="promo_desc"></textarea>
        </div>
       
         <div class="form-group">
                <label for="photo">Photo</label>
                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                  <input type ="file" name="image">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
          </div>
         
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 100
      });

      $('#promo_checkbox').click(function(){
       $('#promo_desc').toggle();;
      });
    });

    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 150
      });
    });
    // $('select').selectpicker();

</script>

<script>
  $('#cat_id').change(function(){
    var cat_id=$(this).val();
    // alert(cat_id);
    if(cat_id !=null){
      // Ajax call
      $.ajax({
        url:"/admin/category/"+cat_id+"/child",
        data:{
          _token:"{{csrf_token()}}",
          id:cat_id
        },
        type:"POST",
        success:function(response){
          if(typeof(response) !='object'){
            response=$.parseJSON(response)
          }
          // console.log(response);
          var html_option="<option value=''>----Select sub category----</option>"
          if(response.status){
            var data=response.data;
            // alert(data);
            if(response.data){
              $('#child_cat_div').removeClass('d-none');
              $.each(data,function(id,title){
                html_option +="<option value='"+id+"'>"+title+"</option>"
              });
            }
            else{
            }
          }
          else{
            $('#child_cat_div').addClass('d-none');
          }
          $('#child_cat_id').html(html_option);
        }
      });
    }
    else{
    }
  })
</script>
@endpush