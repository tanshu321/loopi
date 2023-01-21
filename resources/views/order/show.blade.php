@extends('layouts.app')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Order Show</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
						<li class="breadcrumb-item active">Order Show</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="callout callout-info">
						<h5><i class="fas fa-info"></i> Note:</h5>
						This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
					</div>

					<div class="invoice p-3 mb-3">

						<div class="row">
							<div class="col-12">
								<h4>
									<i class="fas fa-globe"></i> Demo, Inc.
									<small class="float-right">Date: {{ date('d/m/Y', strtotime($orderData->created_at)) }}</small>
								</h4>
							</div>

						</div>

						<div class="row invoice-info">
							<div class="col-sm-4 invoice-col">
								From
								<address>
									<strong>Demo, Inc.</strong><br>
								</address>
							</div>

							<div class="col-sm-4 invoice-col">
								To
								<address>
									<strong>{{ $customer->first_name }}</strong><br>

									Phone: {{ $customer->phone }}<br>
									Email: {{ $customer->email_address }}
								</address>
							</div>

							<div class="col-sm-4 invoice-col">

								<b>Order ID:</b> {{ $orderData->id }}<br>
								<b>Status:</b> {{ $orderData->status == 1 ? 'Paid' : 'Unpaid' }}<br>
							</div>

						</div>


						<div class="row">
							<div class="col-12 table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Product</th>
											<th>Subtotal</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($order_products as $order_product)
											<tr>
												<td>{{ $order_product->productname }}</td>
												<td>{{ $order_product->price }}</td>
											</tr>
										@endforeach


									</tbody>
								</table>
							</div>

						</div>

						<div class="row">

							<div class="col-6">

							</div>

							<div class="col-6">

								<div class="table-responsive">
									<table class="table">
										<tbody>
											<tr>
												<th style="width:50%">Subtotal:</th>
												<td>{{ number_format($orderData->total, 2) }}</td>
											</tr>

											<tr>
												<th>Total:</th>
												<td>{{ number_format($orderData->total, 2) }}</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>

						</div>


						<!--<div class="row no-print">
							<div class="col-12">

								<button type="button" id="btn_pay" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
									Payment
								</button>

							</div>-->
						</div>
					</div>

				</div>
			</div>

		</div>
	</section>
@endsection

@push('third_party_stylesheets')
@endpush

@push('third_party_scripts')

	
@endpush
