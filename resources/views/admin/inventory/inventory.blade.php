@extends('layouts.dashboard')
@section('content')
@can('show_inventory')
{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Inventory</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2>Inventory List</h2>
                    @if (session('inventory'))
                        <div class="alert alert-success"><strong>{{session('inventory')}}</strong></div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="no-more-tables">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product Name</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventories as $key=>$inventory)
                        <tr>
                          <td data-title="SL">{{$key+1}}</td>
                          <td data-title="Product Name">{{$inventory->rel_to_product->product_name}}</td>
                          <td data-title="Color">
                                    @php
                                        if(App\Models\Color::where('id', $inventory->color_id)->exists()){
                                            echo $inventory->rel_to_color->color_name;
                                        }
                                        else{
                                            echo 'N/A';
                                        }
                                    @endphp
                        </td>
                        <td data-title="Size">
                                    @php
                                        if(App\Models\Size::where('id', $inventory->size_id)->exists()){
                                            echo $inventory->rel_to_size->size;
                                        }
                                        else{
                                            echo 'N/A';
                                        }
                                    @endphp
                        </td>
                          <td data-title="Quantity">{{$inventory->quantity}}</td>
                          <td data-title="Action">
                              @can('edit_inventory')
                              <a href="{{route('inventory.edit', $inventory->id)}}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                              @endcan
                              @can('del_inventory')
                            <button type="button" name="{{route('inventory.delete', $inventory->id)}}" class="delete btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></button>
                            @endcan
                          </td>
                      </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>

        @can('add_inventory')
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h2>Add Inventory</h2>
                </div>
                <div class="card-body">
                    <form action="{{url('/insert/inventory')}}" method="post">
                        @csrf
                        <div class="mt-3">
                            <input type="hidden" name="product_id" class="form-control" value="{{$product_info->id}}">
                            <input type="text" readonly class="form-control" value="{{$product_info->product_name}}">
                        </div>

                        <div class="mt-3">
                            @error('color_id')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                           <select name="color_id" class="form-control">
                               <option value="" class="form-control">-- select --</option>
                                @foreach ($colors as $color)
                                    <option value="{{$color->id}}" class="form-control">{{$color->color_name}}</option>
                                @endforeach
                           </select>
                        </div>

                        <div class="mt-3">
                            @error('size_id')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                            <select name="size_id" class="form-control">
                                <option value="" class="form-control">-- select --</option>
                                @foreach ($sizes as $size)
                                    <option value="{{$size->id}}" class="form-control">{{$size->size}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-3">
                            @error('quantity')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                            <input type="number" class="form-control" value="" name="quantity" placeholder="Quantity">
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-success shadow btn-xs"> Add Inventory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endcan
    </div>


    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2>Meta Tags Keywords List</h2>
                    @if (session('tags_success'))
                        <div class="alert alert-success"><strong>{{session('tags_success')}}</strong></div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="no-more-tables">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Meta Keyword Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tags as $key=>$tag)
                        <tr>
                          <td data-title="SL">{{$key+1}}</td>
                          <td data-title="Quantity">{{$tag->tag_name}}</td>
                          <td data-title="Action">
                              @can('del_inventory')
                            <button type="button" name="{{route('tags.delete', $tag->id)}}" class="delete btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></button>
                            @endcan
                          </td>
                      </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>

        @can('add_inventory')
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h2>Add Meta Keyword</h2>
                    <span class="text-success">Meta Keywords For SEO</span>
                </div>
                <div class="card-body">
                    @error('tag_name')
                    <strong class="text-danger">{{$message}}</strong>
                    @enderror
                    <form action="{{url('/insert/tags')}}" method="post">
                        @csrf
                        <div class="mt-3">
                            <input type="text" readonly class="form-control" value="{{$product_info->product_name}}">
                            <input type="hidden" readonly class="form-control" value="{{$product_info->id}}" name="product_id">
                        </div>

                        <div class="mt-3">
                            <input type="text" name="tag_name" class="form-control">
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-success shadow btn-xs"> Add Keyword</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endcan
    </div>

    @endcan
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

