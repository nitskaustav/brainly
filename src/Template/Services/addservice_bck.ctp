<?php echo $this->element('profile_head');?>
<section class="pt-5 pb-5">
  <div class="container">
    <div class="row">
     
       <?php echo $this->element('side_menu');?>
      
      <div class="col-sm-9">
        <div class="bg-gray p-3">
            <form method="post" action="<?php echo $this->Url->build(["controller" => "Services","action" => "addservice"]);?>" enctype='multipart/form-data'>
            <div class="form-group row">
                                    <label class="control-label col-sm-4">Service Name</label>
                                    <div class="col-sm-8">
                                        <?php echo $this->Form->input('service_name', array('class'=>'form-control','label' => false)); ?>
                                    </div>
                                </div>
                                
                                
                               <div class="form-group row">
                                    <label class="control-label col-lg-4"> Service Type</label>
                                    <div class="col-lg-8"> 
                                        <?php foreach($stname as $dt)
                                            { ?>
                                        <div class="row"><div class="col-lg-1">
                                                    <input type="checkbox" name="service_type_id[]" value="<?php echo $dt->id; ?>">
                                                </div>
                                                <div class="col-lg-7">
                                                    <?php echo $dt->type_name; ?>
                                                </div></div>
                                        
                                        <div class="row form-group">
                                            <div class="col-md-6"><input type="text" name="min_price[]" placeholder="Min price" class="form-control"></div>
                                            <div class="col-md-6"><input type="text" name="max_price[]" placeholder="Max price" class="form-control"></div>
                                        </div>
                                            <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                
 
                               <div class="form-group row">
                                    <label class="control-label col-sm-4"> Models</label>
                                    <div class="col-sm-8"> 
                                        <?php foreach($stagname as $dt)
                                            { ?>
                                                <div class="col-sm-1">
                                                    <input type="checkbox" name="service_model_id[]" value="<?php echo $dt->id; ?>">
                                                </div>
                                                <div class="col-sm-7">
                                                    <?php echo $dt->model_name; ?> (<?php echo $dt->make->make_name; ?>)
                                                </div>
                                                <div class="clearfix"></div>
                                            <?php
                                            }
                                        ?>
                                    </div>
                                </div>   
                                  
                               <div class="form-group row">
                                    <label class="control-label col-sm-4"> Features</label>
                                    <div class="col-sm-8"> 
                                        <?php foreach($sfname as $dt)
                                            { ?>
                                                <div class="col-sm-1">
                                                    <input type="checkbox" name="service_feature_id[]" value="<?php echo $dt->id; ?>">
                                                </div>
                                                <div class="col-sm-7">
                                                    <?php echo $dt->feature_name; ?>
                                                </div>
                                                <div class="clearfix"></div>
                                            <?php
                                            }
                                        ?>
                                    </div>
                                </div>     
                                    
                                
<!--                               <div class="form-group row">
                                    <label class="control-label col-sm-4">Address</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" id="autocomplete" name="address" type="text" onFocus=geolocate() />
                                    </div>
                                </div>     
                                    
                              <input  type="hidden" id="lat" name="latitude" />
                              <input  type="hidden" id="long" name="longitude" />
                                
                              <div class="form-group row">
                                    <label class="control-label col-sm-4">City</label>
                                    <div class="col-sm-8">
                                        <input class="form-control"  name="city_name" type="text" />
                                    </div>
                              </div> 
                              
                              <div class="form-group row">
                                    <label class="control-label col-sm-4">Country</label>
                                    <div class="col-sm-8">
                                        <input class="form-control"  name="country" type="text" />
                                    </div>
                              </div>-->
                              
                              <div class="form-group row">
                                    <label class="control-label col-sm-4">Description</label>
                                    <div class="col-sm-8">
                                        <textarea  name="description" class="form-control"></textarea>
                                    </div>
                              </div>
                              

              
<!--                            <div class="form-group row"> 
                                  <label class="control-label col-sm-4">Service Image </label>
                                  <div class="col-sm-8">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                       
                                      <div><span class="btn btn-success"> 
                                        <input type="file" id="image" name="image" />
                                          </span></div>
                                    </div>
                                  </div>
                                </div>-->
            
            
            <div class="form-group row row">
              <div class="col-sm-12 text-center">
                <button type="submit" name="button" class="btn btn-success"><i class="fa fa-cloud-upload pr-2" aria-hidden="true"></i>UPDATE</button>
<!--                <button type="button" name="button" class="btn btn-danger"><i class="fa fa-refresh pr-2" aria-hidden="true"></i> RESET</button>-->
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
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