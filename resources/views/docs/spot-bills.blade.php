@extends('layout.master')

@section('style')
	<link rel="stylesheet" href="{{ URL::asset('style/spot-bills.css') }}">
@endsection
@section('header')
	@include('include.dashboardheader')
@endsection
@section('content')
	<div id="wrapper">
		
@include('include.sidebar');

		<!------Content------>
		<div id="page-content-wrapper">
			<div class="container-fluid db-title">
				<div class="row">
					<div class="col-md-12">
						<h2 style="color: #d5d5d5;">Dashboard / Bills / Spot Bills</h2>
						<hr class="db-hr">
					</div>
				</div>

				<div class="row">
					<div class="col-md-4 col-sm-push-8">
						<div class="details">
							<h4>Select Date</h4>
							<hr>
							{!! Form::open(array('route' => 'getspotbills', 'method'=>'POST')) !!}
							<div class="row">
								<div class="form-group">
									<label for="date" class="col-sm-4 control-label">Date:</label>
									<div class="col-sm-8">
										{!! Form::select('date', $item2, null,array('class' => 'form-control','id'=>'year','title'=>'Select Date')); !!}
									</div>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="form-group">
									<div class="col-sm-12">
										{!! Form::submit('GET BILL',array('class' => 'btn btn-primary btn-block','name'=>'submit')) !!}
									</div>
								</div>
							</div>
							{!! Form::close() !!}
							<p><hr></p>
							<div class="row">
								<div class="col-md-12">
									<a class="btn btn-danger btn-block disabled" href="#" role="button">DOWNLOAD</a>	
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-8 col-sm-pull-4">
						<div class="details">
							
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

		<!----Menu Toggle Script and Graph---->
	<script>


		$("#menu-toggle").click( function(e){
			e.preventDefault();
			$("#wrapper").toggleClass("toggled");
		});

	</script>

@endsection