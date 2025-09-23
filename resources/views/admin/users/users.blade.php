@extends('layouts.dashboard')
@section('content')
{{-- @can('user_list') --}}


{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Users</li>
    </ol>
    </div>
    {{-- breadcrumb end --}}
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="card">
                <div class="card-header">
                    <h2>Users List <span class="float-end">Total User: {{$total_user}}</span></h2>
                    @if (session('active'))
                        <div class="alert alert-success">{{session('active')}}</div>
                    @endif
                    @if (session('deactive'))
                        <div class="alert alert-warning">{{session('deactive')}}</div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="no-more-tables">
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Sl</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Active/Deactive</th>
                            <th>Joined</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_user as $key=>$user)
                            <tr>
                                <td>{{$all_user->firstitem()+$key}}</td>
                                <td data-title="Name">{{$user->name}}</td>
                                <td data-title="Email">{{$user->email}}</td>
                                <td data-title="Status">
                                    <div class="badge bg-{{$user->status == 2?'warning':'success'}}">{{$user->status == 2?'Deactive':'Active'}}</div>
                                </td>
                            @if ($user->status == 1)
                                <td  data-title="Active/Deactive"><a href="{{url('/deactive/user/'.$user->id)}}" class="btn-sm btn-secondary">Deactive User</a>
                                </td>
                            @else
                                <td data-title="Active/Deactive">
                                        <a href="{{url('/active/user/'.$user->id)}}" class="btn-sm btn-success">Active User</a>
                                </td>
                            @endif
                                <td data-title="Joined">{{$user->created_at}}</td>
                                <td data-title="Action">
                                    <button type="submit" name="{{route('user.delete',$user->id)}}" class="delete btn btn-danger">Delete</i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    {{$all_user->links()}}
                </div>
            </div>
        </div>
    </div>
    {{-- @endcan --}}
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
