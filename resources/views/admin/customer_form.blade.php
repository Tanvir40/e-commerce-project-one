@extends('layouts.dashboard')

@section('content')
{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Customer-Form</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}

    <div class="row">

        <div class="col-lg-12">
            <div class="card">
              <div class="card-header mt-2">
                <h2>Customer Submitted Form List<span class="float-end"><h5 >Total Forms : {{$customer_form->total()}}</h5 ></span></h2>

              </div>
            <div class="card-body">
                <div class="table-responsive" id="no-more-tables">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Customer Name</th>
                            <th>Category Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Form Submitted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customer_form as $key=>$customer)
                        <tr>
                            <td data-title="SL">{{$customer_form->firstitem()+$key}}</td>
                            <td data-title="Customer Name">{{$customer->name}}</td>
                            <td data-title="Category Email">{{$customer->email}}</td>
                            <td data-title="Subject">{{$customer->subject}}</td>
                            <td data-title="Message">{{$customer->message}}</td>
                            <td data-title="Form Submitted">{{$customer->created_at->format('d/m/Y H:i A')}}</td>
                            <td data-title="Action">
                                <button type="submit" name="{{route('customer.form.delete',$customer->id)}}" class="delete btn btn-danger">Delete</i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                {{$customer_form->links()}}
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
