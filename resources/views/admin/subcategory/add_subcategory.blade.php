@extends('layouts.dashboard')
@section('content')
{{-- @can('show_subcategory') --}}
<div class="page-titles">
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
    <li class="breadcrumb-item active"><a href="javascript:void(0)">Sub-category</a></li>
</ol>
</div>

<div class="row">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h2>Sub Category List</h2>
                @if (session('success'))
                    <div class="alert alert-success"><strong>{{session('success')}}</strong></div>
                @endif
                <span class="float-end nav-item"><a class="nav-link" href="{{route('trash.sub.category')}}">View Trash</a></span>
            </div>
            <div class="card-body">
                @if (session('edit'))
                    <div class="alert alert-success"><strong>{{session('edit')}}</strong></div>
                @endif
                <div class="card">
                    <div class="table-responsive" id="no-more-tables">
                  <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>SL</td>
                            <td>Category Name</td>
                            <td>Sub Category Name</td>
                            <td>Created At</td>
                            <td>Updated At</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subcategories as $key=> $subcategorys)
                        <tr>
                            <td data-title="SL">{{$key+1}}</td>
                            <td data-title="Category Name">
                                @php
                                if(App\Models\Category::where('id', $subcategorys->category_id)->exists()){
                                    echo $subcategorys->rel_to_category->category_name;
                                }
                                else{
                                    echo 'Uncategorize';
                                }
                                @endphp
                            </td>
                            <td data-title="Sub-Category">{{$subcategorys->subcategory_name}}</td>
                            <td data-title="Created At">{{$subcategorys->created_at->diffForHumans()}}</td>
                            <td data-title="Updated At">{{$subcategorys->updated_at}}</td>
                            <td data-title="Action">
                                {{-- @can('edit_subcatagory') --}}
                                <a href="{{route('edit.subcategory', $subcategorys->id)}}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                {{-- @endcan
                                @can('del_subcatagory') --}}
                                <button type="button" name="{{route('subcategory.soft.delete', $subcategorys->id)}}" class="delete btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></button>
                                {{-- @endcan --}}
                            </td>
                        </tr>
                    </tbody>
                        @endforeach
                  </table>
                </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @can('add_subcategory') --}}
    <div class="col-lg-3">
        <div class="card">
            <div class="card-header">
                <h2>Add Sub Category</h2>
            </div>
            <div class="card-body">
                <form action="{{url('/subcategory/insert')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Select Category</label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Select --</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                        @endforeach
                        </select>
                        @error('category_id')
                            <strong class="text-danger mt-2">{{$message}}</strong>
                        @enderror
                        @if(session('exist'))
                        <strong class="text-danger mt-2">{{session('exist')}}</strong>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Sub Category Name</label>
                        <input type="text" class="form-control" name="subcategory_name">
                        @error('subcategory_name')
                            <strong class="text-danger mt-2">{{$message}}</strong>
                        @enderror
                        @if(session('exist'))
                        <strong class="text-danger mt-2">{{session('exist')}}</strong>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-dark">Add Subcategory</button>
                </form>
            </div>
        </div>
    </div>
    {{-- @endcan --}}
</div>
{{-- @endcan --}}
@endsection

@section('footer_script')
{{-- delete subcategory success --}}
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
