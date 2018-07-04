<?php //pr($user); //exit; ?>


<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Edit Review </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Edit Review</h5>
                        <div class="toolbar">

                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-6">

                            <div class="row">
                                <?php echo $this->Form->create($user, ['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data']); ?>

                                                               

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Review</label>
                                    <div class="col-lg-8">
                                        <textarea id="first_name" name="review" class="form-control"><?php echo $user->review ?></textarea>
                                    </div>
                                </div>  

                                                         
                                <div class="form-group">
                                  
                                   <label class="control-label col-lg-4">Upload Photos</label>  
                  <div class="company-images col-lg-8">
                   
                        <input type="hidden" name="image" id="product_image_id">
                        <div class="fileUpload btn btn-primary">
                         
                          <input type="file" id="multiFiles" name="files[]" multiple="multiple" class="upload"/>
                        </div>

                    <span id="status" ></span> 
                   </div>
                    <div class="manage-photo" id="product_images" style="overflow:scroll; height:450px;width:500px;">
                                <ul id="sortable" class="uisortable">
                                  <?php
                               
                                    foreach ($all_image as $image) {                      

                                  ?>
                                  <li id="<?php echo $image->id;?>">
                                  <div class="media" id="image_<?php echo $image->id;?>">
                                    <div class="media-left">
                                      <a href="#">
                                        <img style="width: 100px; height: 100px" src="<?php echo $this->Url->build('/review_img/'.$image->image_name)?>" alt="" />
                                      </a>
                                    </div>
                                    <div class="media-body media-middle">
                                      <h4><?php echo $image->image_name;?></h4>
                                    </div>
                                    <div class="media-body media-middle">
                                        <a class="btn btn-blank" onclick="javascript: delete_image(<?php echo $image->id;?>)"><button>Delete</button></a>                         
                                    </div>
                                  </div>
                                  </li>
                                  <?php
                                }
                                ?>
                                  </ul>

                                    </div>
                                </div>
                                
                                                             
                                
                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Edit Review" class="btn btn-primary" />
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

<script type="text/javascript">
    $( document ).ready( function () {

       $('#multiFiles').on('change',function(){
          
               var image_url = '<?php echo $this->Url->build('/review_img/'); ?>';
              
                    var form_data = new FormData();
                    var ins = document.getElementById('multiFiles').files.length;
                 
                    for (var x = 0; x < ins; x++) {
                        form_data.append("files[]", document.getElementById('multiFiles').files[x]);
                        //alert('ok');
                       // alert(JSON.stringify(document.getElementById('multiFiles').files[x]));
                    }
                    console.log(form_data);
                    $.ajax({
                        url: base_url+'reviews/upload_photo_add', // point to server-side PHP script 
                        dataType: 'text', // what to expect back from the PHP script
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                        success: function (response) {
                          console.log(response);
                             var obj = jQuery.parseJSON( response );
                            
                             if(obj.Ack == 1){
                                 
                            //alert('ok');
                              $('#product_image_id').val(obj.image_name);
                              for(var i = 0; i < obj.data.length; i++){
                                  file_path = image_url+obj.data[i].filename;
                                $('<li id="'+obj.data[i].last_id+'"></li>').appendTo('#sortable').html('<div class="media" id="image_'+obj.data[i].last_id+'"><div class="media-left"><a href="#"><img style="width: 100px; height: 100px" src="'+file_path+'" alt="" /></a></div><div class="media-body media-middle"><h4>'+obj.data[i].filename+'</h4></div><div class="media-body media-middle"></div></div></div></li>');
                              }
                             }
                        },
                        error: function (response) {
                            $('#msg').html(response); // display error response from the PHP script
                        }
                    });
                });
      
      });
    
    
    
    
    function delete_image(id){
    
      $.ajax({
            method: "GET",
            url: base_url+'reviews/delete_image',
            data: { id: id}
          })
          .done(function( data ) {
           var obj = jQuery.parseJSON( data );
            if(obj.Ack  == 1){                   
              $('#image_'+id).html("");
            }
          });
    }
    
  </script>