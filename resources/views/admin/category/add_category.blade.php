@extends('layouts.dashboard')
@section('content')
{{-- @can('show_category') --}}
{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Category</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}

    <div class="row">

        <div class="col-lg-9">
            <div class="card">
              <div class="card-header">
                <h2>Category List</h2>

                <span class="float-end nav-item"><a class="nav-link" href="{{route('category.trash')}}">View Trash</a></span>
              </div>
            <div class="card-body">
                <form action="{{route('mark.delete')}}" method="POST">
                    @csrf
                <div class="table-responsive" id="no-more-tables">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><input id="checkAll" type="checkbox"></th>
                            <th>SL</th>
                            <th>Added By</th>
                            <th>Category Name</th>
                            <th>Created At</th>
                            <th>updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $key=>$category)
                        <tr>
                            <td><input type="checkbox" name="mark[]" value="{{$category->id}}"></td>
                            <td data-title="SL">{{$categories->firstitem()+$key}}</td>
                            <td data-title="Added By">
                            @php
                            if(App\Models\user::where('id', $category->user_id)->exists()){
                                echo $category->rel_to_user->name;
                            }
                            else{
                                echo 'N/A';
                            }
                            @endphp
                            </td>
                            <td data-title="Category Name">{{$category->category_name}}</td>
                            <td data-title="Created At">{{$category->created_at->diffForhumans()}}</td>
                            <td data-title="updated At">{{$category->updated_at}}</td>
                            <td data-title="Action">
                                {{-- @can('edit_catagory') --}}
                                <a href="{{route('category.edit', $category->id)}}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                {{-- @endcan
                                @can('del_catagory') --}}
                                <button type="button" name="{{route('category.soft.delete', $category->id)}}" class="delete btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></button>
                                {{-- @endcan --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$categories->links()}}
                <button type="submit" class="btn btn-danger">Mark Delete</button>
            </form>
            </div>
            </div>
            </div>
        </div>

        {{-- @can('add_category') --}}
        <div class="col-lg-3">
            <div class="card">
              <div class="card-header">
                <h2>Add Category</h2>
              </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success"><strong>{{session('success')}}</strong></div>
                @endif
                <form action="{{url('/category/insert')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="category_name">
                        @error('category_name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category Image</label>
                        <input type="file" class="form-control" name="category_image">
                        @error('category_image')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <br>
                    <button type="submit" class="btn btn-info">Add new</button>
                </form>
            </div>
            </div>
        </div>
        {{-- @endcan --}}

    </div>
    {{-- @endcan --}}
@endsection

@section('footer_script')
{{-- category deleted --}}
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
{{-- checkbox js --}}
<script>
    $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    </script>
@endsection
