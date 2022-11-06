@extends('layouts.dashboard')
@section('content')
@can('show_childcategory')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Child Category</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}


<div class="row">
    <div class="col-lg-9 m-auto">
        <div class="card">
            <div class="card-header">
                <h2>Child Category List</h2>
                @if (session('edit'))
                    <div class="alert alert-success"><strong>{{session('edit')}}</strong></div>
                @endif
                <span class="float-end nav-item"><a class="nav-link" href="{{route('trash.child.category')}}">View Trash</a></span>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success"><strong>{{session('success')}}</strong></div>
                @endif
                <div class="card">
                    <div class="table-responsive" id="no-more-tables">
                  <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>SL</td>
                            <td>Category Name</td>
                            <td>Subcategory Name</td>
                            <td>Child Category Name</td>
                            <td>Created At</td>
                            <td>Updated At</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($childcategories as $key=> $childcategorys)
                        <tr>
                            <td data-title="SL">{{$key+1}}</td>
                            <td data-title="Category Name">
                                @php
                                if(App\Models\Category::where('id', $childcategorys->category_id)->exists()){
                                    echo $childcategorys->rel_to_category->category_name;
                                }
                                else{
                                    echo 'Uncategorize';
                                }
                                @endphp
                            </td>
                            <td data-title="Subcategory Name">
                                @php
                                if(App\Models\subCategory::where('id', $childcategorys->subcategory_id)->exists()){
                                    echo $childcategorys->rel_to_subcategory->subcategory_name;
                                }
                                else{
                                    echo 'Uncategorize';
                                }
                                @endphp
                            </td>
                            <td data-title="Child Category">{{$childcategorys->childcategory_name}}</td>
                            <td data-title="Created At">{{$childcategorys->created_at->diffForHumans()}}</td>
                            <td data-title="Updated At">{{$childcategorys->updated_at}}</td>
                            <td data-title="Action">
                                @can('edit_childcatagory')
                                <a href="{{route('edit.childcategory', $childcategorys->id)}}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                @endcan
                                @can('del_childcatagory')
                                <button type="button" name="{{route('childcategory.soft.delete', $childcategorys->id)}}" class="delete btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></button>
                                @endcan
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

    @can('add_childcategory')
    <div class="col-lg-3">
        <div class="card">
            <div class="card-header">
                <h3>Add Child Category</h3>
            </div>
            <div class="card-body">
                <form action="{{url('/childcategory/insert')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Select Category</label>
                        <select name="category_id" class="form-control" id="category">
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
                        <label for="" class="form-label">Select Subcategory</label>
                        <select name="subcategory_id" class="form-control" id="subcategory">
                            <option value="">-- Select --</option>
                        @foreach ($subcategories as $subcategory)
                            <option value="{{$subcategory->id}}">{{$subcategory->subcategory_name}}</option>
                        @endforeach
                        </select>
                        @error('subcategory_id')
                            <strong class="text-danger mt-2">{{$message}}</strong>
                        @enderror
                        @if(session('exist'))
                        <strong class="text-danger mt-2">{{session('exist')}}</strong>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">Child Category Name</label>
                        <input type="text" class="form-control" name="childcategory_name">
                        @error('childcategory_name')
                            <strong class="text-danger mt-2">{{$message}}</strong>
                        @enderror
                        @if(session('exist'))
                        <strong class="text-danger mt-2">{{session('exist')}}</strong>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-info">Add Childcategory</button>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>
@endcan
@endsection

@section('footer_script')
{{-- child category delete --}}
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
{{-- ajax for get all category and sub category--}}
<script>
    $('#category').change(function(){

        var category_id = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:'POST',
            url:'/getSubcategory',
            data:{'category_id': category_id},
            success:function(data){
                $('#subcategory').html(data);
            }
        });

    });


</script>
@endsection
