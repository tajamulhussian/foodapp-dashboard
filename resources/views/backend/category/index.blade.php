@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Category Lists</h6>
      <a href="{{route('category.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Category</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
      
        <table class="table table-bordered data-table" >
          <thead>
            <tr>
              <th></th>
              <th>Titlessss</th>
              <!-- <th>Parent Category</th> -->
              <!-- <th>Photo</th> -->
              <th>Action</th>
            </tr>
          </thead>
          
          <tbody>
          @if(!empty($categories) && $categories->count())
            @foreach($categories as $category)   
            
                <tr>
                    <td></td>
                    <td>{{$category->name}}</td>
                    <td>
                    <a href="{{route('category.edit',$category->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                       
                       <button class="btn btn-danger btn-sm dltBtn" value="{{$category->id}}"  style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </td>
                   
                </tr>  
            @endforeach
            @else
            <tr>
                <td colspan="10">There are no data.</td>
            </tr>
        @endif
          </tbody>
        </table>
        {!! $categories->links() !!}
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>
      
      $(function () {
    
    var table = $('.data-table').DataTable({
          
    });
    
  });

        // Sweet alert

        function deleteData(id){
            
        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var id=$(this).val();
              // alert(id);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                      $.ajax({
                        url: "category/"+id,
                       type: 'DELETE',
                      data: {
                            "id": id,
                          },
                      success: function(data) {
                 
                  window.location.reload();
                 }
            });
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush