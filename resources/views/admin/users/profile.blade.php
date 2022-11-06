@extends('layouts.dashboard')
@section('content')
{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">Profile</li>
    </ol>
    </div>
    {{-- breadcrumb end --}}
<div class="row">
    {{-- form for changing name --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h2>Change Name</h2>
            </div>
            <div class="card-body">
                @if (session('n_success'))
                    <div class="alert alert-success"><strong>{{session('n_success')}}</strong></div>
                @endif
                <form action="{{url('/name/update')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Name</label>
                        <input type="text" class="form-control mb-2" name="name" value="{{Auth::user()->name}}">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

{{-- form for changing name --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h2>Change photo</h2>
            </div>
            <div class="card-body">
                @if (session('photo_success'))
                    <div class="alert alert-success"><strong>{{session('photo_success')}}</strong></div>
                @endif
                <form action="{{url('/photo/update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">photo</label>
                        <input type="file" class="form-control mb-2" name="profile_photo">
                        @error('profile_photo')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

    {{-- form for changing password --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h2>Change Password</h2>

            </div>
            <div class="card-body">
                @if (session('p_success'))
                    <div class="alert alert-success"><strong>{{session('p_success')}}</strong></div>
                @endif
                <form action="{{url('/password/update')}}" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="" class="form-label">Old Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password" class="form-control" name="old_password" placeholder="Enter your password">
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye"></span>
                            </div>
                        </div>
                        @if (session('wrong_pass'))
                            <strong class="text-danger pt-2">{{session('wrong_pass')}}</strong>
                        @endif
                        @if (session('same_pass'))
                            <strong class="text-danger pt-2">{{session('same_pass')}}</strong>
                        @endif
                        @error('old_password')
                            <strong class="text-danger pt-2">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-label">New Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password">
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye"></span>
                            </div>
                        </div>
                        @error('password')
                            <strong class="text-danger pt-2">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-label">Confirm Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password_confirmation" placeholder="Enter your password">
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>

                        @error('password_confirmation')
                            <strong class="text-danger pt-2">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
