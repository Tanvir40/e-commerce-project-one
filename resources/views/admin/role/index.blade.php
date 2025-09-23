@extends('layouts.dashboard')
@section('content')

    <div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Role-Manager</li>
    </ol>
    </div>
    {{-- breadcrumb end --}}

    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h3>Role List</h3>
                    @if (session('assaign_role'))
                        <div class="alert alert-success"><strong>{{session('assaign_role')}}</strong></div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="no-more-tables">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Role Name</th>
                            <th>Permissions</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key=>$role)
                            <tr>
                                <td data-title="SL">{{$key+1}}</td>
                                <td data-title="Role Name">{{$role->name}}</td>
                                <td data-title="Permissions">
                                    @foreach ($role->getPermissionNames() as $permission)

                                            {{$permission}}

                                    @endforeach
                                </td>
                                <td data-title="Action">
                                    <a href="{{route('edit.permission', $role->id)}} " class="btn btn-info"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h3>User List</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="no-more-tables">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>User Name</th>
                            <th>Roles</th>
                            <th>Permissions</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key=>$user)
                            <tr>
                                <td data-title="SL">{{$key+1}}</td>
                                <td data-title="User Name">{{$user->name}}</td>
                                <td data-title="Roles">
                                    @forelse ($user->getRoleNames() as $role)
                                        {{$role}},
                                        @empty
                                        Not Assaigned Yet
                                    @endforelse
                                </td>
                                <td data-title="Permissions">
                                    @forelse ($user->getAllPermissions() as $permission)
                                        {{$permission->name}},
                                        @empty
                                        User dont have any permission
                                    @endforelse
                                </td>
                                <td data-title="Action">
                                    <a href="{{route('edit.permissions', $user->id)}} " class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                    <button type="button" name="{{route('remove.role', $user->id)}}" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                    <div class="card-header">
                        <h3>Add Permission</h3>
                    </div>
                    <div class="card-body">
                        <h5>
                            @if (session('add_permission'))
                            <div class="alert alert-success"><strong>{{session('add_permission')}}</strong></div>
                          @endif
                        </h5>
                        <form action="{{route('add.permission')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" class="form-control" name="permission_name" placeholder="Enter Permission Name">
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary" type="submit">Add Permission</button>
                            </div>
                        </form>
                    </div>
            </div>

                <div class="card">
                    <div class="card-header">
                        <h3>Add Role</h3>
                    </div>
                <div class="card-body">
                    <h5>
                        @if (session('add_role'))
                        <div class="alert alert-success"><strong>{{session('add_role')}}</strong></div>
                      @endif
                    </h5>
                    <form action="{{route('add.role')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control" name="role_name" placeholder="Enter Role Name">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Select Permission</label><br>
                            @foreach ($permissions as $permission)
                            <input type="checkbox" value="{{$permission->id}}" name="permission[]"> {{$permission->name}},<br>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Add Role</button>
                        </div>
                    </form>
                </div>
            </div>

                <div class="card">
                    <div class="card-header">
                        <h3>Assaign Role To User</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('assaign.role')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <select name="user_id" class="form-control">
                                <option value="">--Select User--</option>
                             @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                             @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <select name="role_id" class="form-control">
                                <option value="">--Select Role--</option>
                             @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                             @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Assaign Role</button>
                        </div>
                    </form>
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

