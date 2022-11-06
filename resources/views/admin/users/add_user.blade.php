@extends('layouts.dashboard')
@section('content')
@can('add_user')
{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Add User</li>
    </ol>
    </div>
    {{-- breadcrumb end --}}

    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Add new User</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success"><strong>{{session('success')}}</strong></div>
                    @endif
                    <form action="{{route('insert.user')}}" method="POST">
                        @csrf
                        <div class="mt-3">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control">
                            @error('name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                            @error('email')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Password</label>
                            <input type="text" name="password" class="form-control">
                            @error('password')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-info">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endcan
@endsection
