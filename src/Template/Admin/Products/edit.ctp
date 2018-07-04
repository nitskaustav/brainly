 <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
  <script>
    $(document).ready(function() {
        var markupStr = $('#summernote').summernote('code');
        var markupStr = $('.summernote').eq(1).summernote('code');
        $('#summernote').summernote('code', markupStr);
        //$('#summernote').summernote('fontSize', 20);

        $('#editor1').summernote({
            defaultFontName: 'Lato',
            height: 300,                 // set editor height
            width: 950,
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: true,                  // set focus to editable area after initializing summernote
            popover: {
                        image: [
                          ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                          ['float', ['floatLeft', 'floatRight', 'floatNone']],
                          ['remove', ['removeMedia']]
                        ],
                        link: [
                          ['link', ['linkDialogShow', 'unlink']]
                        ],
                        air: [
                          ['color', ['color']],
                          ['font', ['bold', 'underline']],
                          ['fontsize', ['8', '9', '10', '11', '12', '14', '18', '24', '36']],
                          ['para', ['ul', 'paragraph']],
                          ['table', ['table']],
                          ['insert', ['link', 'picture']]
                          ['style', ['style']],
                          ['text', ['bold', 'italic', 'underline', 'color', 'clear']],
                          ['para', [ 'paragraph']],
                          ['height', ['height']],
                          ['font', ['Lato','Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather']],
                        ]
                      },
            onblur: function() {
                var text = $('#editor').code();
                text = text.replace("<br>", " ");
                $('#description').val(text);
            }
          
        });
    });
  </script>

<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Edit Event </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Edit Event</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group"> 

                                    </div>
                                </li>

                            </ul>
                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-6">

                            <div class="row">
                              <?php echo $this->Form->create($event,['class' => 'form-horizontal','type'=>'file', 'id' => 'user-validate','enctype'=>"multipart/form-data"]);?>                               
                                 <?php echo $this->Form->input('latitude', array('type'=>'hidden','label' => false)); ?>
                                 <?php echo $this->Form->input('longitude', array('type'=>'hidden','label' => false)); ?>
                              
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Event Name </label>
                                    <?php echo '<div class="col-lg-8">'.$this->Form->input('name', array('class'=>'form-control','label' => false, 'style' => 'width:800px')).'</div>'; ?>
                                </div>

                                  <div class="form-group">
                                    <label class="control-label col-lg-4">  Club Name </label>


                                    <?php echo '<div class="col-lg-8">'.$this->Form->input('club_name', array('class'=>'form-control','label' => false, 'style' => 'width:800px','type'=>'select','options'=>$clubs)).'</div>'; ?>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Music</label>
                                    <?php echo '<div class="col-lg-8">'.$this->Form->input('music', array('class'=>'form-control','label' => false, 'style' => 'width:800px')).'</div>'; ?>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Crowd</label>
                                    <?php echo '<div class="col-lg-8">'.$this->Form->input('crowd', array('class'=>'form-control','label' => false, 'style' => 'width:800px')).'</div>'; ?>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Location </label>
                                    <?php echo '<div class="col-lg-8">'.$this->Form->input('location', array('class'=>'form-control','label' => false, 'style' => 'width:800px','id'=>'autocomplete','onfocus'=>'geolocate()')).'</div>'; ?>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Event Description </label>
                                    <?php echo '<div class="col-lg-8">'.$this->Form->input('event_description', array('class'=>'form-control','label' => false, 'style' => 'width:800px')).'</div>'; ?>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Event Start date </label>
                                    <?php echo '<div class="col-lg-8">'.$this->Form->input('event_start_date', array('class'=>'form-control','label' => false, 'style' => 'width:800px')).'</div>'; ?>
                                </div>

                                 <div class="form-group">
                                    <label class="control-label col-lg-4"> Event End date </label>
                                    <?php echo '<div class="col-lg-8">'.$this->Form->input('event_end_date', array('class'=>'form-control','label' => false, 'style' => 'width:800px')).'</div>'; ?>
                                </div>

                                 <div class="form-group">
                                    <label class="control-label col-lg-4"> Select Category</label>
                                    <?php echo '<div class="col-lg-8">'.$this->Form->input('category_id', array('class'=>'form-control','label' => false, 'style' => 'width:800px','type'=>'select','options'=>$categories)).'</div>'; ?>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Choose Table </label>
                                    <?php if($tables){ foreach($tables as $tbl) {  ?>
                                    <!-- <?php echo '<div class="col-lg-8">'.$this->Form->input('event_end_date', array('class'=>'form-control','label' => false, 'style' => 'width:800px')).'</div>'; ?> -->
                                    <input type="checkbox" name="table[]" value="<?php echo $tbl['id']?>" <?php if($table_ids){if(in_array($tbl['id'], $table_ids)) { echo "checked"; }}?>> <?php echo $tbl['name']?>
                                    <?php }} ?>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Upload image</label>
                                    <!-- <?php echo '<div class="col-lg-8">'.$this->Form->input('files', array('class'=>'form-control','label' => false, 'style' => 'width:800px','type'=>'file','multiple')).'</div>'; ?> -->
                                    <input type="file" name="file[]" multiple> 
                                </div>

                                <div class="manage-photo" id="product_images" style="overflow:scroll; height:150px;width:500px;">
                  <ul id="sortable">
                    <?php
                   // print_r($all_image);exit;

                      foreach ($all_image as $image) {                      
                      
                    ?>
                    <li id="<?php echo $image['id'];?>">
                    <div class="media" id="image_<?php echo $image['id'];?>">
                      <div class="media-left">
                        <a href="#">
                          
                          <img src="<?php echo $this->Url->build('/event_img/' . $image['image']); ?>" width="100px" height="100px" />
                        </a>
                      </div>
                      <div class="media-body media-middle">
                        <h4><?php echo $image['image'];?></h4>
                      </div>
                      <div class="media-body media-middle">
                          <a class="btn btn-blank" onclick="javascript: delete_image(<?php echo $image['id'];?>)">Delete</a>                         
                      </div>
                    </div>
                    </li>
                    <?php
                  }
                  ?>
                  </ul>
                  </div>
                               
                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Add Event" class="btn btn-primary" />
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="clearfix"></div>
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
              $('#latitude').val(lat);
              $('#longitude').val(lng);
            
            });       
      }

     
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            //alert(position.coords.latitude);
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqxL1CDGXN8mFjio0Q7Cf96Tq5V_N7tIc&libraries=places&callback=initAutocomplete"
        async defer></script>
       