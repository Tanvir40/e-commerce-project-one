@extends('layouts.dashboard')
@section('content')
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-outline-success">
                    <div class="card-header">
                        <h4 class="user-registration"><i class="mdi mdi-account-circle"></i> All Reports</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="no-more-tables">
                        <table id="alltableinfo" class="table table-bordered ">
                            <thead >
                                <tr>
                                    <th class="wd-15p">Date</th>
                                    <th class="wd-15p">Order ID</th>
                                    <th class="wd-15p">Customer Name</th>
                                    <th class="wd-20p">Amount</th>
                                    <th class="wd-25p">TNX Id</th>
                                    <th class="wd-10p">Status</th>
                                    <th class="wd-15p">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td data-title="Date">{{ $order->created_at}}</td>
                                        <td data-title="Order ID">{{ $order->id }}</td>
                                        <td data-title="Customer Name">{{ $order->rel_to_order_product->first()->rel_to_billing->name }}</td>
                                        <td data-title="Amount">{{ $order->total }}Tk</td>
                                        <td data-title="TNX Id">{{ $order->rel_to_order_product->first()->rel_to_billing->trans_status }}</td>
                                        <td data-title="Status">
                                            <span class="badge bg-success">{{ $order->rel_to_order_product->first()->rel_to_billing->status }}</span>
                                        </td>
                                        <td data-title="Action">
                                            <a class="btn btn-info btn-sm" href="{{route('orders.view', $order->id)}}">More Info</a>
                                            <a class="btn btn-success btn-sm" href="{{route('invoice.download', $order->id)}}">Invoice</a>
                                        </td>
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