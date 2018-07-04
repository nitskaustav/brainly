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
									<div class="round rounded-circle text-uppercase active"><span>VENUE DETAILS</span></div>
									<div class="round rounded-circle text-uppercase active"><span>INSERT PHOTOS</span></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-10">
								<form method="post" action="<?php echo $this->Url->build(["controller" => "Services","action" => "addservicestep3",$service->id]);?>" enctype='multipart/form-data'>
									<h5 class="mt-4 mb-4">Insert Photo</h5>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-4 col-form-label">Add File:</label>
										<div class="col-sm-8">
											<input type="file" class="form-control" name="image">
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12 text-right mt-3">
                                                                                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
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
    
    
