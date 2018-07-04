<!-- <script src="<?php echo $this->Url->build('/js/jquery-1.10.1.min.js');?>"></script> -->
<script src="http://demo.itsolutionstuff.com/plugin/croppie.js"></script>
<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/croppie.css">

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
                    <?php
                        echo $this->element('side_menu');
                    ?>
                   
                </div>
            </div>
            
            <div class="col-lg-9">
                <div class="right-side p-4">
                    <h2 class="mb-4">My Account</h2>
                    <div class="d-flex">
                        <div class="msg-img user-pro-pic mr-3" data-toggle="modal" data-target="#myModal">
                            <!-- <img src="<?php echo $this->Url->build('/img/user-pic-2.jpg'); ?>" alt=""> -->
                            <?php if ($user_details->pimg != '') { ?>
                              <img src="<?php echo $this->Url->build('/user_img/thumb_' . $user_details->pimg); ?>" alt="" id="profile_image">
                                <?php }else{ ?>
                              <img src="<?php echo $this->Url->build('/user_img/default.png'); ?>" alt="" id="profile_image">        
                                <?php } ?>
                            <a href="#" onclick='$("#myModal").modal("show");'><i class="ion-camera"></i></a>
                            
                        </div>
                        <div class="text-my-name">
                            <!-- <h4><?php echo $user->first_name;?> <?php echo $user->last_name;?></h4> -->
                            <h4><?php echo $user->business_name;?></h4>
                            <p class="mb-0 text-grey"><i class="ion-ios-telephone"></i><?php echo $user->phone;?></p>
                            <p  class="mb-0 text-grey"><i class="ion-ios-location"></i> <?php echo $user->address;?></p>
                            <p  class="mb-0 text-grey"></p>
                        </div>
                    </div>
                    <div class="mt-4 my-account-add-list">
                        <h5 class="text-dark-grey font-weight-bold">Most Viewed Ads</h5>
                        <div class="row">
                  <?php 
                    foreach($productsMostViewed as $productmv){
                      $filename = WWW_ROOT.'product_img/'.$productmv->productsimages[0]->name;
                  ?>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-item">
                      <figure>
                        <a href="<?php echo $this->Url->build(["controller" => "Products","action" => "details", $productmv->id]);?>">
                          <?php
                                if(file_exists($filename) && $productmv->productsimages[0]->name != ""){
                            ?>
                            <div class="item-img" style="background:url(<?php echo $this->Url->build('/product_img/'.$productmv->productsimages[0]->name); ?>)"> 
                            </div>
                            <?php
                                }
                                else{
                             ?>
                             <div class="item-img" style="background:url(<?php echo $this->Url->build('/product_img/no-image.png'); ?>)"> 
                            </div>
                             <?php       
                                }
                            ?>
                          </a>
                          <figcaption>
                              <div class="top-part p-3">
                                  <h5 class="font-weight-bold"><?php echo $productmv->reg_number;?></h5>
                                   <h5 class="text-primary font-weight-bold mb-0">$<?php echo number_format($productmv->price,2);?></h5>
                              </div>
                              <div class="bottom-part p-3">
                                  <p class="mb-0">Model: <b><?php echo $productmv->Bikemodels->model_name;?></b></p>
                                  <p class="mb-0">Make: <b><?php echo $productmv->Makes->make_name;?></b></p>
                              </div>
                          </figcaption>
                      </figure>
                  </div>
                  <?php } ?>
                  <!-- <div class="col-lg-3 col-md-4 col-sm-6 col-item">
                      <figure>
                          <div class="item-img" style="background:url(<?php echo $this->Url->build('/img/pic/1.jpg'); ?>)"> 
                          </div>
                          <figcaption>
                              <div class="top-part p-3">
                                  <h5 class="font-weight-bold">Harley-Davidson-Fat-Bob</h5>
                                   <h5 class="text-primary font-weight-bold mb-0">$30,000.00</h5>
                              </div>
                              <div class="bottom-part p-3">
                                  <p class="mb-0">Model: <b>Fat-Bob-9949 - M</b></p>
                                  <p class="mb-0">Make: <b>2017</b></p>
                              </div>
                          </figcaption>
                      </figure>
                  </div> -->
                  
              </div>
                    </div>
                    <div class="mt-4 my-account-add-list">
                        <h5 class="text-dark-grey font-weight-bold">Recent View</h5>
                        <div class="row">
                  <?php 
                    foreach($productsRecent as $product){
                      $filename = WWW_ROOT.'product_img/'.$product->productsimages[0]->name;
                  ?>
                  <div class="col-lg-3 col-md-4 col-sm-6 col-item">
                      <figure>
                        <a href="<?php echo $this->Url->build(["controller" => "Products","action" => "details", $product->id]);?>">
                          <?php
                                if(file_exists($filename) && $product->productsimages[0]->name != ""){
                            ?>
                            <div class="item-img" style="background:url(<?php echo $this->Url->build('/product_img/'.$product->productsimages[0]->name); ?>)"> 
                            </div>
                            <?php
                                }
                                else{
                             ?>
                             <div class="item-img" style="background:url(<?php echo $this->Url->build('/product_img/no-image.png'); ?>)"> 
                            </div>
                             <?php       
                                }
                            ?>
                          </a>
                          <figcaption>
                              <div class="top-part p-3">
                                  <h5 class="font-weight-bold"><?php echo $product->reg_number;?></h5>
                                   <h5 class="text-primary font-weight-bold mb-0">$<?php echo number_format($product->price,2);?></h5>
                              </div>
                              <div class="bottom-part p-3">
                                  <p class="mb-0">Model: <b><?php echo $product->Bikemodels->model_name;?></b></p>
                                  <p class="mb-0">Make: <b><?php echo $product->Makes->make_name;?></b></p>
                              </div>
                          </figcaption>
                      </figure>
                  </div>
                  <?php } ?>
                  
                  <!-- <div class="col-lg-3 col-md-4 col-sm-6 col-item">
                      <figure>
                          <div class="item-img" style="background:url(<?php echo $this->Url->build('/img/pic/1.jpg'); ?>)"> 
                          </div>
                          <figcaption>
                              <div class="top-part p-3">
                                  <h5 class="font-weight-bold">Harley-Davidson-Fat-Bob</h5>
                                   <h5 class="text-primary font-weight-bold mb-0">$30,000.00</h5>
                              </div>
                              <div class="bottom-part p-3">
                                  <p class="mb-0">Model: <b>Fat-Bob-9949 - M</b></p>
                                  <p class="mb-0">Make: <b>2017</b></p>
                              </div>
                          </figcaption>
                      </figure>
                  </div> -->
              </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="myModal" class="modal fade srv-m" role="dialog">
  <div class="modal-dialog">

   
      <section>
        <div class="container" style="background-color: #fff; width: 680px;">

         
              <div class="panel panel-default">
              <div class="panel-heading pt-3 text-dark text-uppercase">Image Upload</div>
              <div class="panel-body">

                <div class="row">
                  <div class="col-md-6 text-center">
                  <div id="upload-demo"></div>
                  </div>
                  <div class="col-md-6">
                  <strong class="text-capitalize text-dark">Select Image:</strong>
                  <br/>
                  <input type="file" id="upload" class="form-control">
                  <br/>
                  <button class="btn btn-success upload-result rounded-0 mb-2">Upload Image</button>
                  <button type="button" class="btn btn-default rounded-0 mb-2 mdl" data-dismiss="modal">Close</button> 
                  </div>        
                </div>

              </div>
            </div>
          
          
        </div>
        </section>
      <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> -->
    

  </div>
</div>

<script type="text/javascript">
$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 100,
        height: 100,
        type: 'circle'
    },
    boundary: {
        width: 300,
        height: 300
    }
});

$('#upload').on('change', function () { 
  var reader = new FileReader();
    reader.onload = function (e) {
      $uploadCrop.croppie('bind', {
        url: e.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
      
    }
    reader.readAsDataURL(this.files[0]);
});

$('.upload-result').on('click', function (ev) {
  $uploadCrop.croppie('result', {
    type: 'canvas',
    size: 'viewport'
  }).then(function (resp) {
    //alert(resp);return false;

    $.ajax({
      url: '<?php echo $this->request->webroot;?>'+"users/thumbimage",
      type: "POST",
      data: {"image":resp},
      success: function (data) {
       var obj = $.parseJSON(data);
       if(obj.Ack == 1){
       
          $('#profile_image').attr('src', '<?php echo $this->request->webroot;?>user_img/thumb_'+obj.image);            
          $('#myModal').modal('hide');


       }
       
      }
    });
  });
});

</script>