@extends('layouts.dashboard')
@section('content')
@can('edit_catagory')
{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Category</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}
<div class="container">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header">
                   <h2>Edit Category</h2>
                </div>
                <div class="card-body">
                <div class="card">
              <div class="card-header">
                <h2>Add Category</h2>
              </div>
              <!-- @if (session('success'))
              <div class="alert alert-success">{{session('success')}}</div>
              @endif -->
            <div class="card-body">
                <form action="{{url('/category/update')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Category Name</label>
                        <input type="hidden" class="form-control" name="id" value="{{$category_info->id}}">
                        <input type="text" class="form-control" name="category_name" value="{{$category_info->category_name}}">
                        @error('category_name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        @if(session('exist'))
                        <strong class="text-danger mt-2">{{session('exist')}}</strong>
                        @endif
                    </div>
                    <br>
                    <button type="submit" class="btn btn-info">Update Category</button>
                </form>
            </div>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan
@endsection
