<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Invoice-{{$order_id}} For {{App\Models\BillingDetails::where('order_id',$order_id)->first()->name}}</title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
            .btn.btn-white, .btn.btn-white.disabled, .btn.btn-white.disabled:focus, .btn.btn-white.disabled:hover, .btn.btn-white[disabled], .btn.btn-white[disabled]:focus, .btn.btn-white[disabled]:hover {
                color: #2d353c;
                background: #fff;
                border-color: #d9dfe3;
            }
		</style>
	</head>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container">
	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="5">
						<table>
							<tr>
								<td class="title">
									<img src="https://tanvirhasantonmoy.com/front/images/logo/logo_1x.png" style="width: 100%; max-width: 300px" />
								</td>

								<td>
                                    <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print Invoice</a>
                                    <br>
									Invoice #: {{$order_id}}<br />
									Created: {{App\Models\Order::where('id',$order_id)->first()->created_at->format('d-m-y')}}
                                </td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="5">
						<table>
							<tr>
								<td>
									 Name : <b>{{App\Models\BillingDetails::where('order_id',$order_id)->first()->name}}</b> <br>
									Phone : <b>{{App\Models\BillingDetails::where('order_id',$order_id)->first()->phone}}</b><br>
									Email : <b>{{App\Models\BillingDetails::where('order_id',$order_id)->first()->email}}</b><br>
									Payment Status : <b>{{App\Models\BillingDetails::where('order_id',$order_id)->first()->payment_status}}</b><br>
								</td>

								<td>
									Company : <b>{{App\Models\BillingDetails::where('order_id',$order_id)->first()->company}}</b><br/>
                                    Address : <b>{{App\Models\BillingDetails::where('order_id',$order_id)->first()->address}}</b><br/>
                                    Order Status : <b>{{App\Models\BillingDetails::where('order_id',$order_id)->first()->status}}</b><br/>
                                    Transaction Id : <b>{{App\Models\BillingDetails::where('order_id',$order_id)->first()->trans_status}}</b><br/>

								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>Product Photo</td>
					<td>Item</td>
					<td>Qty</td>
					<td>Price</td>
					<td>Sub-Total</td>
				</tr>

                @foreach (App\Models\Orderproduct::where('order_id',$order_id)->get() as $product)
				<tr class="item">
					<td> <img width="75px" src="{{asset('/uploads/products/preview')}}/{{$product->rel_to_product->preview}}"
                        class="img-fluid" alt="Image"></td>
					<td>{{$product->rel_to_product->product_name}}</td>
					<td>{{$product->quantity}}</td>
					<td>{{$product->price}}</td>
					<td>{{$product->price * $product->quantity}}</td>
				</tr>
                @endforeach

                <tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>

				<tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td>Subtotal : </td>
					<td>{{App\Models\Order::where('id',$order_id)->first()->subtotal}}</td>
				</tr>

                <tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td>Discount : </td>
					<td>- {{App\Models\Order::where('id',$order_id)->first()->discount}}</td>
				</tr>

                <tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td>Delivery Charge : </td>
					<td>+ {{App\Models\Order::where('id',$order_id)->first()->charge}}</td>
				</tr>

                <tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td> <b>Grand Total :</b></td>
					<td><b>{{App\Models\Order::where('id',$order_id)->first()->total}}</b></td>
				</tr>

			</table>
		</div>
	</body>
</html>
