
	

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
									<div class="round rounded-circle text-uppercase"><span>INSERT PHOTOS</span></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-10">
								<form method="post" action="<?php echo $this->Url->build(["controller" => "Services","action" => "addservicestep2",$service->id]);?>" enctype='multipart/form-data'>
									<h5 class="mt-5 mb-4">Location</h5>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-4 col-form-label">Venue Address:</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="autocomplete" name="address" onFocus="geolocate()">
										</div>
									</div>
                                                                        
                              <input  type="hidden" id="lat" name="latitude" />
                              <input  type="hidden" id="long" name="longitude" /> 
                                                                        
                                                                        
									<div class="form-group row">
										<div class="col-sm-12">
											<iframe width="100%" height="300px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=37.0625,-95.677068&amp;spn=56.506174,79.013672&amp;t=m&amp;z=4&amp;output=embed"></iframe>
										</div>
									</div>
									<h5 class="mt-5 mb-4">Pricing</h5>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-4 col-form-label">Minimum Price:</label>
										<div class="col-sm-8">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1">$</span>
												</div>
												<input type="text" class="form-control" name="price">
											</div>
										</div>
									</div>
									
									<h5 class="mt-5 mb-4">Timing</h5>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-4 col-form-label">Opening Time:</label>
										<div class="col-sm-8">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1"><i class="ion-clock"></i></span>
												</div>
												<input type="text" class="form-control" name="start_time" id="timepicker">
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-4 col-form-label">Closing Time:</label>
										<div class="col-sm-8">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1"><i class="ion-clock"></i></span>
												</div>
												<input type="text" class="form-control" name="end_time" id="timepicker1">
											</div>
										</div>
									</div>
									
									<h5 class="mt-5 mb-4">Occupancy</h5>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-4 col-form-label">Max Occupancy:</label>
										<div class="col-sm-8">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1">Max occupancy</span>
												</div>
												<input type="text" class="form-control" name="max_occupancy">
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label for="staticEmail" class="col-sm-4 col-form-label">Square Footage:</label>
										<div class="col-sm-8">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1">Square Footage</span>
												</div>
												<input type="text" class="form-control" name="square_footage">
											</div>
										</div>
									</div>
									
									<h5 class="mt-4 mb-4">Venue Features</h5>
									<h6>Type of event</h6>
									<ul class="list-unstyled d-flex event-type-list flex-wrap">
									<?php foreach($eventname as $dt)
                                            { ?>	
                                                                            
                                                                            <li>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="customCheck<?php echo $dt->id; ?>" name="event_id[]" value="<?php echo $dt->id; ?>">
												<label class="custom-control-label" for="customCheck<?php echo $dt->id; ?>"><?php echo $dt->event_name; ?></label>
											</div>
										</li>
										
                                            <?php } ?>
										
										
										
									</ul>
									<h6>Amenities</h6>
									<ul class="list-unstyled d-flex event-type-list flex-wrap">
									<?php foreach($amenityname as $dt)
                                            { ?>	
                                                                            <li>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="customCheckami<?php echo $dt->id; ?>" name="amenity_id[]" value="<?php echo $dt->id; ?>">
												<label class="custom-control-label" for="customCheckami<?php echo $dt->id; ?>"><?php echo $dt->amenities_name; ?></label>
											</div>
										</li>
										
                                            <?php } ?>
										
										
										
									</ul>
									
									
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
 
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<?php echo $this->Html->script('mdtimepicker.js') ?>

<script>
  $(document).ready(function(){
    $('#timepicker').mdtimepicker(); //Initializes the time picker
  });
</script>

<script>
  $(document).ready(function(){
    $('#timepicker1').mdtimepicker(); //Initializes the time picker
  });
</script>
    
<script>     
      var placeSearch, autocomplete;   

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});   

             google.maps.event.addListener(autocomplete, 'place_changed', function() {
		      var place = autocomplete.getPlace();
		      var lat = place.geometry.location.lat();
		      var lng = place.geometry.location.lng();
		      $('#lat').val(lat);
                      $('#long').val(lng);
		    
		    });     
      }

     
      function geolocate() { 
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) { 
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>

 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQ9hl89w8uiMND1-cnmkTVnqGh37TDvvk&libraries=places&callback=initAutocomplete"
        async defer></script>