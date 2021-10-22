@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Outlate</h5>
    <div class="card-body">
      <form method="POST" action="/admin/store_outlate" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Name <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="name" placeholder="Enter title"  value="{{old('name')}}" class="form-control" required>
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Address <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="address" placeholder="Enter address"  value="{{old('address  ')}}" class="form-control" required>
         
        </div>

        <div class="form-group">
          <label for="description" class="col-form-label">Description</label>
          <textarea class="form-control" id="detail" name="description"></textarea>
        </div>


        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Latitude <span class="text-danger">*</span></label>
          <input id="inputTitle" type="number" name="latitude" placeholder="Enter latitude"  value="{{old('latitude  ')}}" class="form-control" step="any">
         
        </div>


        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Longitude <span class="text-danger">*</span></label>
          <input id="inputTitle" type="number" name="longitude" placeholder="Enter longitude"  value="{{old('longitude  ')}}" class="form-control"  step="any">
         
        </div>
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Phone Number <span class="text-danger">*</span></label>
          <input id="inputTitle" type="phone" name="phone" placeholder="Enter phone"  value="{{old('phone')}}" class="form-control" required>
          
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Start Time <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="start"   value="{{old('phone')}}" class="form-control" >
         
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">End Time <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="end"   value="{{old('time')}}" class="form-control" >
          
        </div>

        

        <div class="form-group">
                <label for="photo">Photo</label>
                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                  <input type ="file" name="image">
                </div>
                @if($errors->has('photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('photo') }}
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
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 120
      });
    });
</script>

<script>
  $('#is_parent').change(function(){
    var is_checked=$('#is_parent').prop('checked');
    // alert(is_checked);
    if(is_checked){
      $('#parent_cat_div').addClass('d-none');
      $('#parent_cat_div').val('');
    }
    else{
      $('#parent_cat_div').removeClass('d-none');
    }
  })
</script>
@endpush