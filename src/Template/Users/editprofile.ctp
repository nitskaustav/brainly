<section class="left-side-pannel-page py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-left-bar">
                <div class="navbar-expand-lg side-bar-area">
                    <div class="nav-side-menu-toggle">
                        <button class="navbar-toggler navbar-toggler-right collapsed btn btn-primary mb-3" type="button" data-toggle="collapse" data-target="#side-menu" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="ion-android-more-vertical"></i>
                        </button>
                    </div>
                    <?php echo $this->element('side_menu');?>
                    
                </div>
            </div>
            <div class="col-lg-9">
                <div class="right-side p-4">
                    <h2 class="mb-4">Edit Profile</h2>
                    <form action="<?php echo $this->Url->build(["controller" => "Users","action" => "editprofile"]);?>" method="post" class="form-area row">
                                <div class="form-group col-md-6">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="first_name" value="<?php echo $user->first_name;?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Surname</label>
                                    <input type="text" class="form-control" name="last_name" value="<?php echo $user->last_name;?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email Id</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $user->email;?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Mobile No</label>
                                    <input type="text" class="form-control" name="phone" value="<?php echo $user->phone;?>">
                                </div>                                
                                <div class="form-group col-md-6">
                                    <label>Address</label>
                                     <input class="form-control" id="autocomplete" name="address" type="text" onFocus=geolocate() value="<?php echo $user->address ?>"/>
                                     <input  type="hidden" id="lat" name="latitude" value="<?php echo $user->latitude ?>"/>
                                      <input  type="hidden" id="long" name="longitude" value="<?php echo $user->longitude ?>"/>
                                </div>
                                <div class="form-group col-md-6">
                                  <label>City</label>
                                  <input type="text" class="form-control" name="city" id="city" value="<?php echo $user->city ?>">
                              </div>
                              <div class="form-group col-md-6">
                                  <label>Country</label>
                                  <input type="text" class="form-control" name="country" id="country" value="<?php echo $user->country ?>">
                              </div>
                              <div class="form-group col-md-6">
                                  <label>Post Code</label>
                                  <input type="text" class="form-control" id="postcode" name="postcode" value="<?php echo $user->postcode ?>">
                              </div>
                                <!-- <div class="form-group col-md-12">
                                    <label>Upload Image</label>
                                    <div>
                                        <div class="file-upload">
                                          <label for="upload" class="file-upload__label">upload file </label>
                                          <input id="upload" class="file-upload__input" type="file" name="file-upload">
                                      </div>
                                    </div>
                                  
                                </div> -->
                                <div class="form-group col-md-12">
                                      <span class="font-weight-bold">Gender</span>
                                      <span class="radios mx-3">
                                          <input type="radio" name="gender" value="Male" <?php echo (($user->gender == 'Male')? 'checked' : '');?>>
                                          <span class="mx-2">Male</span>
                                      </span>
                                      <span class="radios mx-3">
                                          <input type="radio" name="gender" value="Female" <?php echo (($user->gender == 'Female')? 'checked' : '');?>>
                                          <span class="mx-2">Female</span>
                                      </span>
                              </div>
                                
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-primary btn-lg">Save Changes</button>
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