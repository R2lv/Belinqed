<template>
<div>

	<!-- Header Title Start -->
	<section class="inner-header-title blank">
		<div class="container">
			<h1>Modify Company</h1>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Header Title End -->

	<!-- General Detail Start -->
	<div class="detail-desc section">
		<div class="container white-shadow">
			<div class="row">
				<div class="detail-pic js">
					<div class="box">
						<input type="file" name="upload-pic[]" id="upload-pic" class="inputfile"/>
						<label for="upload-pic"><i class="fa fa-upload" aria-hidden="true"></i><span></span></label>
					</div>
				</div>
			</div>

			<div class="row bottom-mrg">
				<form class="add-feild">

					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Company Name">
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Company Tagline">
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<select class="form-control input-lg">
								<option>All Categories</option>
								<option>Software</option>
								<option>Hardware</option>
								<option>Machanical</option>
								<option>HR/Manager</option>
							</select>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Company CEO Name">
						</div>
					</div>
					<div class="col-md-12 col-sm-12">
						<textarea class="form-control" placeholder="Company Description"></textarea>
					</div>
				</form>
			</div>

			<div class="row no-padd">
				<div class="detail pannel-footer">
					<div class="col-md-12 col-sm-12">
						<div class="detail-pannel-footer-btn pull-right">
							<a href="#" class="footer-btn choose-cover">Choose Cover Image</a>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<!-- General Detail End -->

	<!-- Basic Full Detail Form Start -->
	<section class="full-detail">
		<div class="container">
			<div class="row bottom-mrg extra-mrg">
				<form>
					<h2 class="detail-title">Work Experience</h2>
					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
							<input type="text" class="form-control" placeholder="Email Address">
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-phone"></i></span>
							<input type="text" class="form-control" placeholder="Phone Number">
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-globe"></i></span>
							<input type="text" class="form-control" placeholder="Website Address">
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
							<input type="text" class="form-control" placeholder="Local E.g. It Park New">
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-birthday-cake"></i></span>
							<input type="text" id="company-dob" data-lang="en" data-large-mode="true" data-min-year="2017" data-max-year="2020" data-disabled-days="08/17/2017,08/18/2017" data-id="datedropper-0" data-theme="my-style" class="form-control" readonly="">
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-users"></i></span>
							<input type="text" class="form-control" placeholder="Employee E.g. 100-2500">
						</div>
					</div>

				</form>
			</div>

			<div class="row bottom-mrg extra-mrg">
				<form>
					<h2 class="detail-title">Social Profile</h2>
					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-facebook"></i></span>
							<input type="text" class="form-control" placeholder="Profile Link">
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-google-plus"></i></span>
							<input type="text" class="form-control" placeholder="Profile Link">
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-twitter"></i></span>
							<input type="text" class="form-control" placeholder="Profile Link">
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-instagram"></i></span>
							<input type="text" class="form-control" placeholder="Profile Link">
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-linkedin"></i></span>
							<input type="text" class="form-control" placeholder="Profile Link">
						</div>
					</div>

					<div class="col-md-6 col-sm-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-dribbble"></i></span>
							<input type="text" class="form-control" placeholder="Profile Link">
						</div>
					</div>

				</form>
			</div>

			<div class="row bottom-mrg extra-mrg">
				<form>
					<h2 class="detail-title">About Company</h2>
					<div class="col-md-12 col-sm-12">
						<textarea class="form-control textarea" placeholder="About Company"></textarea>
					</div>
					<div class="col-md-12 col-sm-12">
						<button class="btn btn-success btn-primary small-btn">Submit your company</button>
					</div>
				</form>
			</div>
		</div>
	</section>
	<!-- Basic Full Detail Form End -->

</div>
</template>