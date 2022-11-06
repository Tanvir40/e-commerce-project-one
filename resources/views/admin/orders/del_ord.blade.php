@extends('layouts.dashboard')
@section('content')
@can('show_delivered_orders')
{{-- breadcrumb start--}}
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Delivered Orders</a></li>
    </ol>
    </div>
    {{-- breadcrumb end --}}
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header m-auto">
                    <h2>All Delevered Orders</h2>
                </div>
                <div class="card-body">
                        @if (session('processing'))
                            <div class="alert alert-success"><strong>{{session('processing')}}</strong></div>
                        @endif
                        @if (session('cencel'))
                            <div class="alert alert-warning"><strong>{{session('cencel')}}</strong></div>
                        @endif
                        <div class="table-responsive" id="no-more-tables">
                            <table class="table table-centered mb-0">
                                <thead class="table-light">
                            <tr>
                                <th>Sl</th>
                                <th>Order/Invoice ID</th>
                                <th>User ID</th>
                                <th>Customer Name</th>
                                <th>Total Price</th>
                                <th>Order Status</th>
                                <th>Payment Method</th>
                                <th>Transaction Id</th>
                                <th>Order Date</th>
                                <th>More Info</th>
                                <th>Update Order</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key=>$order)
                            <tr>
                                <form action="{{route('update.status')}}" method="post">
                                    @csrf
                                    <td data-title="SL" class="bg-black text-dark">{{$key+1}}</td>
                                    <td data-title="Order/Invoice ID" class="text-body fw-bold">{{$order->order_id}}</td>
                                    <td data-title="User ID">{{$order->user_id}}</td>
                                    <td data-title="Customer Name">{{$order->name}}</td>
                                    <td data-title="Total Price">{{$order->rel_to_order->total}}</td>
                                    <td  data-title="Order Status">
                                        <h5><span class="badge badge-{{$order->status == 'pending'?'primary':'success'}}-lighten">{{$order->status}}</span></h5>
                                    </td>
                                    <td data-title="Payment Status">
                                        <h5><span class="badge badge-{{$order->payment_status == 'COD'?'primary':'success'}}-lighten"><i class="mdi mdi-coin"></i> {{$order->payment_status}}</span></h5>
                                    </td>
                                    <td data-title="Transaction Id">{{$order->trans_status}}</td>
                                    <td data-title="Order Date">
                                        {{$order->created_at->format('M d Y')}} <small class="text-muted">{{$order->created_at->format('h i A')}}</small>
                                    </td>
                                    <td data-title="More Info"><a class="text-primary" href="{{route('orders.view', $order->id)}}"target="_blank">More Info</a></td>
                                <td data-title="Update Order">
                                    <input type="hidden" name="order_id" value="{{$order->order_id}}">
                                    <input type="hidden" name="email" value="{{$order->email}}">
                                    <input type="hidden" name="phone" value="{{$order->phone}}">
                                    <select name="status" class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                        <option value="cencel">Cencel</option>
                                        <option value="processing">Processing</option>
                                    </select>
                                </td>
                                <td data-title="Action">
                                    <button type="submit" class="btn-sm btn-success">Update</button>
                                </td>
                            </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
