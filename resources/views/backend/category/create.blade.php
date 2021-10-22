@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Category</h5>
    <div class="card-body">
      <form method="post" action="{{route('category.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="name" placeholder="Enter title"  value="{{old('name')}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

       

        
        {{-- {{$parent_menu}} --}}

        <!-- <div class="form-group " >
        <label> Menu</label>
          <select  class="form-control">
              <option value="">--Select any Menu--</option>
              @foreach($parent_menus as $key=>$parent_menu)
                  <option value='{{$parent_menu->name}}'>{{$parent_menu->name}}</option>
              @endforeach
          </select>
        </div> -->

        <!-- <div class="form-group">
                <label for="photo">Photo</label>
                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                  <input type ="file" name="image">
                </div>
                @if($errors->has('photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('photo') }}
                    </div>
                @endif
            </div> -->
        
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
