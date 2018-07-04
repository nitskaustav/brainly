<?php //pr($user); //exit;    ?>


<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Edit Seller </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Edit Seller</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group"> 
                                        <a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "addserviceprovider"]); ?>">
                                            <button class="btn btn-xs btn-success close-box"> <i class="icon-plus"></i> Add Seller</button></a>
<!--                                        <a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "listserviceprovider"]); ?>"><button class="btn btn-xs btn-success close-box">
                                                <i class="icon-list"></i>List Service provider</button></a>-->
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <input type="hidden" name="is_mail_verified" id="is_mail_verified" value="1" />
                        <div class="col-sm-6">

                            <div class="row">
                                <?php echo $this->Form->create($user, ['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data']); ?>



                                <div class="form-group">
                                    <label class="control-label col-lg-4">First Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo $user->first_name;?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Last Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo $user->last_name ?>"/>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="control-label col-lg-4">Email</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="email" name="email" class="form-control" readonly="readonly" value="<?php echo $user->email ?>"/>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-lg-4">Contact Number</label>
                                    <div class="col-lg-8">
                                        <input type="text"  name="phone" value="<?php echo $user->phone ?>" class="form-control"/>
                                    </div>
                                </div>


                                <!--                                <div class="form-group">
                                                                    <label class="control-label col-lg-4">Password</label>
                                                                    <div class="col-lg-8">
                                                                        <input type="password" id="epassword" name="epassword" class="form-control" value=""/>
                                                                    </div>
                                                                </div>-->



                                <div class="form-group">
                                    <label class="control-label col-lg-4">Address</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="autocomplete1" name="address" type="text" value="<?php echo $user->address; ?>"/>
                                    </div>
                                </div>     

                                <input  type="hidden" id="lat" name="latitude" value="<?php echo $user->latitude ?>"/>
                                <input  type="hidden" id="long" name="longitude" value="<?php echo $user->longitude ?>"/>



                                <!--                              <div class="form-group">
                                                                    <label class="control-label col-lg-4">Website Link</label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text"  name="website" value="<?php echo $user->website ?>" class="form-control"/>
                                                                    </div>
                                                              </div>
                                                              
                                <?php $working = explode(',', $user->working_days); ?>
                                                              <div class="form-group">
                                                                    <label class="control-label col-lg-4">Working Days</label>
                                                                    <div class="col-lg-8"> 
                                                                        
                                                                                <div class="col-lg-1">
                                                                                    <input type="checkbox" name="working_days[]" value="Monday" <?php
                                if (in_array('Monday', $working)) {
                                    echo 'checked';
                                }
                                ?>>
                                                                                </div><div class="col-lg-7">Monday</div>
                                                                                <div class="clearfix"></div>
                                                                                <div class="col-lg-1">
                                                                                    <input type="checkbox" name="working_days[]" value="Tuesday" <?php
                                if (in_array('Tuesday', $working)) {
                                    echo 'checked';
                                }
                                ?>>
                                                                                </div><div class="col-lg-7">Tuesday</div>
                                                                                <div class="clearfix"></div>
                                                                                <div class="col-lg-1">
                                                                                    <input type="checkbox" name="working_days[]" value="Wednesday" <?php
                                if (in_array('Wednesday', $working)) {
                                    echo 'checked';
                                }
                                ?>>
                                                                                </div><div class="col-lg-7">Wednesday</div>
                                                                                <div class="clearfix"></div>
                                                                                
                                                                                <div class="col-lg-1">
                                                                                    <input type="checkbox" name="working_days[]" value="Thursday" <?php
                                if (in_array('Thursday', $working)) {
                                    echo 'checked';
                                }
                                ?>>
                                                                                </div><div class="col-lg-7">Thursday</div>
                                                                                <div class="clearfix"></div>
                                                                                
                                                                                <div class="col-lg-1">
                                                                                    <input type="checkbox" name="working_days[]" value="Friday" <?php
                                if (in_array('Friday', $working)) {
                                    echo 'checked';
                                }
                                ?>>
                                                                                </div><div class="col-lg-7">Friday</div>
                                                                                <div class="clearfix"></div>
                                                                                
                                                                                <div class="col-lg-1">
                                                                                    <input type="checkbox" name="working_days[]" value="Saturday" <?php
                                if (in_array('Saturday', $working)) {
                                    echo 'checked';
                                }
                                ?>>
                                                                                </div><div class="col-lg-7">Saturday</div>
                                                                                <div class="clearfix"></div>
                                                                                
                                                                                <div class="col-lg-1">
                                                                                    <input type="checkbox" name="working_days[]" value="Sunday" <?php
                                if (in_array('Sunday', $working)) {
                                    echo 'checked';
                                }
                                ?>>
                                                                                </div><div class="col-lg-7">Sunday</div>
                                                                                <div class="clearfix"></div>
                                                                            
                                                                    </div>
                                                                </div>
                                                              
                                                              
                                                              
                                                              
                                                              <div class="form-group">
                                                                    <label class="control-label col-lg-4">Working Hours</label>
                                                                    <div class="col-lg-8">
                                                                        
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                               <input type="text"  name="working_hours_from" value="<?php echo $user->working_hours_from ?>" class="form-control"/> 
                                                                            </div>
                                                                           
                                                                           <div class="col-sm-6">
                                                                               <input type="text"  name="working_hours_to" value="<?php echo $user->working_hours_to ?>" class="form-control"/> 
                                                                            </div> 
                                                                        </div>
                                                                       
                                                                    </div>
                                                                </div>-->


                                <div class="form-group">
                                    <label class="control-label col-lg-4">Description</label>
                                    <div class="col-lg-8">
                                        <textarea  name="description" class="form-control"><?php echo $user->description ?></textarea>
                                    </div>
                                </div>

                                <!--                              <div class="form-group">
                                                                    <label class="control-label col-lg-4">Pricing</label>
                                                                    <div class="col-lg-8">
                                                                        <textarea  name="pricing" class="form-control"><?php echo $user->pricing ?></textarea>
                                                                    </div>
                                                              </div>-->





                                <?php $stype_id = explode(',', $user->service_type_id); ?>    

                                <!--                            <div class="form-group">
                                                                    <label class="control-label col-lg-4">Service Type</label>
                                                                    <div class="col-lg-8"> 
                                <?php foreach ($servicetypes as $dt) {
                                    ?>
                                                                                            <div class="col-lg-1">
                                                                                                <input type="checkbox" name="service_type_id[]" value="<?php echo $dt->id; ?>" <?php
                                    if (in_array($dt->id, $stype_id)) {
                                        echo 'checked';
                                    }
                                    ?>>
                                                                                            </div>
                                                                                            <div class="col-lg-7">
                                    <?php echo $dt->type_name; ?>
                                                                                            </div>
                                                                                            <div class="clearfix"></div>
                                    <?php
                                }
                                ?>
                                                                    </div>
                                                                </div>
                                
                                
                                                                <div id="phone">
                                                                  
                                                                  </div>
                                                                    
                                                                  <label class="control-label col-lg-4"></label>
                                                                <div class="col-lg-8" style="text-align:left;"> 
                                                                    <div class="RegSpRight form-group">
                                                                        <button class="pl btn btn-primary btnsearch">Add New</button>&nbsp;<button class="mi btn btn-primary btnsearch" style="display: none">Remove</button>
                                                                    </div> 
                                                                </div>-->




                                <?php $stag_id = explode(',', $user->service_make_id); ?>    

                                <!--                            <div class="form-group">
                                                                    <label class="control-label col-lg-4">Car Maker</label>
                                                                    <div class="col-lg-8"> 
                                <?php foreach ($tags as $dt) {
                                    ?>
                                                                                            <div class="col-lg-1">
                                                                                                <input type="checkbox" name="service_make_id[]" value="<?php echo $dt->id; ?>" <?php
                                    if (in_array($dt->id, $stag_id)) {
                                        echo 'checked';
                                    }
                                    ?>>
                                                                                            </div>
                                                                                            <div class="col-lg-7">
                                    <?php echo $dt->make_name; ?>
                                                                                            </div>
                                                                                            <div class="clearfix"></div>
                                    <?php
                                }
                                ?>
                                                                    </div>
                                                                </div>-->



                                <?php $smodel_id = explode(',', $user->service_model_id); ?>    

                                <!--                            <div class="form-group">
                                                                    <label class="control-label col-lg-4">Car Model</label>
                                                                    <div class="col-lg-8"> 
                                <?php foreach ($models as $dt) {
                                    ?>
                                                                                            <div class="col-lg-1">
                                                                                                <input type="checkbox" name="service_model_id[]" value="<?php echo $dt->id; ?>" <?php
                                    if (in_array($dt->id, $smodel_id)) {
                                        echo 'checked';
                                    }
                                    ?>>
                                                                                            </div>
                                                                                            <div class="col-lg-7">
                                    <?php echo $dt->model_name; ?> (<?php echo $dt->make->make_name; ?>)
                                                                                            </div>
                                                                                            <div class="clearfix"></div>
                                    <?php
                                }
                                ?>
                                                                    </div>
                                                                </div>-->



                                <?php $sf_id = explode(',', $user->service_feature_id); ?>    

                                <!--                            <div class="form-group">
                                                                    <label class="control-label col-lg-4">Features</label>
                                                                    <div class="col-lg-8"> 
                                <?php foreach ($features as $dt) {
                                    ?>
                                                                                            <div class="col-lg-1">
                                                                                                <input type="checkbox" name="service_feature_id[]" value="<?php echo $dt->id; ?>" <?php
                                    if (in_array($dt->id, $sf_id)) {
                                        echo 'checked';
                                    }
                                    ?>>
                                                                                            </div>
                                                                                            <div class="col-lg-7">
                                    <?php echo $dt->feature_name; ?>
                                                                                            </div>
                                                                                            <div class="clearfix"></div>
                                    <?php
                                }
                                ?>
                                                                    </div>
                                                                </div>-->



                                <div class="form-group">

                                    <!-- <label class="control-label col-lg-4">Upload Photos</label>  
                                    <div class="company-images col-lg-8">

                                        <input type="hidden" name="image" id="product_image_id">
                                        <div class="fileUpload btn btn-primary">

                                            <input type="file" id="multiFiles" name="files[]" multiple="multiple" class="upload"/>
                                        </div>

                                        <span id="status" ></span> 
                                    </div> -->
                                    <!-- <div class="manage-photo" id="product_images" style="overflow:scroll; height:450px;width:500px;">
                                        <ul id="sortable" class="uisortable">
                                            <?php
                                            foreach ($all_image as $image) {
                                                ?>
                                                <li id="<?php echo $image->id; ?>">
                                                    <div class="media" id="image_<?php echo $image->id; ?>">
                                                        <div class="media-left">
                                                            <a href="#">
                                                                <img style="width: 100px; height: 100px" src="<?php echo $this->Url->build('/user_img/' . $image->image_name) ?>" alt="" />
                                                            </a>
                                                        </div>
                                                        <div class="media-body media-middle">
                                                            <h4><?php echo $image->image_name; ?></h4>
                                                        </div>
                                                        <div class="media-body media-middle">
                                                            <a class="btn btn-blank" onclick="javascript: delete_image(<?php echo $image->id; ?>)"><button>Delete</button></a>                         
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>

                                    </div>
                                </div> -->



                                <!--                              <div class="form-group">
                                                                  
                                                                   <label class="control-label col-lg-4">Upload Documents</label>  
                                                  <div class="company-images col-lg-8">
                                                   
                                                        <input type="hidden" name="document" id="product_image_id1">
                                                        <div class="fileUpload btn btn-primary">
                                                         
                                                          <input type="file" id="multiFiles1" name="files1[]" multiple="multiple" class="upload"/>
                                                        </div>
                                
                                                    <span id="status" ></span> 
                                                   </div>
                                                    <div class="manage-photo" id="product_images1" style="overflow:scroll; height:450px;width:500px;">
                                                                <ul id="sortable1" class="uisortable">
                                <?php
                                foreach ($all_document as $image) {
                                    ?>
                                                                              <li id="<?php echo $image->id; ?>">
                                                                              <div class="media" id="image_<?php echo $image->id; ?>">
                                                                                <div class="media-left">
                                                                                  <a href="#">
                                                                                    <img style="width: 100px; height: 100px" src="<?php echo $this->Url->build('/user_img/' . $image->doc_name) ?>" alt="" />
                                                                                  </a>
                                                                                </div>
                                                                                <div class="media-body media-middle">
                                                                                  <h4><?php echo $image->doc_name; ?></h4>
                                                                                </div>
                                                                                <div class="media-body media-middle">
                                                                                    <a class="btn btn-blank" onclick="javascript: delete_doc(<?php echo $image->id; ?>)"><button>Delete</button></a>                         
                                                                                </div>
                                                                              </div>
                                                                              </li>
                                    <?php
                                }
                                ?>
                                                                  </ul>
                                
                                                                    </div>
                                                                </div>-->



                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Edit Seller" class="btn btn-primary" />
                                </div>
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('.pl').click(function (e) {
            e.preventDefault();
            $('#phone').append('<div class="form-group"><label class="control-label col-lg-4">Service Type</label><div class="col-lg-8"><input type="text"  name="type_name[]" class="form-control"></div></div><div class="form-group"><label class="control-label col-lg-4">Description</label><div class="col-lg-8"><textarea  name="description[]" class="form-control"></textarea></div></div>');
            $('.mi').show();
        });
        $('.mi').click(function (e) {
            e.preventDefault();
            if ($('#phone input').length >= 1) {

                $('#phone').children().last().remove();
            }
        });
    });

</script>
<script type="text/javascript">
    $(document).ready(function () {

        $('#multiFiles').on('change', function () {

            var image_url = '<?php echo $this->Url->build('/user_img/'); ?>';

            var form_data = new FormData();
            var ins = document.getElementById('multiFiles').files.length;

            for (var x = 0; x < ins; x++) {
                form_data.append("files[]", document.getElementById('multiFiles').files[x]);
                //alert('ok');
                // alert(JSON.stringify(document.getElementById('multiFiles').files[x]));
            }
            console.log(form_data);
            $.ajax({
                url: base_url + 'users/upload_photo_add', // point to server-side PHP script 
                dataType: 'text', // what to expect back from the PHP script
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (response) {
                    console.log(response);
                    var obj = jQuery.parseJSON(response);

                    if (obj.Ack == 1) {

                        //alert('ok');
                        $('#product_image_id').val(obj.image_name);
                        for (var i = 0; i < obj.data.length; i++) {
                            file_path = image_url + obj.data[i].filename;
                            $('<li id="' + obj.data[i].last_id + '"></li>').appendTo('#sortable').html('<div class="media" id="image_' + obj.data[i].last_id + '"><div class="media-left"><a href="#"><img style="width: 100px; height: 100px" src="' + file_path + '" alt="" /></a></div><div class="media-body media-middle"><h4>' + obj.data[i].filename + '</h4></div><div class="media-body media-middle"></div></div></div></li>');
                        }
                    }
                },
                error: function (response) {
                    $('#msg').html(response); // display error response from the PHP script
                }
            });
        });

    });

</script>
<script>
    $(document).ready(function () {

        $('#multiFiles1').on('change', function () {

            var image_url = '<?php echo $this->Url->build('/user_doc/'); ?>';

            var form_data = new FormData();
            var ins = document.getElementById('multiFiles1').files.length;

            for (var x = 0; x < ins; x++) {
                form_data.append("files1[]", document.getElementById('multiFiles1').files[x]);
                //alert('ok');
                // alert(JSON.stringify(document.getElementById('multiFiles').files[x]));
            }
            console.log(form_data);
            $.ajax({
                url: base_url + 'users/upload_doc_add', // point to server-side PHP script 
                dataType: 'text', // what to expect back from the PHP script
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (response) {
                    console.log(response);
                    var obj = jQuery.parseJSON(response);

                    if (obj.Ack == 1) {

                        //alert('ok');
                        $('#product_image_id1').val(obj.image_name);
                        for (var i = 0; i < obj.data.length; i++) {
                            file_path = image_url + obj.data[i].filename;
                            $('<li id="' + obj.data[i].last_id + '"></li>').appendTo('#sortable1').html('<div class="media" id="image_' + obj.data[i].last_id + '"><div class="media-left"><a href="#"></a></div><div class="media-body media-middle"><h4>' + obj.data[i].filename + '</h4></div><div class="media-body media-middle"></div></div></div></li>');
                        }
                    }
                },
                error: function (response) {
                    $('#msg').html(response); // display error response from the PHP script
                }
            });
        });


    });




    function delete_image(id) {

        $.ajax({
            method: "GET",
            url: base_url + 'users/delete_image',
            data: {id: id}
        })
                .done(function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.Ack == 1) {
                        $('#image_' + id).html("");
                    }
                });
    }

    function delete_doc(id) {

        $.ajax({
            method: "GET",
            url: base_url + 'users/delete_document',
            data: {id: id}
        })
                .done(function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.Ack == 1) {
                        $('#image_' + id).html("");
                    }
                });
    }


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

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();
            $('#lat').val(lat);
            $('#long').val(lng);

        });
    }


    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
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