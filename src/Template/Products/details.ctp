<?php
//echo "<pre>";print_r($product);exit;

if(count($wishlist_data) == 0){
    $heartcolor = "none";
}
else{
    $heartcolor = "#ff0000";
}

?>

<div class="search-reasult">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="product-box">
                    <div class="d-flex flex-wrap justify-content-between product-box-top-heading">
                        <h2><?php echo $product->Categories->name.'-'.$product->Makes->make_name.'-'.$product->Bikemodels->model_name.'-'.$product->year?></h2>
                        <div>
                            <h3><span>$<?php echo number_format($product->price,2);?>    </span></h3>
                            <ul class="list-unstyled">
                                <li><a><i class="ion-heart" id="heart" style="color: <?php echo $heartcolor; ?>;" onclick="addtowishlist('<?php echo $product->id; ?>');"></i></a></li>
                                <li><a><i class="ion-android-share-alt"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-slider">
                    <div id="ninja-slider">
                        <div class="slider-inner">
                        <ul>
                            <?php foreach ($product->productsimages as $image) { ?>                               
                            <li><a class="ns-img" href="<?php echo $this->Url->build('/product_img/'.$image->name); ?>"></a></li>
                            <?php } ?>                                                  
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
                                        <?php foreach ($product->productsimages as $image) { ?>
                                        <li>
                                        <div class="overlay"></div>
                                        <a class="thumb" href="<?php echo $this->Url->build('/product_img/'.$image->name); ?>"></a>
                                        </li>
                                         <?php } ?>                                            
                                     </ul>
                                    </div>
                                    </div>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                    <div class="icons-box">
                        <ul  class="d-flex justify-content-center flex-wrap" >
                            <li>
                                <div class="icon"><img src="<?php echo $this->Url->build('/img/details/iocn-1.png'); ?>" alt="" /></div>
                                <p>Make:</p>
                                <span><?php echo $product->Makes->make_name;?></span>
                            </li>
                            <li>
                                <div class="icon"><img src="<?php echo $this->Url->build('/img/details/iocn-2.png'); ?>" alt="" /></div>
                                <p>Model:</p>
                                <span><?php echo $product->Bikemodels->model_name;?></span>
                            </li>
                            <li>
                                <div class="icon"><img src="<?php echo $this->Url->build('/img/details/iocn-3.png'); ?>" alt="" /></div>
                                <p>Year:</p>
                                <span><?php echo $product->year;?></span>
                            </li>
                            <!-- <li>
                                <div class="icon"><img src="<?php echo $this->Url->build('/img/details/iocn-4.png'); ?>" alt="" /></div>
                                <p>Category:</p>
                                <span><?php echo $product->Categories->name;?></span>
                            </li> -->
                            <li>
                                <div class="icon"><img src="<?php echo $this->Url->build('/img/details/iocn-5.png'); ?>" alt="" /></div>
                                <p>Mileage:</p>
                                <span><?php echo $product->mileage;?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="dsc">
                        <h2>Details <span>Posted 1 month ago</span></h2>
                        <div class="details">
                            <ul>
                                <li>
                                    <div class="titles">Reg Number:</div>
                                    <div class="valus"><?php echo $product->reg_number;?></div>
                                </li>
                                <li>
                                    <div class="titles">CC:</div>
                                    <div class="valus"><?php echo $product->cc;?></div>
                                </li>
                                <li>
                                    <div class="titles">Fuel Type:</div>
                                    <div class="valus">
                                        <?php 
                                            if($product->fuel_type == 'P')
                                                echo 'Petrol';
                                            elseif($product->fuel_type == 'D')
                                                echo 'Diesel';
                                            else
                                                echo 'elecrtric';
                                        ?>                                                
                                    </div>
                                </li>
                                <li>
                                    <div class="titles">No Of Owner:</div>
                                    <div class="valus"><?php echo $product->no_of_owner;?></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="dsc">
                        <h2>Description</h2>
                        <?php echo $product->description;?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="detail-right">
                    <div class="social-box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="owner">
                                    <h2>Miss Jenny</h2>
                                    <h3>Visit Website</h3>
                                    <h3>Profile’s Inventory</h3>
                                    <p>
                                        <a href="" class="btn call-btn">Reveal Phone</a>
                                    </p>
                                    <p>
                                        <a href="<?php echo $this->Url->build(["controller" => "Products","action" => "request", $product->id]);?>" class="btn request-btn">Request</a>
                                    </p>
                                    <?php
                                        if($user_id){ ?>
                                    <p>
                                        <a href="javascript: select_friend_foot(<?php echo $product->seller_id;?>)" class="btn request-btn" style="width: 50px; text-align: center;"><span class="user userCurrent click_msg text-center" data-id=<?php echo $message['id'];?> style="color: #fff; "> 
                                <i class="icon ion-chatboxes text-white"></i>
                            </span></a>
                                    </p>

                                    <?php    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="location">
                            <h2>Location</h2>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3046.595913017221!2d-111.7244243845393!3d40.21805077938876!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x874d997eb384a943%3A0x413fee719772de7a!2sProvo+Airport!5e0!3m2!1sen!2sin!4v1503403518731" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                    <div class="location">
                        <h3>Message</h3>
                        <form method="post" action="<?php echo $this->Url->build(["controller" => "Products","action" => "details", $product->id]);?>"  id="frmRequest" onsubmit = "return validate();">
                            <div class="form-group">
                            <input class="form-control" type="text" placeholder="Name" name="name" id="name">
                            </div>
                            <div class="form-group">
                            <input class="form-control" type="text" placeholder="Email" name="email" id="email">
                            </div>
                            <div class="form-group">
                            <input class="form-control" type="text" placeholder="Phone" name="phone" id="phone">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Message" rows="3" name="message" id="message"></textarea>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">Send Message</button>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <div class="location">
                        <h3>User Reviews</h3>
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
                        </div>
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
            <div class="col-lg-3 col-sm-6 col-item">
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
            </div>
            <div class="col-lg-3 col-sm-6 col-item">
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
            </div>
            <div class="col-lg-3 col-sm-6 col-item">
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
            </div>
            <div class="col-lg-3 col-sm-6 col-item">
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
            </div>
        </div>
    </div>
</section>
</section>
<script type="text/javascript">
    $(function(){
        $( "#frmRequest" ).validate({
        rules: {
          'name': "required",                  
          'email': {
            required: true
          },
          'phone': "required",
          'message': "required"          
        },
        messages: {
          'name': "Please enter your name.",          
          'email': "Please enter a valid email address.",          
          'phone': "Please enter your phone number.", 
          'message': "Please enter your message."
          
        },


      });
    })
    /**/
</script>
<script type="text/javascript">
    function validate(){
        // alert("Hi"); 
        // return false;

        if($("#name").val().search(/\S/) == -1){
            alert("Please provide name");return false;
        }

        if($("#email").val().search(/\S/) == -1){
            alert("Please provide email");return false;
        }

        var email = $("#email").val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (!filter.test(email)) {
            alert('Please provide a valid email address');
            email.focus;
            return false;
        }

        if($("#phone").val().search(/\S/) == -1){
            alert("Please provide phone");return false;
        }

        var phone = $("#phone").val();
        if(isNaN(phone)){
            alert("Phone number should be numeric");return false;
        }

        if($("#message").val().search(/\S/) == -1){
            alert("Please provide message");return false;
        }

        return true;
        
    }
</script>

<script type="text/javascript">
    function addtowishlist(product_id){
        
        $.ajax({
            method: "POST",
            url: '<?php echo $this->request->webroot; ?>products/addtowishlist',
            data: { id: product_id, status: 'bikes'}
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