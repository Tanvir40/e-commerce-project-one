@extends('layouts.dashboard')
@section('content')

{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Customer-List</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="card">
                <div class="card-header">
                    <h2>Total Customer List: <span class="float-end"> {{$total_customer}}</span></h2>
                </div>
                <div class="card-body">
                <div class="table-responsive" id="no-more-tables">
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Email Verify</th>
                            <th>Joined</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_customer as $key=>$customer)
                            <tr>
                                <td data-title="Sl">{{$all_customer->firstitem()+$key}}</td>
                                <td data-title="Name">{{$customer->name}}</td>
                                <td data-title="Email">{{$customer->email}}</td>
                                @if($customer->email_verified_at == null)
                                    <td data-title="Email Verify">User not verify Yet</td>
                                @else
                                    <td data-title="Email Verify">{{$customer->email_verified_at->format('d/m/Y H:i A')}}</td>
                                @endif
                                <td data-title="Joined">{{$customer->created_at->format('d/m/Y H:i A')}}</td>
                                <td data-title="Action">
                                    <button type="submit" name="{{route('customer.list.delete',$customer->id)}}" class="delete btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    {{$all_customer->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_script')
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
