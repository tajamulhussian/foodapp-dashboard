<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>

@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">

  <div class="card-body"  style=" overflow:scroll;">
 
    <table class="table data-table">
    
      <thead>
        <tr>
            <th>ID</th>
            <th>d_address.</th>
            <th>d_charge</th>
            <th>gst_charge</th>
            <th>date</th>
            <th>time</th>
            <th>created_at</th>
            <th>updated_at</th>
            <th>deleted_at</th>
            <th>cart_id</th>
            <th>order_type</th>
            <th>user_id</th>
            <th>outlate</th>
            <th>status</th>
            <th>guest_id</th>
            <th>order_id</th>
            <th>amount</th>
            <th>driver_id</th>

        </tr>
      </thead>
      <tbody>
        <tr>
            <td>{{$order->id}}</td>
            <td>{{$order->d_address}}</td>
            <td>{{$order->d_charge}}</td>
            <td>{{$order->gst_charge}}</td>
            <td>{{$order->date}}</td>
            <td>{{$order->time}}</td>
            <td>{{$order->created_at}}</td>
            <td>{{$order->updated_at}}</td>
            <td>{{$order->deleted_at}}</td>
            <td>{{$order->cart_id}}</td>
            <td>{{$order->order_type}}</td>
            <td>{{$order->user_id}}</td>
            <td>{{$order->outlate}}</td>
            <td>{{$order->status}}</td>
            <td>{{$order->guest_id}}</td>
            <td>{{$order->order_id}}</td>
            <td>{{$order->amount}}</td>
            <td>{{$order->driver_id}}</td> 
          
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection



  <script>
       $(function () {
    
    var table = $('.data-table').DataTable({
          
    });
    
  });
        

  </script>
