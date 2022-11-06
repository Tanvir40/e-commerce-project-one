@extends('layouts.dashboard')
@section('content')




            @foreach ($orders as $order)
            @endforeach

    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10 col-sm-11">

            <div class="horizontal-steps mt-4 mb-4 pb-5" id="tooltip-container">
                <div class="horizontal-steps-content">
                    <div class="step-item {{$order->rel_to_billing->status == 'pending'?'current':''}}">
                        <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom " title="{{$order->rel_to_billing->created_at->format('d/m/Y h i A')}}">Order Pending</span>
                    </div>
                    <div class="step-item {{$order->rel_to_billing->status == 'processing'?'current':''}}">
                        <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom " title="{{$order->rel_to_billing->updated_at->format('d/m/Y h i A')}}">Processing</span>
                    </div>
                    <div class="step-item {{$order->rel_to_billing->status == 'cencel'?'current':''}}">
                        <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom " title="{{$order->rel_to_billing->updated_at->format('d/m/Y h i A')}}">Cencel</span>
                    </div>
                    <div class="step-item {{$order->rel_to_billing->status == 'delivered'?'current':''}}">
                        <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom " title="{{$order->rel_to_billing->updated_at->format('d/m/Y h i A')}}">Delivered</span>
                    </div>
                </div>

                <div class="process-line" style="width:
                @if($order->rel_to_billing->status == 'pending')
                    0%;
                @elseif($order->rel_to_billing->status == 'processing')
                    33%;
                @elseif($order->rel_to_billing->status == 'cencel')
                    66%;
                @else
                    100%
                @endif
            "></div>
            </div>
        </div>
    </div>
    <!-- end row -->


    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Shipping Information</h4>

                    <h5>{{$order->rel_to_billing->name}}</h5>

                    <address class="mb-0 font-14 address-lg">
                        {{$order->rel_to_billing->email}}<br>
                       <abbr title="Phone"><b>Phone:</b> </abbr> {{$order->rel_to_billing->phone}} <br>
                        <abbr title="Address"><b>Address:</b> </abbr>{{$order->rel_to_billing->address}}<br>
                        <abbr title="Country"><b>Country:</b> </abbr>{{$order->rel_to_billing->rel_to_city->name}}, {{$order->rel_to_billing->rel_to_country->name}}<br>
                        <abbr title="Comapny"><b>Comapny:</b> </abbr>{{$order->rel_to_billing->company}}
                    </address>

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Billing Information</h4>

                    <ul class="list-unstyled mb-0">
                        <li>
                            <p class="mb-2"><span class="fw-bold me-2">Payment Method:</span> {{$order->rel_to_billing->payment_status}}</p>

                            <p class="mb-2"><span class="fw-bold me-2">Order Date:</span> {{$order->created_at->format('d/M/Y')}}<small class="text-muted">{{$order->created_at->format('h:i A')}}</small></p>

                            <p class="mb-2"><span class="fw-bold me-2">Transaction Id : </span> {{$order->rel_to_billing->trans_status}}</p>

                            <p class="mb-2"><span class="fw-bold me-2">Discount Amount:</span> {{$order->rel_to_order->discount}} BDT</p>

                            <p class="mb-2"><span class="fw-bold me-2">Total Product Price:</span> {{$order->rel_to_order->subtotal}} BDT</p>
                        </li>
                    </ul>

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Delivery Info</h4>

                    <div class="text-center">
                        <i class="mdi mdi-truck-fast h2 text-muted"></i>
                        <h5><b>UPS Delivery</b></h5>
                        <p class="mb-1"><b>Order ID :</b> {{$order->order_id}}</p>
                        <p class="mb-0"><b>Payment Mode :</b> {{$order->rel_to_billing->trans_status}}</p>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>


    <!-- end row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Items from Order ID : {{$order->order_id}}</h4>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Product Image</th>
                                <th>Item</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>
                                    <img width="50px" src="{{asset('/uploads/products/preview')}}/{{$order->rel_to_product->preview}}"
                                    class="img-fluid" alt="Product image" height="48">
                                </td>
                                <td>{{$order->rel_to_product->product_name}}</td>
                                <td>{{$order->first()->rel_to_color->color_name}}</td>
                                <td>{{$order->first()->rel_to_size->size}}</td>
                                <td>{{$order->quantity}}</td>
                                <td>{{$order->price}} BDT</td>
                                <td>{{$order->price*$order->quantity}} BDT</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Order Summary</h4>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Description</th>
                                <th>Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Total:</td>
                                <td>{{$order->rel_to_order->subtotal}} BDT</td>
                            </tr>
                            <tr>
                                <td>Shipping Charge :</td>
                                <td>+ {{$order->rel_to_order->charge}} BDT</td>
                            </tr>
                            <tr>
                                <td>Discount : </td>
                                <td>- {{$order->rel_to_order->discount}} BDT</td>
                            </tr>
                            <tr>
                                <th>Grand Total :</th>
                                <th>{{$order->rel_to_order->total}} BDT</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->

                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->
  @endsection
