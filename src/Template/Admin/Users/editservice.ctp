<?php //pr($user); //exit; ?>

<style>
.slidecontainer {
    width: 100%;
}

.slider {
    -webkit-appearance: none;
    width: 100%;
    height: 15px;
    border-radius: 5px;
    background: #d3d3d3;
    outline: none;
    opacity: 0.7;
    -webkit-transition: .2s;
    transition: opacity .2s;
}

.slider:hover {
    opacity: 1;
}

.slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    background: #4CAF50;
    cursor: pointer;
}

.slider::-moz-range-thumb {
    width: 25px;
    height: 25px;
    border-radius: 50%;
    background: #4CAF50;
    cursor: pointer;
}
</style>

<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<?php echo  $this->Html->css('admin/mdtimepicker.css') ?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Edit Venue </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Edit Venue</h5>
                        <div class="toolbar">

                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-6">

                            <div class="row">
                                <?php echo $this->Form->create($user, ['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data']); ?>

                                <div><h3><b>Basic Information</b></h3></div><br>                                

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Venue Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="first_name" name="service_name" class="form-control" value="<?php echo $user->service_name ?>"/>
                                    </div>
                                </div>  

                                  
                                
                                 <div class="form-group">
                                    <label class="control-label col-lg-4">Venue Type</label>
                                    <div class="col-lg-8">
                                        <select class="form-control" name='venue_type_id'>
                                            
                                            <option value="">--Select Type--</option>
                                            <?php foreach($stname as $dt){?>
                                            <option value='<?php echo $dt->id;?>' <?php if($user->venue_type_id==$dt->id){echo 'selected';}?>><?php echo $dt->type_name;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Description</label>
                                    <div class="col-lg-8">
                                        <textarea  name="description" class="form-control"><?php echo $user->description?></textarea>
                                    </div>
                              </div>
                                
                                <div><h3><b>Contact Information</b></h3></div><br>     
                                <div class="form-group">
                                    <label class="control-label col-lg-4">First Name</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('cp_fname', array('class'=>'form-control','label' => false)); ?>
                                    </div>
                                </div>
                                    
                                    <div class="form-group">
                                    <label class="control-label col-lg-4">Last Name</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('cp_lname', array('class'=>'form-control','label' => false)); ?>
                                    </div>
                                </div>
                                    
                                    <div class="form-group">
                                    <label class="control-label col-lg-4">Email Address</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('cp_email', array('class'=>'form-control','label' => false,'type'=>'email')); ?>
                                    </div>
                                </div>
                                    
                                    <div class="form-group">
                                    <label class="control-label col-lg-4">Phone No.</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('cp_phone', array('class'=>'form-control','label' => false)); ?>
                                    </div>
                                </div>
                                
                                <div><h3><b>Location Information</b></h3></div><br> 
                              <div class="form-group">
                                    <label class="control-label col-lg-4">Location</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="autocomplete" name="address" type="text" onFocus=geolocate() value="<?php echo $user->address; ?>"/>
                                    </div>
                                </div>     
                                    
                              <input  type="hidden" id="lat" name="latitude" value="<?php echo $user->latitude; ?>" />
                              <input  type="hidden" id="long" name="longitude" value="<?php echo $user->longitude; ?>"/>
                                
<!--                              <div class="form-group">
                                    <label class="control-label col-lg-4">City</label>
                                    <div class="col-lg-8">
                                        <input class="form-control"  name="city_name" type="text" value="<?php echo $user->city_name; ?>"/>
                                    </div>
                              </div> 
                              
                              <div class="form-group">
                                    <label class="control-label col-lg-4">Country</label>
                                    <div class="col-lg-8">
                                        <input class="form-control"  name="country" type="text" value="<?php echo $user->country; ?>"/>
                                    </div>
                              </div>                                -->



                                 
                              
                             <div><h3><b>Price Information</b></h3></div><br> 
                              <div class="form-group">
                                    <label class="control-label col-lg-4">Pricing</label>
                                    <div class="col-lg-8">
                                        <input type="text"  name="price" value="<?php echo $user->price; ?>" class="form-control">
                                    </div>
                              </div>
                              
                              <div><h3><b>Timing</b></h3></div><br>  
                              <div class="form-group">
                                    <label class="control-label col-lg-4">Start Time</label>
                                    <div class="col-lg-4">
                                        <input type="text"  name="start_time"  id="timepicker" class="form-control">
                                        <input type="hidden"  name="start_time1" value="<?php echo $user->start_time; ?>">
                                    </div>
                                    <div class="col-lg-4"><b><?php echo $user->start_time; ?></b></div>
                              </div>
                              
                              
                              <div class="form-group">
                                    <label class="control-label col-lg-4">End Time</label>
                                    <div class="col-lg-4">
                                        <input type="text"  name="end_time"  id="timepicker1" class="form-control">
                                        <input type="hidden"  name="end_time1" value="<?php echo $user->end_time; ?>">
                                    </div>
                                    <div class="col-lg-4"><b><?php echo $user->end_time; ?></b></div>
                              </div>
                              
                              
                              
                              
                              <div><h3><b>Occupancy</b></h3></div><br> 
                              
                              <div class="form-group">
                                    <label class="control-label col-lg-4">Max Occupancy</label>
                                    <div class="col-lg-8">
                                        <input type="text"  name="max_occupancy" value="<?php echo $user->max_occupancy; ?>" class="form-control">
                                    </div>
                              </div>
                              
                              
                              <div class="form-group">
                                    <label class="control-label col-lg-4">Square Footage:</label>
                                    <div class="col-lg-8">
                                        <input type="text"  name="square_footage" value="<?php echo $user->square_footage; ?>"  class="form-control">
                                    </div>
                              </div>
                              
                              
                              <div><h3><b>Venue Features</b></h3></div><br> 
                              
                              <?php $etype_id=explode(',',$user->event_id); ?>
                                     <div class="form-group">
                                    <label class="control-label col-lg-4">Event Type</label>
                                    <div class="col-lg-8"> 
                                        <?php foreach($eventname as $dt)
                                            { ?>
                                                <div class="col-lg-1">
                                                    <input type="checkbox" name="event_id[]" value="<?php echo $dt->id; ?>" <?php if(in_array( $dt->id,$etype_id)){echo 'checked';}?>>
                                                </div>
                                                <div class="col-lg-7">
                                                    <?php echo $dt->event_name; ?> 
                                                </div>
                                                <div class="clearfix"></div>
                                            <?php
                                            }
                                        ?>
                                    </div>
                                </div>   
                                  
                                 
                                  <?php $atype_id=explode(',',$user->amenity_id); ?>  
                                  <div class="form-group">
                                    <label class="control-label col-lg-4">Amenities</label>
                                    <div class="col-lg-8"> 
                                        <?php foreach($amenityname as $dt)
                                            { ?>
                                                <div class="col-lg-1">
                                                    <input type="checkbox" name="amenity_id[]" value="<?php echo $dt->id; ?>" <?php if(in_array( $dt->id,$atype_id)){echo 'checked';}?>>
                                                </div>
                                                <div class="col-lg-7">
                                                    <?php echo $dt->amenities_name; ?>
                                                </div>
                                                <div class="clearfix"></div>
                                            <?php
                                            }
                                        ?>
                                    </div>
                                </div>  
                              
                              
                              
<!--                              <div class="form-group">
                                  <label class="control-label col-lg-4">Pricing</label>
                              <div class="slidecontainer col-lg-8">
                                RM<input type="range" min="100" max="200" name="price" value="<?php echo $user->price?>" class="slider" id="myRange">
                                <p>Value: <span id="demo"></span></p>
                              </div>
                              </div>-->
                              
                              
                                <div class="form-group">
                                  <label class="control-label col-lg-4">Venue Image </label>
                                  <div class="col-lg-8">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                            <?php $filePath = WWW_ROOT . 'service_img' .DS. $user->image; ?>
                                            <?php if ($user->image != "" && file_exists($filePath)) { ?>
                                                <img src="<?php echo $this->Url->build('/service_img/'.$user->image); ?>" width="150px" height="150px" />
                                            <?php } ?>
                                        </div>
                                      <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                        <input type="file" id="image" name="image" />
                                        </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                    </div>
                                  </div>
                                </div>
                                                             
                                
                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Edit Venue" class="btn btn-primary" />
                                </div>
                                <?php echo $this->Form->end();?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .datepicker{
        background:white !important;
    }    
</style>



<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<?php echo $this->Html->script('admin/mdtimepicker.js') ?>
<!--<script src="mdtimepicker.js"></script>-->
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
var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
}
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