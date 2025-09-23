@extends('layouts.dashboard')
@section('content')
{{-- @can('show_trash_subcategory') --}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Sub-category Trash</a></li>
    </ol>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card ">
              <div class="card-header">
                <h2>Trash SubCategory List</h2>
              </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success"><strong>{{session('success')}}</strong></div>
                @endif
                <div class="table-responsive" id="no-more-tables">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Sub Category Name</th>
                            <th>Created At</th>
                            <th>Deleted At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trash as $key=>$trashs)
                        <tr>
                            <td data-title="SL">{{$key+1}}</td>
                            <td data-title="Sub-Category">{{$trashs->subcategory_name}}</td>
                            <td data-title="Created At">{{$trashs->created_at->diffForhumans()}}</td>
                            <td data-title="Deleted At">{{$trashs->deleted_at->diffForhumans()}}</td>
                            <td data-title="Action">
                            <a href="{{route('subcategory.restore', $trashs->id)}}" class="btn btn-success">Restore
                            </a>
                            {{-- @can('del_trash_subcatagory') --}}
                                <button type="button" name="{{route('subcategory.hard.delete', $trashs->id)}}" class="delete btn btn-danger ">Delete
                                </button>
                            {{-- @endcan --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-danger">Delete Marked All</button>
            </form>
            </div>
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
