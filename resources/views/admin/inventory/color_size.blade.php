@extends('layouts.dashboard')
@section('content')
{{-- @can('show_inventory_color') --}}
{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Inventory-color and size</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}
    <div class="row">

        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h2>Color name and Code list</h2>
                    @if (session('success_color'))
                        <div class="alert alert-success"><strong>{{session('success_color')}}</strong></div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="no-more-tables">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>SL</td>
                                <td>Color name</td>
                                <td>Color Code</td>
                                <td class="w-25">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($colors as $key=>$color)
                            <tr>
                                <td data-title="SL">{{$key+1}}</td>
                                <td data-title="Color name">{{$color->color_name}}</td>
                                <td data-title="Color Code"><span style="width:10px; height:10px; background-color:{{$color->color_code}};">{{$color->color_code}}</span></td>
                                {{-- @can('del_color') --}}
                                <td data-title="Action"><button type="button" name="{{route('color.delete', $color->id)}}" class="colordelete btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></button></td>
                                {{-- @endcan --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>

        {{-- @can('add_color_size') --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h2>Add Color Name</h2>
                </div>
                <div class="card-body">
                    <form action="{{url('/insert_color')}}" method="post">
                        @csrf
                        <div class="mt-3">
                            <label for="" class="form-label">new color name</label>
                            <input type="text" class="form-control " name="color_name">
                            @error('color_name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">new color code</label>
                            <input type="text" class="form-control" name="color_code">
                            @error('color_code')
                            <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Add color</button>
                </div>
                    </form>
            </div>
        </div>
        {{-- @endcan --}}



    </div>

<div class="row">

    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <h2>All sizes list</h2>
                @if (session('success_size'))
                    <div class="alert alert-success"><strong>{{session('success_size')}}</strong></div>
                @endif
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>SL</td>
                        <td>All Sizes</td>
                        <td class="w-25">Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sizes as $key=>$size)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$size->size}}</td>
                        {{-- @can('del_size') --}}
                        <td><button type="button" name="{{route('size.delete', $size->id)}}" class="sizedelete btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></button</td>
                        {{-- @endcan --}}
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- @can('add_color_size') --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h2>Add size</h2>
            </div>
            <div class="card-body">
                <form action="{{url('/insert_size')}}" method="post">
                    @csrf
                    <div class="mt-3">
                        <label for="" class="form-label">new size</label>
                        <input type="text" class="form-control" name="size">
                        @error('size')
                        <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Add size</button>
                </form>
            </div>
        </div>
    </div>
    {{-- @endcan --}}

</div>

{{-- @endcan --}}
@endsection

@section('footer_script')

    {{-- delete color success --}}
<script>
    $('.colordelete').click(function(){
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

{{-- delete size success --}}
<script>
    $('.sizedelete').click(function(){
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

