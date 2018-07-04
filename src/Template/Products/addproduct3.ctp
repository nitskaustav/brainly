<script src="<?php echo $this->Url->build('/js/jquery-1.10.1.min.js');?>"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script>
        $(document).ready(function(){
          $("#sortable").sortable({
              stop : function(event, ui){
                  $.ajax({
                    method: "POST",
                    url: base_url+"services/order_image",
                    data: { ids: $(this).sortable('toArray')}
                  })
                .done(function( data ) {
                 var obj = jQuery.parseJSON( data );
                  
                });
                //alert($(this).sortable('toArray'));
              }
          });
        $("#sortable").disableSelection();
      });//ready
  </script>
<section class="inner-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center inner-heading">
                    <h2>Sell Bike</h2>
                    <h5>Sell your bike 5 easy steps</h5>
                </div>
                <div class="col-lg-12">
                    <ul class="list-unstyled top-pagition text-center mt-3">
                        <li class="active">
                            <a>
                                <span class="d-flex align-items-center justify-content-center"><i class="ion-checkmark-round"></i></span>
                                <p>Step 1</p>
                            </a>
                        </li>
                        <li class="active">
                            <a>
                                <span class="d-flex align-items-center justify-content-center"><i class="ion-checkmark-round"></i></span>
                                <p>Step 2</p>
                            </a>
                        </li>
                        <li class="active">
                            <a>
                                <span class="d-flex align-items-center justify-content-center">3</span>
                                <p>Step 3</p>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="d-flex align-items-center justify-content-center">4</span>
                                <p>Step 4</p>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="d-flex align-items-center justify-content-center">5</span>
                                <p>Step 5</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-10">
                    <div class="bike-icon d-flex align-items-center justify-content-center">
                        <img src="<?php echo $this->Url->build('/img/bike-icon.png'); ?>" alt="">
                    </div>
                     <form method="post" action="<?php echo $this->Url->build(["controller" => "Products","action" => "addproduct3", $product->id]);?>" enctype='multipart/form-data' class="form-area text-center" onsubmit="return validate();">
                    <div class="photo-upload-area">
                        <h4>Add up to 8 pictures</h4>
                        
                         <input type="hidden" name="product_id" id="product_id" value="<?php echo $product->id;?>">
                         <input type="hidden" name="total_image" id="total_image">
                        <div class="form-group inputDnD">
                            <label for="inputFile"><img src="<?php echo $this->Url->build('/img/camera-icon.png'); ?>" alt=""></label>
                            <!-- <input type="file" class="form-control-file" id="multiFiles" accept="image/*" onchange="readUrl(this)" data-title="Drag or click here to upload" name="files[]" multiple="multiple">  -->
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
                                <a href="javascript: delete_image(<?php echo $image->id;?>)"><i class="ion-close"></i></a>
                            </li>
                        <?php
                        }
                        ?>    
                           
                        </ul>
                        <div class="text-center mt-5">
                            <button type="submit" name="back" class="btn btn-secondary btn-lg m-3" value="back">Back</button>
                            <button type="submit" name="continue" class="btn btn-primary btn-lg m-3">Continue</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
    $( document ).ready( function () {

        $('#multiFiles').on('change',function(){
            var form_data = new FormData();
            var ins = document.getElementById('multiFiles').files.length;
            for (var x = 0; x < ins; x++) {
                form_data.append("files[]", document.getElementById('multiFiles').files[x]);
            }
            $.ajax({
                url: '<?php echo $this->request->webroot; ?>products/upload_photo/'+$('#product_id').val(), // point to server-side PHP script 
                dataType: 'text', // what to expect back from the PHP script
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (response) {
                  //alert(response);return false;
                     var obj = jQuery.parseJSON( response );
                     if(obj.Ack == 1){
                      $('#total_image').val(parseInt($('#total_image').val())+obj.data.length);
                      for(var i = 0; i < obj.data.length; i++){
                          file_path = base_url+'product_img/'+obj.data[i].filename;
                          
                            $('<li id="image_'+obj.data[i].last_id+'"></li>').appendTo('#sortable').html('<img src="'+file_path+'" alt=""><a onclick="javascript: delete_image('+obj.data[i].last_id+')"><i class="ion-close"></i></a>');

                       /* $('<li id="'+obj.data[i].last_id+'"></li>').appendTo('#sortable').html('<div class="media" id="image_'+obj.data[i].last_id+'"><div class="media-left"><a href="#"><img style="width: 100px; height: 100px" src="'+file_path+'" alt="" /></a></div><div class="media-body media-middle"><span style="padding-left: 10px;">'+obj.data[i].filename+'</span><span style="padding-left: 10px;"><input type="text" name="title_'+obj.data[i].last_id+'" class="form-control" value=""></span></div><div class="media-body media-middle"><a class="btn btn-danger btn-sm rounded-0" style="color: #fff" onclick="javascript: delete_image('+obj.data[i].last_id+')"><i class="icon ion-android-delete text-white"></i>Delete </a></div></div></div></li>');*/
                      }
                     }
                },
                error: function (response) {
                    $('#msg').html(response); // display error response from the PHP script
                }
            });
        });


    } );

    function delete_image(id){
      $.ajax({
            method: "POST",
            url: base_url+"products/delete_image",
            data: { id: id}
          })
          .done(function( data ) {
           var obj = jQuery.parseJSON( data );
            if(obj.Ack  == 1){
            $('#total_image').val(parseInt($('#total_image').val())-1);                   
              $('#image_'+id).html("");
            }
          });
    }
 </script>
 <script type="text/javascript">
   // function validate(){
   //  if(document.getElementById("multiFiles").files.length == 0){
   //    alert("Please select files to upload");return false;
   //  }
   // }
 </script>