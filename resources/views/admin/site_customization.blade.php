@extends('layouts.dashboard')
@section('content')
{{-- @can('site_customization') --}}
{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Site Customization</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}

<div class="row">
    {{-- upload logo --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3>Upload a Logo (Admin)</h3>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="" class="form-label">Upload image</label>
                    <input type="file" class="form-control mb-2">
                    <button type="submit" class="btn btn-info">Change Logo</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Change Logo Text --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3>Upload a Logo (Front Site)</h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="" class="form-label">Upload image</label>
                        <input type="file" class="form-control mb-2">
                        <button type="submit" class="btn btn-info">Change Logo</button>
                    </form>
                </div>
            </div>
        </div>
</div>


<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3>Add Logo Text (Admin)</h3>
            </div>
            <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="" class="form-label">Logo Text (Black)</label>
                <input type="text" class="form-control">
                <label for="" class="form-label">Logo Text (Blue)</label>
                <input type="text" class="form-control mb-2">
                <button type="submit" class="btn btn-info">Change Logo Text</button>
            </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Toll Us Free contact Number</h3>
            </div>
            <div class="card-body">
            <form action="" method="POST" >
                @csrf
                <label for="" class="form-label">Add Toll Us Free contact Number</label>
                <input type="text" class="form-control mb-2">
                <button type="submit" class="btn btn-info">Add number</button>
            </form>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3>Footer Social Media</h3>
                @if (session('social'))
                        <div class="alert alert-success"><strong>{{session('social')}}</strong></div>
                    @endif
            </div>
            <div class="card-body">
            <form action="{{route('socal.media')}}" method="POST" >
                @csrf
            <div class="mb-3">
                <label for="" class="form-label">Add Social page link</label>
                <input type="url" class="form-control" name="page_link" value="">
                @error('page_link')
                     <strong class="text-danger">{{$message}}</strong>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Icon Class Name</label>
                <input type="text" class="form-control" name="social_icon" id="social_icon" readonly>
                @error('social_icon')
                    <strong class="text-danger">{{$message}}</strong>
                @enderror
            </div>
            <div class="mb-3 overflow-scroll" style="height:250px; overflow : scroll; ">
                @foreach ($icons as $icon)
                    <span id="fa {{$icon}}" class="btn btn-dark m-2">
                      <i class="fa {{$icon}}"></i>
                    </span>
                  @endforeach
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-info">Add Social Icon</button>
            </div>
            </form>
            </div>
        </div>
    </div>


    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3>Footer Contact Info</h3>
            </div>
            <div class="card-body">
            <form action="" method="POST" >
                @csrf
                <label for="" class="form-label">Add Footer Contact Info Text</label>
                <textarea name="" id="" cols="30" rows="10" class="form-control mb-2"></textarea>
                <button type="submit" class="btn btn-info">Add Text</button>
            </form>
            </div>
        </div>
    </div>

</div>

{{-- @endcan --}}

@endsection


@section('footer_script')
<script>
    //icon class select jq
$('.btn-dark').click(function(){
  var id = $(this).attr('id');
    $('#social_icon').val(id);
});

</script>
@endsection
