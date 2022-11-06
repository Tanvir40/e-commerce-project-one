<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="SSLCommerz">
    <title>Tanvir - E-Commerce Demo project</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>
<body class="bg-light">
<div class="container">
    @php
        session([
            'data'=>$data,
        ])
    @endphp

    <div class="row mt-5">
        <div class="col-md-4 order-md-2 mb-4 m-auto">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Contine For Payment</span>
            </h4>
            <form action="{{ url('/pay') }}" method="POST" class="needs-validation">
                @csrf
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">SubTotal</h6>
                        @foreach (App\Models\Cart::where('customer_id' , Auth::guard('customerlogin')->id())->get() as $prod_desp)
                        <small class="text-muted">{{$prod_desp->rel_to_product->product_name}} X {{$prod_desp->quantity}}</small> <br>
                        @endforeach
                    </div>
                    <span class="text-muted">{{$data['subtotal']}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Discount</h6>
                    </div>
                    <span class="text-muted">-{{$data['discount']}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Delivary Charge</h6>

                        @if ($data['charge'] == '60')
                            <small class="text-muted">Inside Dhaka</small>
                            @else
                            <small class="text-muted">Outside Dhaka</small>
                        @endif


                    </div>
                    <span class="text-muted">+{{$data['charge']}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (BDT)</span>
                    <input type="hidden" name="total" value="{{$data['subtotal'] -$data['discount'] + ($data['charge'])}}">
                    <strong>{{$data['subtotal'] -$data['discount'] + ($data['charge'])}} TK</strong>
                </li>
            </ul>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </form>
        </div>

    </div>

    
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</html>
