@extends('layouts.dashboard')
@section('content')
@can('edit_inventory')


{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Inventory-Edit</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <h2>Edit Inventory</h2>
                </div>
                <div class="card-body">
                    <form action="{{route('inventory.update')}}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" name="inventory_id" value="{{$inventories->id}}">
                        <input type="hidden" class="form-control" name="product_id" value="{{$inventories->product_id}}">

                        <label for="" class="form-label">Product Name</label>
                        <input type="text" class="form-control" value="{{$inventories->rel_to_product->product_name}}" readonly>

                    <label for="" class="form-label">Color</label>
                    <select name="color_id" class="form-control">
                        <option value="" class="form-control">-- select --</option>
                         @foreach ($colors as $color)
                             <option value="{{$color->id}}" {{($color->id == $inventories->color_id?'selected':'')}} class="form-control">{{$color->color_name}}</option>
                         @endforeach
                    </select>
                                @error('color_id')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                @enderror
                                <br>
                    <label for="" class="form-label">Size</label>
                    <select name="size_id" class="form-control">
                        <option value="" class="form-control">-- select --</option>
                        @foreach ($sizes as $size)
                            <option value="{{$size->id}}" {{($size->id == $inventories->size_id?'selected':'')}} class="form-control">{{$size->size}}</option>
                        @endforeach
                    </select>
                                @error('size_id')
                                    <strong class="text-danger mt-2">{{$message}}</strong>
                                @enderror
                                <br>
                    <label for="" class="form-label">Quantity</label>
                    <input type="number" name="quantity" value="{{$inventories->quantity}}" class="form-control">
                    <br>
                    <button type="submit" class="btn btn-primary">Update Inventory</button>
                </form>
                </div>
            </div>
        </div>
    </div>
    @endcan
@endsection
