@extends('layouts.app')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Products</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
						<li class="breadcrumb-item active">Products</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>
	<section class="content">
		<div class="container-fluid">
		
			<div class="row" style="padding-top: 10px;">

				<div class="col-12">

					<div class="card">
						<div class="card-body">
							<table id="example2" class="table table-bordered table-hover yajra-datatable">
								<thead>
									<tr>
										<th>Product Name</th>
										<th>Price</th>
									</tr>
								</thead>
								<tbody>
									@if (count($producttData) > 0)
										@foreach ($producttData as $data)
											<tr>
												<td scope="row">{{ $data->productname }}</td>
												<td>{{ $data->price  }}</td>
											
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
							{!! $producttData->links('pagination::bootstrap-4') !!}
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
