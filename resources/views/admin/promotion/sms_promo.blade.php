@extends('layouts.dashboard')
@section('content')
{{-- @can('sent_sms') --}}
{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Sms-Promotion</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3>Customer Number List</h3>
                @if (session('added_success'))
                    <div class="alert alert-success"><strong>{{session('added_success')}}</strong></div>
                @endif
                @if (session('Sent_success'))
                    <div class="alert alert-success"><strong>{{session('Sent_success')}}</strong></div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive" id="no-more-tables">
                <table class="table table-boardered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Customer Number</th>
                            <th>Created At</th>
                            <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($numbers as $key=>$number)
                        <tr>
                            <td data-title="ID">{{$key+1}}</td>
                            <td data-title="Customer Number">{{$number->customer_number}}</td>
                            <td data-title="Created At">{{$number->created_at}}</td>
                            <td data-title="Action">
                                <button class="delete btn btn-danger" type="button" name="{{route('sms.delete', $number->id)}}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

    {{-- @can('add_sms') --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Customer Number</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('insert.number')}}" method="POST">
                        @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Add a new Customer Number</label>
                        <input type="text" name="customer_number" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Number</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        {{-- @endcan --}}

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Write Sms</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('send.promo.sms')}}" method="POST">
                        @csrf
                   <textarea name="write_sms" id="" cols="30" rows="10" class="form-control"></textarea><br>
                   <button type="submit" class="btn btn-primary">Send Sms</button>
                </form>
                </div>
            </div>
        </div>

    </div>
    {{-- @endcan --}}
@endsection

@section('footer_script')
{{-- sms deleted --}}
<script>
    $('.delete').click(function(){
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
           var link = $(this).attr('name');
           window.location.href =link;
        }
        })
    })
</script>
@if(session('delete'))
<script>
    Swal.fire(
      'Deleted!',
      '{{session('delete')}}',
      'success'
    )
</script>
@endif
@endsection
