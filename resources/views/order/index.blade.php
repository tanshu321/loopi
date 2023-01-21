@extends('layouts.app')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Orders</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
						<li class="breadcrumb-item active">Order</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>
	<section class="content">
		<div class="container-fluid">
			@if (\Session::has('success'))
			<div class="alert alert-success alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Success</h4>
					{{ \Session::get('success') }}
			</div><br />
		@endif
		@if (\Session::has('error'))
		<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-close"></i> Error</h4>
				{{ \Session::get('error') }}
		</div><br />
	@endif
			<div class="row" style="padding-top: 10px;">

				<div class="col-12">

					<div class="card">
						<div class="card-body">
							<table id="example2" class="table table-bordered table-hover yajra-datatable">
								<thead>
									<tr>
										<th width="10%">ID</th>
										<th width="50%">Customer Name</th>
										<th width="20%">Total</th>
										<th width="10%">Status</th>
										<th width="10%">Action</th>
									</tr>
								</thead>
								<tbody>
									@if (count($orderData) > 0)
										@foreach ($orderData as $data)
										@php
												$customer = App\Models\Customer::find($data->customer_id);
											
										@endphp
											<tr>
												<td>{{ $data->id }}</td>
												<td >{{ $customer->first_name }}</td>
												<td>{{ number_format($data->total,2)  }}</td>
												<td>{{ $data->status==1 ? "Paid" : "Unpaid"  }}</td>
												<td><a href="{{ url('order/'.$data->id) }}" class="btn btn-block btn-primary btn-sm">View</button></td>
											</tr>
										@endforeach
									@else
										<tr>
											<td colspan="3">No record found</td>
										</tr>
									@endif
								</tbody>

							</table>
							
						</div>
						<div class="card-footer clearfix">
						<div class="d-flex justify-content-center">
							{!! $orderData->links('pagination::bootstrap-4') !!}
						</div>
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
