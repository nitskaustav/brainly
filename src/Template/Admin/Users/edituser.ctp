<?php //pr($user); //exit; ?>


<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Edit User </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Edit User</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group"> 
                                        <a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "add"]); ?>">
                                            <button class="btn btn-xs btn-success close-box"> <i class="icon-plus"></i> Add User</button></a>
                                        <a href="<?php echo $this->Url->build(["controller" => "Users","action" => "listuser"]);?>"><button class="btn btn-xs btn-success close-box">
                                                <i class="icon-list"></i>List User</button></a>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-6">

                            <div class="row">
                                <?php echo $this->Form->create($user, ['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data', 'onsubmit' => "return validate();"]); ?>

                                                              
                        <div><h3><b>Basic Information</b></h3></div><br>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">First Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo $user->first_name ?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">User Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="username" name="username" class="form-control" value="<?php echo $user->username ?>"/>
                                    </div>
                                </div> 

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Gender</label>
                                    <div class="col-lg-8">
                                        <select name="gender" id="gender">
                                            <option value="Male" <?php if($user->gender == 'Male') echo " selected"; ?>>Male</option>
                                            <option value="Female" <?php if($user->gender == 'Female') echo " selected"; ?>>Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Year of birth</label>
                                    <select name="birth_year" id="birth_year">
                                        <option value="">Select Year</option>
                                        <?php for($i=2013;$i>=1900;$i--){ 
                                                if($i == $user->birth_year){
                                                    $yearselect = " selected";
                                                }
                                                else{
                                                    $yearselect = "";
                                                }

                                            ?>
                                            <option <?php echo $yearselect; ?>><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Month</label>
                                    <div class="col-lg-8">
                                        <select name="month" id="month">
                                            <option value=''>Select Month</option>
                                            <?php for($i=1;$i<=12;$i++){ 
                                                if($i == $user->month){
                                                    $monthselect = " selected";
                                                }
                                                else{
                                                    $monthselect = "";
                                                }

                                            ?>
                                                                                       
                                            <option value="<?php echo $i; ?>" <?php echo $monthselect; ?>><?php echo jdmonthname(gregoriantojd($i, 1, 1), CAL_MONTH_GREGORIAN_LONG); ?></option>
                                            
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Day</label>
                                    <select name="day" id="day">
                                        <option value="">Select Day</option>
                                        <?php for($j = 1;$j<=31;$j++){ 

                                                if($j == $user->day){
                                                    $dayselect = " selected";
                                                }
                                                else{
                                                    $dayselect = "";
                                                }

                                            ?>
                                            <option <?php echo $dayselect; ?> ><?php echo $j; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Email</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="email" name="email" class="form-control" readonly="readonly" value="<?php echo $user->email ?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Choose Level</label>
                                    <div class="col-lg-8">
                                    <select name="level" id="level">
                                        <option value="">Choose Level</option>
                                        <option <?php if($user->level == 'Primary School') echo " selected"; ?> >Primary School</option>
                                        <option <?php if($user->level == 'Secondary School') echo " selected"; ?> >Secondary School</option>
                                    </select>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label class="control-label col-lg-4">Password</label>
                                    <div class="col-lg-8">
                                        <input type="password" id="epassword" name="epassword" class="form-control" value=""/>
                                    </div>
                                </div> --> 
                                    
                              <!-- <input  type="hidden" id="lat" name="latitude" value="<?php echo $user->latitude ?>"/>
                              <input  type="hidden" id="long" name="longitude" value="<?php echo $user->longitude ?>"/> -->
                               
                              
                              <!-- <div class="form-group">
                                    <label class="control-label col-lg-4">Town/City</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="city" name="city" value="<?php echo $user->city ?>" class="form-control" value=""/>
                                    </div>
                                </div> -->
                              
                              <!-- <div class="form-group">
                                    <label class="control-label col-lg-4">Country</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="country" name="country" value="<?php echo $user->country ?>" class="form-control" value=""/>
                                    </div>
                                </div> -->
                              
                              <!-- <div class="form-group">
                                    <label class="control-label col-lg-4">Postcode</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="postcode" name="postcode" value="<?php echo $user->postcode ?>" class="form-control" value=""/>
                                    </div>
                                </div> -->
                              
                              <div class="form-group">
                                  <label class="control-label col-lg-4">User Image </label>
                                  <div class="col-lg-8">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                            <?php $filePath = WWW_ROOT . 'user_img' .DS. $user->pimg; ?>
                                            <?php if ($user->pimg != "" && file_exists($filePath)) { ?>
                                                <img src="<?php echo $this->Url->build('/user_img/'.$user->pimg); ?>" width="150px" height="150px" />
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
                                    <input type="submit" name="submit" value="Edit User" class="btn btn-primary" />
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
<script src="<?php echo $this->request->webroot;?>js/bootstrap-datepicker.js"></script>
<script>
$(document).ready(function(){
    $('.subdate').datepicker({
    format:"yyyy-mm-dd",
    startDate:"today"
    });
});
</script>
<style>
    .datepicker{
        background:white !important;
    }    
</style>   

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

<script type="text/javascript">
    function validate(){
        if($("#first_name").val().search(/\S/) == -1){
            alert("First name cannot be empty");return false;
        }

        if($("#last_name").val().search(/\S/) == -1){
            alert("Surname cannot be empty");return false;
        }

        if($("#phone").val().search(/\S/) == -1){
            alert("Contact number cannot be empty");return false;
        }

        var phone = $("#phone").val();
        if(isNaN(phone)){
            alert("Contact number should be numeric");return false;
        }

        if(phone < 0){
            alert("Contact number should be non negative");return false;
        }

        var postcode = $("#postcode").val();
        if(isNaN(postcode)){
            alert("Postcode should be numeric");return false;
        }
        if(postcode < 0){
            alert("Postcode should be non negative");return false;
        }

        var acc_contact = $("#acc_contact").val();
        if(isNaN(acc_contact)){
            alert("Account contact should be numeric");return false;
        }
        if(acc_contact < 0){
            alert("Account contact should be non negative");return false;
        }

        var acc_email = $("#acc_email").val();
        var acc_email = acc_email.trim();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if(acc_email != ''){
            if (!filter.test(acc_email)) {
                alert('Please provide a valid email address');
                acc_email.focus;
                return false;
            }

        }
        

        var acc_phone = $("#acc_phone").val();
        if(isNaN(acc_phone)){
            alert("Account phone should be numeric");return false;
        }
        if(acc_phone < 0){
            alert("Account phone should be non negative");return false;
        }

        return true;

    }
</script>