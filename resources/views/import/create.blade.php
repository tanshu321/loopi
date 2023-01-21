@extends('layouts.app')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Import CSV</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">

						<li class="breadcrumb-item"><a href="{{ url('import') }}">Import</a></li>
						<li class="breadcrumb-item active">Import CSV</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>
	<section class="content">
		<div class="container-fluid">

			<div class="row">

				<div class="col-12">

					<div class="card">
						<div class="card-body">
							<div class="col-md-6">

								<div class="card card-primary">

									{!! Form::open(array('url' => 'import','method'=>'POST',"enctype"=>"multipart/form-data")) !!}
										<div class="card-body">
											 @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Error!</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                @endif
											<div class="form-group">
												<label for="module">Module</label>
												{!! Form::select('module', ['1' => 'Customer', '2' => 'Product'],null,array('class' => 'form-control','id'=>'module')); !!}
											
											</div>
											<div class="form-group">
												<label for="exampleInputFile">File input (CSV only)</label>
												<div class="input-group">
													<div class="custom-file">
														{!! Form::file('filename', array('class' => 'custom-file-input')) !!}
														<label class="custom-file-label" for="exampleInputFile">Choose file</label>
													</div>
													
												</div>
											</div>
										</div>

										<div class="card-footer">
											<button type="submit" class="btn btn-primary">Submit</button>
										</div>
										{!! Form::close() !!}
								</div>
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
<script src="https://adminlte.io/themes/v3/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
	$(function () {
			bsCustomFileInput.init();
	});
	</script>
@endpush
