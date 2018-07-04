	<section class="user-dashboard">
		<div class="container">
			<div class="row">
				<?php echo $this->element('side_menu');?>
				<div class="col-lg-9 col-md-8">
					<div class="edit-pro p-3 p-lg-4">
						<h5 class="common-title mb-3 pb-2">Add Venue</h5>
						<div class="row mb-5">
							<div class="col-lg-10 ml-auto mr-auto">
								<div class="step-holder d-flex justify-content-between">
									<div class="round rounded-circle text-uppercase active"><span>Basic Info</span></div>
									<div class="round rounded-circle text-uppercase"><span>VENUE DETAILS</span></div>
									<div class="round rounded-circle text-uppercase"><span>INSERT PHOTOS</span></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-10">
								<form method="post" action="<?php echo $this->Url->build(["controller" => "Services","action" => "addservice"]);?>" enctype='multipart/form-data'>
									<h5 class="mt-4 mb-4">Basic information</h5>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-4 col-form-label">Venue Name:</label>
										<div class="col-sm-8">
											<input type="text" class="form-control"  name="service_name">
										</div>
									</div>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-4 col-form-label">Venue Type:</label>
										<div class="col-sm-8">
                                                                                    <select class="form-control" name='venue_type_id'>

                                                                                        <option value="">--Select Type--</option>
                                                                                        <?php foreach ($stname as $dt) { ?>
                                                                                            <option value='<?php echo $dt->id; ?>'><?php echo $dt->type_name; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
										</div>
									</div>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-4 col-form-label">Description:</label>
										<div class="col-sm-8">
											<textarea class="form-control" rows="4" name="description"></textarea>
										</div>
									</div>
									
									<h5 class="mt-4 mb-4">Contact information</h5>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-4 col-form-label">First Name:</label>
										<div class="col-sm-8">
                                                                                    <input type="text" class="form-control" name="cp_fname">
										</div>
									</div>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-4 col-form-label">Last Name:</label>
										<div class="col-sm-8">
                                                                                    <input type="text" class="form-control" name="cp_lname">
										</div>
									</div>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-4 col-form-label">Email Address:</label>
										<div class="col-sm-8">
                                                                                    <input type="email" class="form-control" name="cp_email">
										</div>
									</div>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-4 col-form-label">Phone Number:</label>
										<div class="col-sm-8">
                                                                                    <input type="text" class="form-control" name="cp_phone">
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12 text-right mt-3">
                                                                                    <button type="submit" class="btn btn-primary btn-lg">Next <i class="ion-android-arrow-forward"></i></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</section>
    