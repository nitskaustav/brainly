

<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Add Gear </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Add Gear</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group"> 

                                        <a href="<?php echo $this->Url->build(["controller" => "Products","action" => "listgear"]);?>"><button class="btn btn-xs btn-success close-box">
                                                <i class="icon-list"></i>List Gear</button></a>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body"> 
                        <div class="col-sm-6">
                            <div class="row">
        <?php echo $this->Form->create($user,['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data', 'onsubmit' => "return validate();"]);?>
                                                                
                                <div class="form-block">

                                                  

                                <div class="form-group">
                                    <label>Choose Gear Category</label>
                                    <select class="form-control" id="category_idselect" name="category_id">
                                        <option value="">Select</option>
                                        <?php foreach ($categories as $cat_val) { ?>
                                          <option value="<?php echo $cat_val->id ?>"><?php echo $cat_val->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input type="text" class="form-control" name="product_name" id="product_name">
                                </div>

                                <div class="form-group">
                                    <label>Brand</label>
                                    <select class="form-control" id="brand_idselect" name="brand_id">
                                        <option value="">Select</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Size</label>
                                    <select class="form-control" id="size_id_select" name="size_id">
                                        <option value="">Select</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Colour</label>
                                    <div class="color-check-area">
                                    <?php
                                        foreach($colours as $colour_key){
                                            ?>
                                            <p class="text-center d-inline-block">
                                                <input type="checkbox" id="<?php echo $colour_key->id; ?>" name="colour_id[]" value="<?php echo $colour_key->id; ?>" />
                                                <label for="<?php echo $colour_key->id; ?>" style="background:<?php echo $colour_key->hexcode; ?>;"></label>
                                              </p>
                                            <?php
                                        }
                                    ?>
                                    <!-- <p  class="text-center d-inline-block">
                                        <input type="checkbox" id="1" />
                                        <label for="1" style="background:#f26d7d;"></label>
                                      </p>
                                    -->
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" class="form-control" name="price" id="price">
                                </div>

                                <div class="form-group">
                                    <label>Item Location</label>
                                    <input type="text" class="form-control" name="item_location" id="item_location">
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea rows="5" class="form-control" name="description"></textarea>
                                </div>

                                <div class="form-group">
                                  <div class="photo-upload-area">
                                    <h4>Add up to 8 pictures</h4>
                                    <div class="form-group inputDnD">
                                      <input type="hidden" name="total_image" id="total_image">
                                        <input type="hidden" name="upload" id="upload">
                                        <label for="inputFile"><img src="<?php echo $this->Url->build('/img/'); ?>camera-icon.png" alt=""></label>
                                        <div class="fileUpload btn btn-primary">
                                          <span>Upload Image</span>
                                          <input type="file" id="multiFiles" name="files[]" multiple="multiple" class="upload"/>
                                        </div>

                                        <span id="status" ></span>
                                    </div>
                                    <ul class="list-unstyled pic-upload-area d-flex justify-content-center flex-wrap" id="sortable">

                            <?php
                            foreach ($images as $image) {                               
                        ?>
                            <li id="image_<?php echo $image->id;?>">
                                <img src="<?php echo $this->Url->build('/product_img/'.$image->name); ?>" alt="">
                                <a href="javascript: delete_picture(<?php echo $image->id;?>)"><i class="ion-close"></i></a>
                            </li>
                        <?php
                        }
                        ?>  
                                        <!-- <li>
                                            <img src="img/pic/1.jpg" alt="">
                                            <a><i class="ion-close"></i></a>
                                        </li>-->
                                    </ul>
                                  </div>
                                </div>
                              
                                
                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Add Gear" class="btn btn-primary" />
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

<script type="text/javascript">
  $(document).ready(function(){
      $("#category_idselect").change(function(){
          //$("#div1").load("demo_test.txt");
          var category_id = document.getElementById("category_idselect").value;
            //alert(category_id);return false;

            $.ajax({
                type: "POST",
                url: '<?php echo $this->request->webroot; ?>admin/products/gearajaxdata',
                data: { category_id: category_id },
                dataType: 'json',
                success: function(data){
                    //console.log(data);
                    
                    var html_data = data;
                    //alert(JSON.stringify(html_data));
                    var res = html_data.split("|");
                    //alert(JSON.stringify(res[0]));
                    document.getElementById("size_id_select").innerHTML = res[1];
                    document.getElementById("brand_idselect").innerHTML = res[0];
                },
                error: function (response) {
                    console.log(response)
                    alert(JSON.stringify(response))
                }
            });
          
      });
  });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $( "#gearvalidate" ).validate({
        rules: {
          'category_id': "required",
          'product_name': "required",          
          'brand_id': "required",
          'size_id': "required",
          'price': "required",
          'item_location': "required",
          'description': "required"
          }

        },
        messages: {
          'category_id': "Please provide category",
          'product_name': "Please provide product name",
          'brand_id': "Please provide brand",
          'size_id': "Please provide size",
          'price': "Please provide price",
          'item_location': "Please provide item location",
          'description': "Please provide description"
        },


      });
    })
</script>
<script type="text/javascript">
    $( document ).ready( function () {

        $('#multiFiles').on('change',function(){
            var form_data = new FormData();
            var ins = document.getElementById('multiFiles').files.length;
            for (var x = 0; x < ins; x++) {

                form_data.append("files[]", document.getElementById('multiFiles').files[x]);
            }
            //console.log(form_data);return false;
            $.ajax({
                url: '<?php echo $this->request->webroot; ?>admin/products/upload_photo/', // point to server-side PHP script 
                dataType: 'text', // what to expect back from the PHP script
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (response) {
                    //alert(response);return false;
                     var obj = jQuery.parseJSON( response );
                     var upload_file = '';
                     if(obj.Ack == 1){
                      //alert(obj.data.length); return false;
                      if($('#total_image').val() == ''){
                        $('#total_image').val(obj.data.length);
                      }else{
                        $('#total_image').val(parseInt($('#total_image').val())+obj.data.length);
                      }
                      //$('#total_image').val(parseInt($('#total_image').val())+obj.data.length);
                      for(var i = 0; i < obj.data.length; i++){
                          file_path = '<?php echo $this->request->webroot; ?>gear_img/'+obj.data[i].filename;

                          upload_file += obj.data[i].filename+',';
                          file_full_name = obj.data[i].filename
                          file_fname = file_full_name.split(".");
                          image_id = "'"+file_fname[0]+"#"+file_fname[1]+"'";
                          list_id = "image_"+file_fname[0];
                          
                            $('<li id="'+list_id+'"></li>').appendTo('#sortable').html('<img src="'+file_path+'" alt=""><a onclick="javascript: delete_picture('+image_id+')"><i class="ion-close"></i></a>');

                       /* $('<li id="'+obj.data[i].last_id+'"></li>').appendTo('#sortable').html('<div class="media" id="image_'+obj.data[i].last_id+'"><div class="media-left"><a href="#"><img style="width: 100px; height: 100px" src="'+file_path+'" alt="" /></a></div><div class="media-body media-middle"><span style="padding-left: 10px;">'+obj.data[i].filename+'</span><span style="padding-left: 10px;"><input type="text" name="title_'+obj.data[i].last_id+'" class="form-control" value=""></span></div><div class="media-body media-middle"><a class="btn btn-danger btn-sm rounded-0" style="color: #fff" onclick="javascript: delete_image('+obj.data[i].last_id+')"><i class="icon ion-android-delete text-white"></i>Delete </a></div></div></div></li>');*/
                      }
                      var existing_data = $('#upload').val();
                      if(existing_data != '')
                        $('#upload').val(existing_data+','+upload_file);
                      else
                        $('#upload').val(upload_file);
                     }
                },
                error: function (response) {
                    $('#msg').html(response); // display error response from the PHP script
                }
            });
        });


    } );

    function delete_picture(id){
      //alert("hi");return false;
      $.ajax({
            method: "POST",
            url: '<?php echo $this->request->webroot; ?>admin/products/delete_picture',
            data: { id: id}
          })
          .done(function( data ) {
            //alert(data);return false;
           var split_id = id.split("#");
            var image_name = id.replace("#",".");
            var existing_data = $('#upload').val();
            var existing_data_array = existing_data.split(",");
            var update_existing_data = '';
            for(var i=0;i<existing_data_array.length;i++){
                if(existing_data_array[i] == image_name || existing_data_array[i] == ''){
                    //alert("hello");
                }
                else{
                    //alert("Hi");
                    update_existing_data += existing_data_array[i]+",";
                }
            }
            // alert(update_existing_data);
            // return false;
            //alert(data+split_id[0]);return false;

            var obj = jQuery.parseJSON( data );
            if(obj.Ack  == 1){
                
                $('#total_image').val(parseInt($('#total_image').val())-1);
                $('#image_'+split_id[0]+'').html("");
                $('#upload').val(update_existing_data);
            }
          });
    }
 </script>
 <script type="text/javascript">
   function validate(){
    //alert("H");return false;
    if($("#category_idselect").val().search(/\S/) == -1){
      alert("Please choose category"); return false;
    }
    if($("#product_name").val().search(/\S/) == -1){
      alert("Please provide product name"); return false;
    }
    if($("#brand_idselect").val().search(/\S/) == -1){
      alert("Please choose brand"); return false;
    }
    if($("#size_id_select").val().search(/\S/) == -1){
      alert("Please select size"); return false;
    }
    if($("#price").val().search(/\S/) == -1){
      alert("Please provide price"); return false;
    }
    if($("#item_location").val().search(/\S/) == -1){
      alert("Please provide item location"); return false;
    }
    // if( document.getElementById("multiFiles").files.length == 0 ){
    //   alert("No files selected"); return false;
    // }
    if($("#total_image").val() == '' || $("#total_image").val() == 0){
      alert("No files selected"); return false;
    }
    return true;
    
   }
 </script>