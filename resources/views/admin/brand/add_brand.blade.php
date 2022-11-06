@extends('layouts.dashboard')
@section('content')
{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Brand</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}

    <div class="row">

        <div class="col-lg-9">
            <div class="card">
              <div class="card-header">
                <h2>Brand List</h2>
                {{-- @if (session('edit'))
                    <div class="alert alert-success"><strong>{{session('edit')}}</strong></div>
                @endif --}}
                {{-- <span class="float-end nav-item"><a class="nav-link" href="{{route('category.trash')}}">View Trash</a></span> --}}
              </div>
            <div class="card-body">
                <div class="table-responsive" id="no-more-tables">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Added By</th>
                            <th>Brand Name</th>
                            <th>Created At</th>
                            <th>updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brands as $key=>$brand)
                        <tr>
                            <td data-title="SL">{{$key+1}}</td>
                            <td data-title="Added By">
                                @php
                                if(App\Models\user::where('id', $brand->user_id)->exists()){
                                    echo $brand->rel_to_user->name;
                                }
                                else{
                                    echo 'N/A';
                                }
                                @endphp
                                </td>
                            <td data-title="Brand Name">{{$brand->brand_name}}</td>
                            <td data-title="Created At">{{$brand->created_at->diffForhumans()}}</td>
                            <td data-title="updated At">{{$brand->updated_at}}</td>
                            <td data-title="Action">
                                {{-- @can('edit_catagory')
                                <a href="{{route('category.edit', $brand->id)}}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                @endcan --}}
                                {{-- @can('del_catagory') --}}
                                <button type="button" name="{{route('brand.delete', $brand->id)}}" class="delete btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></button>
                                {{-- @endcan --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
            </div>
            </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card">
              <div class="card-header">
                <h2>Add Brand</h2>
              </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success"><strong>{{session('success')}}</strong></div>
                @endif

                <form action="{{url('/brand/insert')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Brand Name</label>
                    <input type="text" class="form-control" name="brand_name">
                </div>
                @error('brand_name')
                    <strong class="text-danger">{{$message}}</strong>
                @enderror
                <div class="form-group">
                    <label class="form-label">Brand Image</label>
                    <input type="file" class="form-control" name="brand_image">
                </div>
                @error('brand_image')
                    <strong class="text-danger">{{$message}}</strong>
                @enderror
                <br>
                <button type="submit" class="btn btn-info">Add Brand</button>
                </form>

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
