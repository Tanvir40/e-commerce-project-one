@extends('frontend.master')
@section('content')
 <!-- breadcrumb_section - start
            ================================================== -->
            <div class="breadcrumb_section">
                <div class="container">
                    <ul class="breadcrumb_nav ul_li">
                        <li><a href="index.html">Home</a></li>
                        <li>My Account</li>
                    </ul>
                </div>
            </div>
            <!-- breadcrumb_section - end
            ================================================== -->
<style>
    @media screen and (max-width: 600px){
    td:first-child{
        background-color: #333;
        color: #fff;

    }
    #no-more-tables tbody,
    #no-more-tables tr,
    #no-more-tables td {
        display: block;
    }
    #no-more-tables thead tr {
        position: absolute;
        top: 9999px;
        left: 9999px;
    }
    #no-more-tables td {
        position: relative;
        padding-left: 50%;
    }
    #no-more-tables td:before {
        content: attr(data-title);
        position: absolute;
        left: 6px;
        font-weight: bold;
    }
}

</style>
            <!-- account_section - start
            ================================================== -->
            <section class="account_section section_space">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 account_menu">
                            <div class="nav account_menu_list flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link text-start active w-100" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Account Dashboard </button>
                                <button class="nav-link text-start w-100" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Acount</button>
                                <button class="nav-link text-start w-100" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">My Orders</button>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="tab-content bg-light p-3" id="v-pills-tabContent">
                                <div class="tab-pane fade show active text-center" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <h4>Welcome to Account</h4><br>
                                    <h5><span class="text-warning">{{Auth::guard('customerlogin')->user()->email}}</span></h5>
                                </div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                    <h5 class="text-center pb-3">Account Details</h5>
                                    <form class="row g-3 p-2" action="{{route('customer.account.update')}}" method="POST">
                                        @csrf
                                        <div class="col-md-6">
                                            <label for="inputnamel4" class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control" id="inputnamel4" value="{{Auth::guard('customerlogin')->user()->name}}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputEmail4" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" id="inputEmail4" value="{{Auth::guard('customerlogin')->user()->email}}" readonly>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="inputPassword4" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="inputPassword4">
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-primary active">Update</button>
                                        </div>
                                     </form>
                                    </div>
                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                    <h5 class="text-center pb-3">Your Orders</h5>
                                    <div class="table-responsive" id="no-more-tables">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Order No</th>
                                            <th>Order Date</th>
                                            <th>Sub Total</th>
                                            <th>Discount</th>
                                            <th>Delivery Charge</th>
                                            <th>Total</th>
                                            <th>Order-Status</th>
                                            <th>Action</th>
                                            <th>Invoice</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $key=>$order)
                                        <tr>
                                            <form action="{{route('update.status')}}" method="post">
                                                @csrf
                                            <td data-title="SL" class="bg-dark text-white">{{$key+1}}</td>
                                            <td data-title="Order No">{{$order->id}}</td>
                                            <td data-title="Order Date">{{$order->created_at->format('d-m-Y')}}</td>
                                            <td data-title="Sub Total">{{$order->subtotal}}</td>
                                            <td data-title="Discount">{{$order->discount}}</td>
                                            <td data-title="Delivery Charge">{{$order->charge}}</td>
                                            <td data-title="Total">{{$order->total}}</td>
                                            <td data-title="Order-Status">{{$order->rel_to_order_product->first()->rel_to_billing->status}}</td>

                                            @if (App\Models\BillingDetails::where('order_id', $order->id)->first()->status == 'delivered')
                                                    <td data-title="Action">
                                                        Delivered At-{{$order->rel_to_order_product->first()->rel_to_billing->updated_at->format('d-m-Y')}}
                                                    </td>
                                                @elseif (App\Models\BillingDetails::where('order_id', $order->id)->first()->status == 'processing')
                                                    <td data-title="Action">
                                                        Shipped At-{{$order->rel_to_order_product->first()->rel_to_billing->updated_at->format('d-m-Y')}}
                                                    </td>
                                                @elseif (App\Models\BillingDetails::where('order_id', $order->id)->first()->status == 'cencel')
                                                    <td data-title="Action">
                                                        Cenceled At-{{$order->rel_to_order_product->first()->rel_to_billing->updated_at->format('d-m-Y')}}
                                                    </td>
                                                @else
                                                <td data-title="Action">
                                                    <input type="hidden" name="order_id" value="{{$order->id}}">
                                                    <input type="hidden" name="status" value="cencel">
                                                    <button type="submit" class="btn-sm btn-success">Cencel Order</button>
                                                </td>
                                                @endif
                                            <td data-title="Invoice">
                                                <a href="{{route('invoice.download', $order->id)}}" class="btn-sm btn-primary">Invoice</a>
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
                </div>
            </div>
            </section>
    <!-- account_section - end
    ================================================== -->
@endsection
