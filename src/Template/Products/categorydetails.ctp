<?php
// echo "<pre>";
// print_r($gears_images);die;


if(count($wishlist_data) == 0){
	$heartcolor = "none";
}
else{
	$heartcolor = "#ff0000";
}


foreach ($gears as $gear_val) {
	$gear_id = $gear_val->id;
	$category_name = $gear_val->category->name;
	$brand_name = $gear_val->brand->brand_name;
	$size = $gear_val->size_id;
	$price = $gear_val->price;
	$description = $gear_val->description;
	$item_location = $gear_val->item_location;
	$product_name = $gear_val->product_name;
	$upload = $gear_val->upload;
	$color = $gear_val->colour_id;
}
//$upload_array = explode(",", $upload);
$color_array = explode(",",$color);
// print_r($upload_array);
// die;
?>
    
    <!--   inner  banner   -->
    
    <section class="inner-banner py-4">
        <div class="container">
            <!-- <div class="inner-banner-area">
                <img src="img/inner-banner.jpg" alt="" class="img-fluid">
                <a class="close-btn"><i class="ion-close"></i></a>
            </div> -->
        </div>
    </section>
    
    <!--   search   details   -->
    
    <div class="search-reasult">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="product-box">
                    <div class="d-flex flex-wrap justify-content-between product-box-top-heading">
                        <h2><?php echo $product_name; ?></h2>
                        <div>
                            <h3><span>$<?php echo $price; ?></span></h3>
                            <ul class="list-unstyled">
                                <li><a><i class="ion-heart" id="heart" style="color: <?php echo $heartcolor; ?>;" onclick="addtowishlist('<?php echo $gear_id; ?>');"></i></a></li>
                                <li><a><i class="ion-android-share-alt"></i></a></li>
                            </ul>
                        </div>
                    </div>
					<div class="product-slider">
					<div id="ninja-slider">
            			<div class="slider-inner">
            			<ul>
            				<?php foreach ($gears_images as $gearimage) { 

            					  $filename = WWW_ROOT.'gear_img/'.$gearimage->name;

		                          if(!file_exists($filename) || $gearimage->name == ''){
		                             $gearimage->name = 'no-image.png';
		                          }

            				?>
            					<li><a class="ns-img" href="<?php echo $this->request->webroot . 'gear_img/'.$gearimage->name; ?>"></a></li>
            				<?php } ?>
            				<!-- <li><a class="ns-img" href="img/bike/1.jpg"></a></li>
            				<li><a class="ns-img" href="img/bike/2.jpg"></a></li>
            				<li><a class="ns-img" href="img/bike/3.jpg"></a></li>
            				<li><a class="ns-img" href="img/bike/4.jpg"></a></li>
            				<li><a class="ns-img" href="img/bike/5.jpg"></a></li> -->       				
            			</ul>
							<!--<div class="big-img">
						 		<img src="img/cannon-big.jpg" alt="" /
							</div>>-->
						</div>
					</div>
						<div class="thumbs">
							<ul>
								
								<li>
									<div id="thumbnail-slider" style="float:left;">
            						<div class="inner">
            						 <ul>
            						 	<?php foreach ($gears_images as $gearimage) { ?>
			            					<li>
		            						 	<div class="overlay"></div>
		            						 	<a class="thumb" href="<?php echo $this->request->webroot . 'gear_img/'.$gearimage->name; ?>"></a>
		            						 	<p class="mb-0">Category: <b><?php echo $gear_val->category->name; ?></b></p>
                                        <p class="mb-0">Brand: <b><?php echo $gear_val->brand->brand_name; ?></b></p>
                                        
	            						 	</li>
			            				<?php } ?>
            						 	<!-- <li>
            						 	<div class="overlay"></div>
            						 	<a class="thumb" href="img/bike/1.jpg"></a>
            						 	</li>
            						 	<li>
            						 	<div class="overlay"></div>
            						 	<a class="thumb" href="img/bike/2.jpg"></a>
            						 	</li>
            						 	<li>
            						 	<div class="overlay"></div>
            						 	<a class="thumb" href="img/bike/3.jpg"></a>
            						 	</li>
            						 	<li>
            						 	<div class="overlay"></div>
            						 	<a class="thumb" href="img/bike/4.jpg"></a>
            						 	</li>
            						 	<li>
            						 	<div class="overlay"></div>
            						 	<a class="thumb" href="img/bike/5.jpg"></a>
            						 	</li> -->
            						 </ul>
            						</div>
            						</div>
								</li>
								
							</ul>
						</div>
					</div>
					<!-- <div class="icons-box">
						<ul  class="d-flex justify-content-center flex-wrap" >
							<li>
								<div class="icon"><img src="img/details/iocn-1.png" alt="" /></div>
								<p>Make:</p>
								<span>Harley-Davidson</span>
							</li>
                            
						</ul>
					</div> -->
					<!-- <div class="dsc">
						<h2>Details <span>Posted 1 month ago</span></h2>
						<div class="details">
							<ul>
								<li>
									<div class="titles">Category:</div>
									<div class="valus"><?php echo $category_name; ?></div>
								</li>
								<li>
									<div class="titles">Brand:</div>
									<div class="valus"><?php echo $brand_name; ?></div>
								</li>
								<li>
									<div class="titles">Name:</div>
									<div class="valus"><?php echo $product_name; ?></div>
								</li>
								<li>
									<div class="titles">Size:</div>
									<div class="valus"><?php echo $size; ?></div>
								</li>
							</ul>
						</div>
					</div> -->
					<div class="dsc">
						<h2>Description</h2>
						<p><?php echo $description; ?></p>
						<!-- <p>
                          <?php
                            $addtocart = $this->Url->build(["controller" => "Products","action" => "addtocart", $gear_val->id]);
                          ?>
                          <a href="<?php echo $addtocart; ?>" class="btn btn-primary"">Add To Cart</a>
                      	</p> -->
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="detail-right">
					<div class="social-box">
						<div class="row">
							<div class="col-md-12">
								<h5>Details <span>Posted 1 month ago</span></h5>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								Category: <?php echo $category_name; ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								Brand: <?php echo $brand_name; ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								Name: <?php echo $product_name; ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								Size: <?php echo $size; ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								Colour: <br>
								<?php 
									foreach ($color_hexcode as $color_val) {
										
										?>
										<label style="background: <?php echo $color_val->hexcode; ?>; color: none; border-radius: 100%; height: 20px; width: 20px;"></label>&nbsp;
										<?php
									}
								?>
							</div>
						</div>
						<div class="row">
							<?php if($user->utype == 1){ ?>
							<div class="col-md-12">
								<p>
		                          <?php
		                            $addtocart = $this->Url->build(["controller" => "Products","action" => "addtocart", $gear_val->id]);

		                          ?>
		                          <a href="<?php echo $addtocart; ?>" class="btn btn-primary"">Add To Cart</a>
		                      	</p>
							</div>
							
							<div class="col-md-12">
								<p>
								<?php
	                            $review = $this->Url->build(["controller" => "Products","action" => "addreview", $gear_val->id]);
	                          	?>                       
	                          		<a href="#" class="btn btn-primary" onclick="showrating();" >Add Review</a>
	                      		</p>
							</div>
							<?php } ?>
							<div class="col-md-12">
								
					<div id="ratereview" hidden>
                        <h3>Review &amp; Rating</h3>
                        <form method="post" action="<?php echo $this->Url->build(["controller" => "Products","action" => "addratingreview", $gear_val->id]);?>"  id="frmrating" onsubmit = "return validate();">
                                  
                            <div class="form-group" style="text-align: left;">
	                            <input class="form-control" type="radio" name="rating" value="1">
	                            <input class="form-control" type="radio" name="rating" value="2">
	                            <input class="form-control" type="radio" name="rating" value="3">
	                            <input class="form-control" type="radio" name="rating" value="4">
	                            <input class="form-control" type="radio" name="rating" value="5">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Review" rows="3" name="review" id="review"></textarea>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary" >Submit</button>
                            </div>
                        </form>
                    </div>
								
							</div>
						</div>
						
					</div>
					<!-- <div class="location">
							
					</div>
					<div class="location">
						
					</div> -->
					<div class="clearfix"></div>
					<div class="location">

						<h3>User Reviews</h3>
						<?php
						foreach ($review_data as $review_val) {
							$rating = $review_val->rating;
							$review = $review_val->review;
							$review_date = $review_val->review_date;

							$full_name = $review_val->user->first_name." ".$review_val->user->last_name;
						
						?>
						<div class="review-box">
							<h2><?php echo $full_name; ?><span>
								<?php for($i=1;$i<=$rating;$i++){
								?>
								<i class="ion-android-star"></i>
								<?php } ?>
								<!-- <i class="ion-android-star"></i>
								<i class="ion-android-star"></i>
								<i class="ion-android-star"></i>
								<i class="ion-android-star"></i>
								<i class="ion-android-star"></i> -->
							</span></h2>
							<h3><?php echo $review_date; ?></h3>
							<p>
								<?php echo $review; ?>
							</p>	
						</div>
						<?php } ?>
						<!-- <div class="review-box">
							<h2>Mark Rufalo <span>
								<i class="ion-android-star"></i>
								<i class="ion-android-star"></i>
								<i class="ion-android-star"></i>
								<i class="ion-android-star"></i>
								<i class="ion-android-star"></i>
							</span></h2>
							<h3>July 22, 2017</h3>
							<p>
								Sed ullamcorper placerat enim vel tincidunt. Phasellus ante sem, molestie nec nulla sit amet,.
							</p>	
						</div>
						<div class="review-box">
							<h2>Mark Rufalo <span>
								<i class="ion-android-star"></i>
								<i class="ion-android-star"></i>
								<i class="ion-android-star"></i>
								<i class="ion-android-star"></i>
								<i class="ion-android-star"></i>
							</span></h2>
							<h3>July 22, 2017</h3>
							<p>
								Sed ullamcorper placerat enim vel tincidunt. Phasellus ante sem, molestie nec nulla sit amet,.
							</p>	
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
    
    <section class="py-5">
        <div class="container">
            <h2>Related Products</h2>
            <div class="row">
            	<?php 
            		foreach($gear_related_data as $gear_relateddata){
            // 			$gear_upload = $gear_relateddata->upload;
        				// $gear_upload_array = explode(",", $gear_upload);
        				$filename = WWW_ROOT.'gear_img/'.$gear_relateddata->upload;

	                      if(!file_exists($filename) || $gear_relateddata->upload == ''){
	                         $gear_relateddata->upload = 'no-image.png';
	                      }
                          
        				$background_url = $this->request->webroot . 'gear_img/'.$gear_relateddata->upload;

        				if($gear_relateddata->id == $gear_id)
        					continue;
        			?>
        			<div class="col-lg-3 col-sm-6 col-item">
		                <figure>
		                        <a href="<?php echo $this->Url->build(["controller" => "Products","action" => "categorydetails", $gear_relateddata->id]);?>"><div class="item-img" style="background:url(<?php echo $background_url; ?>)"> 
		                        </div></a>
		                        <figcaption>
			                        <div class="top-part p-3">
			                            <h5 class="font-weight-bold"><?php echo $gear_relateddata->product_name; ?></h5>
			                            <h5 class="text-primary font-weight-bold mb-0">$<?php echo $gear_relateddata->price; ?></h5>
			                        </div>
		                        <!-- <div class="bottom-part p-3">
		                            <p class="mb-0">Model: <b>Fat-Bob-9949 - M</b></p>
		                            <p class="mb-0">Make: <b>2017</b></p>
		                        </div> -->
		                        </figcaption>
		                </figure>
		            </div>
        			<?php
            		}
            	?>
                <!-- <div class="col-lg-3 col-sm-6 col-item">
                    <figure>
                        <div class="item-img" style="background:url(./img/pic/1.jpg)"> 
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
                </div>
                <div class="col-lg-3 col-sm-6 col-item">
                    <figure>
                        <div class="item-img" style="background:url(./img/pic/1.jpg)"> 
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
                </div>
                <div class="col-lg-3 col-sm-6 col-item">
                    <figure>
                        <div class="item-img" style="background:url(./img/pic/1.jpg)"> 
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
                </div>
                <div class="col-lg-3 col-sm-6 col-item">
                    <figure>
                        <div class="item-img" style="background:url(./img/pic/1.jpg)"> 
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
    </section>

    <script type="text/javascript">
    	function addtowishlist(product_id){
    		
    		$.ajax({
	            method: "POST",
	            url: '<?php echo $this->request->webroot; ?>products/addtowishlist',
	            data: { id: product_id, status: 'gears'}
	          })
	          .done(function( data ) {
	          	if(data == "FALSE"){
	          		alert("Please sign up or login to add to wish list");
	          		//return false;
	          	}
	          	else{
	          		alert(data);
	          		wishlistchange();
	          	}
	          	
          	});

    		
    		
    	}
    	function wishlistchange(){
    		if(document.getElementById("heart").style.color == ''){
    			document.getElementById("heart").style.color = '#ff0000';
    		}
    		else if(document.getElementById("heart").style.color != ''){
    			document.getElementById("heart").style.color = '';
    		}
    	}

    </script>
    <script type="text/javascript">
    	function showrating(){
    		document.getElementById("ratereview").hidden = false;
    	}
    </script>