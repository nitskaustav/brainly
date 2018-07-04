<?php ?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Add User </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Add User</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group"> 

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
				<?php echo $this->Form->create($user,['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data', 'onsubmit' => "return validate();"]);?>
                                <input type="hidden" name="utype" id="utype" value="RU" />
                                <input type="hidden" name="is_active" id="is_active" value="1" />
                                <input type="hidden" name="is_mail_verified" id="is_mail_verified" value="1" />
                                
                                <div class="form-block">

                                <div><h3><b>Basic Information</b></h3></div><br>


                                <div class="form-group">
                                    <label class="control-label col-lg-4">First Name</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('first_name', array('class'=>'form-control','label' => false, 'id' => 'first_name')); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">User Name</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('username', array('class'=>'form-control','label' => false, 'id' => 'username')); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Gender</label>
                                    <div class="col-lg-8">
                                        <select class="form-control" name="gender" id="gender">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Year of birth</label>
                                    <div class="col-lg-8">
                                    <select class="form-control" name="birth_year" id="birth_year">
                                        <option value="">Select Year</option>
                                        <?php for($i=2013;$i>=1900;$i--){ ?>
                                            <option><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Month</label>
                                    <div class="col-lg-8">
                                        <select class="form-control" name="month" id="month">
                                            <option value=''>Select Month</option>
                                            <option selected value='1'>January</option>
                                            <option value='2'>February</option>
                                            <option value='3'>March</option>
                                            <option value='4'>April</option>
                                            <option value='5'>May</option>
                                            <option value='6'>June</option>
                                            <option value='7'>July</option>
                                            <option value='8'>August</option>
                                            <option value='9'>September</option>
                                            <option value='10'>October</option>
                                            <option value='11'>November</option>
                                            <option value='12'>December</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Day</label>
                                    <div class="col-lg-8">
                                    <select class="form-control" name="day" id="day">
                                        <option value="">Select Day</option>
                                        <?php for($j = 1;$j<=31;$j++){ ?>
                                            <option><?php echo $j; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Email</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('email', array('class'=>'form-control','label' => false, 'id' => 'email')); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Choose Level</label>
                                    <div class="col-lg-8">
                                    <select class="form-control" name="level" id="level">
                                        <option value="">Choose Level</option>
                                        <option>Primary School</option>
                                        <option>Secondary School</option>
                                    </select>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label class="control-label col-lg-4">Password</label>
                                    <div class="col-lg-8">
                                        <input type="password" id="password" name="password" class="form-control" value=""/>
                                    </div>
                                </div> -->
                                                            
                                                            
                                <div class="form-group"> 
                                  <label class="control-label col-lg-4">User Image </label>
                                  <div class="col-lg-8">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-preview thumbnail" style="width: 150px; height: 150px;">
                                        </div>
                                      <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                        <input type="file" id="image" name="image" />
                                        </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                    </div>
                                  </div>
                                </div>
                              
                              
                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Add User" class="btn btn-primary" />
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
</div>

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

        if($("#username").val().search(/\S/) == -1){
            alert("Username cannot be empty");return false;
        }

        var email = $("#email").val();
        var email = email.trim();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (!filter.test(email)) {
            alert('Please provide a valid email address');
            email.focus;
            return false;
        }

        if($("#password").val().search(/\S/) == -1){
            alert("Password cannot be empty");return false;
        }

        var password = $("#password").val();
        //var pass_filter = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
        var pass_filter = /(?=.*\d)(?=.*[A-Z]).{6,}/;
        if(!pass_filter.test(password)){
            alert("Password should contain 1 capital letter and one number and contain atleast 6 characters");return false;
        }

        return true;
    }
</script>