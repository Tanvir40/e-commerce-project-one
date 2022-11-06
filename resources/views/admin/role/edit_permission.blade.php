@extends('layouts.dashboard')
@section('content')
@can('role_manager')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit/Role-permission</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}

    <div class="row">
        <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Permission</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('update.role.permission')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden"  name="role_id" value="{{$role->id}}">
                            <input type="text" class="form-control" value="{{$role->name}}" readonly>
                        </div>
                        <div class="mb-3">
                            <p>Permissions Name</p>
                            @foreach ($permissions as $permission)
                            <input type="checkbox" {{($role->hasPermissionTo($permission->name))?"checked":''}} value="{{$permission->id}}" name="permission[]"> {{$permission->name}},<br>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Update Permission</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endcan
@endsection
