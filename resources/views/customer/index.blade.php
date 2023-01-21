@extends('layouts.app')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Customers</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
						<li class="breadcrumb-item active">Customers</li>
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
										<th>First Name</th>
										<th>Job Title</th>
									 <th>Email Address</th>
										<th>Phone</th>
										<th>Registered since</th>
									</tr>
								</thead>
								<tbody>
									@if (count($customertData) > 0)
										@foreach ($customertData as $data)
											<tr>
												<td scope="row">{{ $data->first_name }}</td>
												<td>{{ $data->job_title  }}</td>
												<td>{{ $data->email_address  }}</td>
												<td>{{ $data->phone  }}</td>
												<td>{{ date("F j, Y",strtotime($data->registered_since))  }}</td>
												
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
							{!! $customertData->links('pagination::bootstrap-4') !!}
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
