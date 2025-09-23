@extends('layouts.dashboard')
@section('content')
{{-- @can('sent_email') --}}


{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Email-Promotion</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}
    <div class="row">

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Customer Email List</h3>
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
                                <th>Customer Email</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                                @foreach ($emails as $key=>$email)
                                <tr>
                                    <td data-title="ID">{{$key+1}}</td>
                                    <td data-title="Customer Email">{{$email->customer_email}}</td>
                                    <td data-title="Created At">{{$email->created_at}}</td>
                                    <td data-title="Action">
                                        <button class="delete btn btn-danger" type="button" name="{{route('email.delete', $email->id)}}">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>


        {{-- @can('add_email') --}}

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Customer Email</h3>
                </div>

                <div class="card-body">
                    <form action="{{route('insert.email')}}" method="POST">
                        @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Add a new Email</label><br>
                        @error('customer_email')
                        <strong class="text-danger mt-2">{{$message}}</strong>
                        @enderror
                        <input type="email" name="customer_email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Email</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

        {{-- @endcan --}}

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Write Email</h3>
                </div>
                <div class="card-body">
                <form action="{{route('send.promo.email')}}" method="POST">
                    @csrf
                   <textarea name="write_email" cols="30" rows="10" class="form-control"></textarea><br>
                   <button type="submit" class="btn btn-primary">Send Email</button>
                </form>
                </div>
            </div>
        </div>

    </div>
    {{-- @endcan --}}
@endsection

@section('footer_script')
{{-- email deleted --}}
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


