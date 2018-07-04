<?php ?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Add Seller </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Add Seller</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group"> 

<!--                                        <a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "listserviceprovider"]); ?>"><button class="btn btn-xs btn-success close-box">
                                                <i class="icon-list"></i>List Service Providers</button></a>-->
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body"> 
                        <div class="col-sm-6">
                            <div class="row">
                                <?php echo $this->Form->create($user, ['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data', 'onsubmit' => "return validate();"]); ?>
                                <input type="hidden" name="utype" id="utype" value="2" />

                                <input type="hidden" name="is_mail_verified" id="is_mail_verified" value="1" />

                                <div class="form-block">



                                    <div class="form-group">
                                        <label class="control-label col-lg-4">First Name</label>
                                        <div class="col-lg-8">
                                            <?php echo $this->Form->input('first_name', array('class' => 'form-control', 'id' => 'first_name', 'label' => false)); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Last Name</label>
                                        <div class="col-lg-8">
                                            <?php echo $this->Form->input('last_name', array('class' => 'form-control', 'id' => 'last_name', 'label' => false)); ?>
                                        </div>
                                    </div>



                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Email</label>
                                        <div class="col-lg-8">
                                            <?php echo $this->Form->input('email', array('class' => 'form-control', 'id' => 'email', 'label' => false)); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Contact Number</label>
                                        <div class="col-lg-8">
                                            <input type="text"  name="phone" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Address</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="autocomplete1" name="address" type="text" onFocus=geolocate() />
                                        </div>
                                    </div>   

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Description</label>
                                        <div class="col-lg-8">
                                            <textarea name="description" id="description" placeholder="Description" rows="4" cols="57"></textarea>
                                        </div>
                                    </div>  

                                    <input  type="hidden" id="lat" name="latitude" />
                                    <input  type="hidden" id="long" name="longitude" />

                                    <label class="control-label col-lg-4"></label>
                                    <div class="col-lg-8" style="text-align:left;"> 
                                        <input type="submit" name="submit" value="Add Seller" class="btn btn-primary" />
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
<script>
    $(document).ready(function () {

        $('#multiFiles1').on('change', function () {

            var image_url = '<?php echo $this->Url->build('/user_doc/'); ?>';

            var form_data = new FormData();
            var ins = document.getElementById('multiFiles1').files.length;
            // alert(ins);
            //alert(JSON.stringify(document.getElementById('multiFiles')));
            for (var x = 0; x < ins; x++) {
                form_data.append("files1[]", document.getElementById('multiFiles1').files[x]);
                //alert('ok');
                // alert(JSON.stringify(document.getElementById('multiFiles').files[x]));
            }
            console.log(form_data);
            $.ajax({
                url: 'upload_doc_add', // point to server-side PHP script 
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
                        $('#product_doc_id').val(obj.image_name);
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

</script>



<script>
    $(document).ready(function () {

        $('#multiFiles').on('change', function () {

            var image_url = '<?php echo $this->Url->build('/user_img/'); ?>';

            var form_data = new FormData();
            var ins = document.getElementById('multiFiles').files.length;
            // alert(ins);
            //alert(JSON.stringify(document.getElementById('multiFiles')));
            for (var x = 0; x < ins; x++) {
                form_data.append("files[]", document.getElementById('multiFiles').files[x]);
                //alert('ok');
                // alert(JSON.stringify(document.getElementById('multiFiles').files[x]));
            }
            console.log(form_data);
            $.ajax({
                url: 'upload_photo_add', // point to server-side PHP script 
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

<script type="text/javascript">
    function validate(){
        //alert("Hi");return false;
        if($("#first_name").val().search(/\S/) == -1){
            alert("Please provide valid first name"); return false;
        }

        if($("#last_name").val().search(/\S/) == -1){
            alert("Please provide valid last name"); return false;
        }

        var email = $("#email").val();
        var email = email.trim();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (!filter.test(email)) {
            alert('Please provide a valid email address');
            email.focus;
            return false;
        }
        if($("#autocomplete1").val().search(/\S/) == -1){
            alert("Please provide valid location"); return false;
        }
        
        return true;
    }
</script>