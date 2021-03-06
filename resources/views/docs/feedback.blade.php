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

		<div id="page-content-wrapper">
			<div class="container-fluid db-title">
				<div class="row">
					<div class="col-md-12">
						<h2 style="color: #d5d5d5;">Dashboard / Feedback</h2>
						<hr class="db-hr">
					</div>
				</div>
				<div class="row">
					<div class="details bill">
						<div class="row">
							<div class="col-md-12">
								<h3>Feedback Form</h3>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								
								
								<div class="form-group">
									<textarea class="form-control" rows="8" placeholder="Your Feedback..."></textarea>
								</div>
								
								<div class="form-group">
									<a href="#" class="btn btn-primary">SUBMIT</a>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

<script>


		$("#menu-toggle").click( function(e){
			e.preventDefault();
			$("#wrapper").toggleClass("toggled");
		});

	</script>

@endsection