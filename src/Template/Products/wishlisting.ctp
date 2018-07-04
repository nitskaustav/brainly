    <?php
    // echo "<pre>";
    // print_r($wishlistgeardata) ;die;
    ?>
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
                          <?php echo $this->element('side_menu');?>
                      </div>
                  </div>
                  <div class="col-lg-9">
                      <div class="right-side p-4">
                          <h2 class="mb-4">My Favourites</h2>
                          <div class="ads-list-area">
                            <?php                      
                              foreach ($wishlistgeardata as $wishlist) { 
                                // $upload = $wishlist->gear->upload;
                                // $upload_array = explode(",", $upload);
                                //echo $image_path = $this->request->webroot;die;
                                $filename = WWW_ROOT.'gear_img/'.$wishlist->gear->upload;

                                if(!file_exists($filename) || $wishlist->gear->upload == ''){
                                   $wishlist->gear->upload = 'no-image.png';
                                }                      
                            ?>
                              <div class="row mb-4 pb-4" id="wish_<?php echo $wishlist->id; ?>">
                                  <div class="col-md-2 pos-r">
                                  <div class="fav"><i class="ion ion-heart" style="color: #ff0000; cursor: pointer;" onclick="removewishlist('<?php echo $wishlist->id; ?>','gears');"></i></div>
                                      <img src="<?php echo $this->Url->build('/gear_img/'.$wishlist->gear->upload); ?>" alt="" class="img-fluid">
                                  </div>
                                  <div class="col-md-8 my-md-0 my-3">
                                      <h5 class="mb-0"><?php echo $wishlist->gear->product_name;?></h5>
                                      <!-- <p class="mb-0">Model: <b>Fat-Bob-9949 - M</b></p>
                                      <p class="mb-0">Make: <b>2017</b></p> -->
                                  </div>
                                  <div class="col-md-2">
                                      <h5>Price : <b class="text-primary">$<?php echo $wishlist->gear->price;?></b></h5>
                                      <a href="<?php echo $this->request->webroot; ?>products/categorydetails/<?php echo $wishlist->prod_id; ?>" class="btn btn-primary btn-sm">View Details</a>
                                  </div>
                              </div>
                            <?php } ?>

                            <?php 
                                  foreach ($wishlistbikedata as $wishlistbike) {
                                $productsimages = $wishlistbike->product->productsimages;

                                foreach ($productsimages as $prodimage){
                                  $prod_image = $prodimage->name;
                                  break;
                                }
                                $filename = WWW_ROOT.'product_img/'.$prod_image;

                                if(!file_exists($filename) || $prod_image == ''){
                                   $prod_image = 'no-image.png';
                                }
                            ?>
                            <div class="row mb-4 pb-4" id="wish_<?php echo $wishlistbike->id; ?>">
                                  <div class="col-md-2 pos-r">
                                  <div class="fav"><i class="ion ion-heart" style="color: #ff0000; cursor: pointer;" onclick="removewishlist('<?php echo $wishlistbike->id; ?>','bikes');"></i></div>
                                      <img src="<?php echo $this->Url->build('/product_img/'.$prod_image); ?>" alt="" class="img-fluid">
                                  </div>
                                  <div class="col-md-8 my-md-0 my-3">
                                      <h5 class="mb-0"><?php echo $wishlistbike->product->Makes->make_name." ".$wishlistbike->product->Bikemodels->model_name;?></h5>
                                      <p class="mb-0">Model: <b><?php echo $wishlistbike->product->Bikemodels->model_name;?></b></p>
                                      <p class="mb-0">Make: <b><?php echo $wishlistbike->product->Makes->make_name; ?></b></p>
                                  </div>
                                  <div class="col-md-2">
                                      <h5>Price : <b class="text-primary">$<?php echo $wishlistbike->product->price;?></b></h5>
                                      <a href="<?php echo $this->request->webroot; ?>products/details/<?php echo $wishlistbike->prod_id; ?>" class="btn btn-primary btn-sm">View Details</a>
                                  </div>
                              </div>
                            <?php } ?>
                              <!-- <div class="row mb-4 pb-4">
                                  <div class="col-md-2 pos-r">
                                  <div class="fav"><i class="ion ion-heart"></i></div>
                                      <img src="img/pic/1.jpg" alt="" class="img-fluid">
                                  </div>
                                  <div class="col-md-8 my-md-0 my-3">
                                      <h5 class="mb-0">Harley-Davidson-Fat-Bob Good</h5>
                                      <p class="mb-0">Model: <b>Fat-Bob-9949 - M</b></p>
                                      <p class="mb-0">Make: <b>2017</b></p>
                                  </div>
                                  <div class="col-md-2">
                                      <h5>Price : <b class="text-primary">$452</b></h5>
                                      <a href="#" class="btn btn-primary btn-sm">View Details</a>
                                  </div>
                              </div>
                              <div class="row mb-4 pb-4">
                                  <div class="col-md-2 pos-r">
                                  <div class="fav"><i class="ion ion-heart"></i></div>
                                      <img src="img/pic/1.jpg" alt="" class="img-fluid">
                                  </div>
                                  <div class="col-md-8 my-md-0 my-3">
                                      <h5 class="mb-0">Harley-Davidson-Fat-Bob Good</h5>
                                      <p class="mb-0">Model: <b>Fat-Bob-9949 - M</b></p>
                                      <p class="mb-0">Make: <b>2017</b></p>
                                  </div>
                                  <div class="col-md-2">
                                      <h5>Price : <b class="text-primary">$452</b></h5>
                                      <a href="#" class="btn btn-primary btn-sm">View Details</a>
                                  </div>
                              </div> -->
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>

      <script type="text/javascript">
        function removewishlist(id,status_val){
          //alert(id+status_val);return false;
          $.ajax({
              method: "POST",
              url: '<?php echo $this->request->webroot; ?>products/removewishlist',
              data: { id: id, status: status_val}
            })
            .done(function( data ) {
              //alert(data);return false;
              if(data == "FALSE"){
                alert("Please sign up or login to add to wish list");
                //return false;
              }
              else{
                var div_id = 'wish_'+id;
                $('#'+div_id+'').html("");
                // alert(data);
                // wishlistchange();
              }
              
            });
        }
      </script>