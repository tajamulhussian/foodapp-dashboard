@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Product</h5>
    <div class="card-body">
      <form method="post" action="{{route('product.update',$product->id)}}"  enctype="multipart/form-data">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="name" placeholder="Enter title"  value="{{$product->name}}" class="form-control" required>
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="summary" class="col-form-label">Description <span class="text-danger"></span></label>
          <textarea class="form-control" id="detail" name="detail">{{$product->detail}}</textarea>
          @error('summary')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        
        <div class="form-group">
          <label for="price" class="col-form-label">Price <span class="text-danger"></span></label>
          <input id="price" type="number" name="price" placeholder="Enter price"  value="{{$product->price}}" class="form-control">
          @error('price')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
       
      

        <div class="form-group">
          <label for="cat_id">Category <span class="text-danger">*</span></label>
          <select name="cat_id" id="cat_id" class="form-control" required>
            
              @foreach($categories as $key=>$cat_data)
                  <option value='{{$cat_data->id}}'
                    {{(($product->cat_id==$cat_data->id)? 'selected' : '')}}>{{$cat_data->name}}</option>
              @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="cat_id">Menu <span class="text-danger">*</span></label>
          <select name="menu_id" id="menu_id" class="form-control" required>
            
              @foreach($parent_menus as $key=>$cat_data)
                 @print_r($parent_menus)
                  <option value='{{$cat_data->id}}'
                    {{(($product->menu_id==$cat_data->id)? 'selected' : '')}}>{{$cat_data->name}}</option>
              @endforeach
          </select>
        </div>

        <div><b>Availability</b></div>
        <div class="row">
          <div class="col-md-6">
         
          <input type="checkbox" name="weekend" 
           @if ($product->weekend)
               checked
           @endif > <label><b>On Weekends</b></label>

        </div>
         <div class="col-md-6">
         <input type="checkbox" name="weekday"
           @if ($product->weekday)
               checked
           @endif > <label><b>On Weekdays</b></label>
         </div>
        </div>
        <hr>
        <div><b>Add Promo Card</b></div>
        <div class="row">
          <div class="col-md-6">
          <input  type="checkbox" name="promo" id="promo_checkbox"
          @if ($product->promo  )
               checked
           @endif > <label><b>Promo Card</b></label>
         </div>
        </div>
        <div class="form-group" style="display:" id="promo_desc">
          <label for="description" class="col-form-label">Promo Description</label>
          <textarea class="form-control" name="promo_desc">{{$product->promo_desc}}</textarea>
        </div>


       @foreach($file as $files)
         @if($files->path)
              <img src="{{ asset(''.$files->path)  }} " style="max-width:200px">
         @else
            <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:200px">
           @endif
       
       @endforeach
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
           <button class="btn btn-success" type="submit">Update</button>
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
  var  child_cat_id='{{$product->child_cat_id}}';
        // alert(child_cat_id);
        $('#cat_id').change(function(){
            var cat_id=$(this).val();

            if(cat_id !=null){
                // ajax call
                $.ajax({
                    url:"/admin/category/"+cat_id+"/child",
                    type:"POST",
                    data:{
                        _token:"{{csrf_token()}}"
                    },
                    success:function(response){
                        if(typeof(response)!='object'){
                            response=$.parseJSON(response);
                        }
                        var html_option="<option value=''>--Select any one--</option>";
                        if(response.status){
                            var data=response.data;
                            if(response.data){
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data,function(id,title){
                                    html_option += "<option value='"+id+"' "+(child_cat_id==id ? 'selected ' : '')+">"+title+"</option>";
                                });
                            }
                            else{
                                console.log('no response data');
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

        });
        if(child_cat_id!=null){
            $('#cat_id').change();
        }
      $('#promo_checkbox').click(function(){
       $('#promo_desc').toggle();;
      });
</script>
@endpush