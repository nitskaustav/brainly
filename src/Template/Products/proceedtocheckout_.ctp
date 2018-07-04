<?php
//echo "<pre>";
//print_r($all_temp_cart_data);
// echo "<pre>";
// print_r($user);die;
?>
    
    <section class="py-5 checkout-page">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-xl-6 col-lg-8">
                    <form method="post" action="<?php echo $this->request->webroot; ?>products/payment" class="" onsubmit="return validate();">
                        <h3 class="mb-4">Shipping Information</h3>
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" id="ship_fname" name="ship_fname" value="<?php echo $user['first_name'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" id="ship_lname" name="ship_lname" value="<?php echo $user['last_name'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" id="ship_addr" name="ship_addr" value="<?php echo $user['address'] ?>">
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" id="ship_city" name="ship_city" value="<?php echo $user['city'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" class="form-control" id="ship_country" name="ship_country" value="<?php echo $user['country'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Pincode</label>
                            <input type="text" class="form-control" id="ship_pin" name="ship_pin" value="<?php echo $user['postcode'] ?>">
                        </div>
                    
                        <h3 class="mb-4">Billing Information</h3>
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" id="bill_fname" name="bill_fname" value="<?php echo $user['first_name'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" id="bill_lname" name="bill_lname" value="<?php echo $user['last_name'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" id="bill_addr" name="bill_addr" value="<?php echo $user['address'] ?>">
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" id="bill_city" name="bill_city" value="<?php echo $user['city'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" class="form-control" id="bill_country" name="bill_country" value="<?php echo $user['country'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Pincode</label>
                            <input type="text" class="form-control" id="bill_pin" name="bill_pin" value="<?php echo $user['postcode'] ?>">
                        </div>
                    
                        <h3 class="my-4  ml-3">Payment Method</h3>
                        <div class="form-group col-12">
                            <span class="radios">
                                <input type="radio" name="paymenthod" id="paypalradio" value="paypal" onclick="not_available();">
                                <span class="mx-2">Pay with <img src="<?php echo $this->request->webroot; ?>img/paypal-logo.png" style="width:100px;"></span>
                            </span>
                        </div>
                        <!-- <div class="form-group col-12">
                            <span class="radios">
                                <input type="radio" name="a">
                                <span class="mx-2">Pay with <img src="img/Credit-Card-Visa-And-Master-Card-PNG-File.png" style="width:100px;"></span>
                            </span>
                        </div> -->
                        <div class="form-group col-12">
                            <span class="radios">
                                <input type="radio" name="paymenthod" id="codradio" value="cod">
                                <span class="mx-2">COD <img src="<?php echo $this->request->webroot; ?>img/cod.png" style="width:100px;"></span>
                            </span>
                        </div>
                            <!-- <div class="form-group col-12">
                                <label>Name On Your Card</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group col-12">
                                <label>Card Number</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group col-8">
                                <label>Expiry Date</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>CVV3</label>
                                <input type="text" class="form-control">
                            </div> -->
                        <div class="form-group col-4">
                                <button class="btn btn-primary btn-lg">Pay Now</button>
                            </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="product-info p-4 border">
            <?php $total_price = ''; foreach ($all_temp_cart_data as $alltempdata) { 
                $total_price += $alltempdata->price;
              ?>
              <figure class="row mt-4">
                <div class="col-2 pr-0">
                    <img src="<?php echo $this->request->webroot . 'product_img/'.$alltempdata->image; ?>" alt="" class="img-fluid">
                </div>
                <figcaption class="col-7 pr-0">
                    <p class="mb-0"><?php echo $alltempdata->name; ?></p>
                </figcaption>
                <div class="col-3 text-right">$<?php echo $alltempdata->price; ?></div>
              </figure>
              <?php } ?>
            <!-- <figure class="row mt-4">
                <div class="col-2 pr-0">
                    <img src="img/bike/1.jpg" alt="" class="img-fluid">
                </div>
                <figcaption class="col-7 pr-0">
                    <p class="mb-0">Titanium granitt, polert</p>
                </figcaption>
                <div class="col-3 text-right">$158</div>
            </figure>
            <figure class="row mt-4">
                <div class="col-2 pr-0">
                    <img src="img/bike/2.jpg" alt="" class="img-fluid">
                </div>
                <figcaption class="col-7 pr-0">
                    <p class="mb-0">Titanium granitt, polert</p>
                </figcaption>
                <div class="col-3 text-right">$158</div>
            </figure>
            <figure class="row mt-4">
                <div class="col-2 pr-0">
                    <img src="img/bike/3.jpg" alt="" class="img-fluid">
                </div>
                <figcaption class="col-7 pr-0">
                    <p class="mb-0">Titanium granitt, polert</p>
                </figcaption>
                <div class="col-3 text-right">$158</div>
            </figure> -->
                        <ul class="pay-list">
                            <li class="d-flex justify-content-between">
                                          <span>Price</span>
                                          
                                          <span>$<?php echo $total_price; ?></span>
                                      </li>
                            <li class="d-flex justify-content-between">
                                          <!-- <span>Shipping Charge</span>
                                          <span>$143</span> -->
                                      </li>
                            <li class="d-flex justify-content-between">
                                          <b>Total</b>
                                          <b>$<?php echo $total_price; ?></b>
                                      </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
    	function validate(){
    		//alert('hi');return false;

    		if($("#ship_fname").val().search(/\S/) == -1){
	            alert("Please provide shipping first name");return false;
	        }
	        if($("#ship_lname").val().search(/\S/) == -1){
	            alert("Please provide shipping last name");return false;
	        }
	        if($("#ship_addr").val().search(/\S/) == -1){
	            alert("Please provide shipping address");return false;
	        }
	        if($("#ship_city").val().search(/\S/) == -1){
	            alert("Please provide shipping city");return false;
	        }
	        if($("#ship_country").val().search(/\S/) == -1){
	            alert("Please provide shipping country");return false;
	        }
	        if($("#ship_pin").val().search(/\S/) == -1){
	            alert("Please provide shipping pincode");return false;
	        }

	        if($("#bill_fname").val().search(/\S/) == -1){
	            alert("Please provide billing first name");return false;
	        }
	        if($("#bill_lname").val().search(/\S/) == -1){
	            alert("Please provide billing last name");return false;
	        }
	        if($("#bill_addr").val().search(/\S/) == -1){
	            alert("Please provide billing address");return false;
	        }
	        if($("#bill_city").val().search(/\S/) == -1){
	            alert("Please provide billing city");return false;
	        }
	        if($("#bill_country").val().search(/\S/) == -1){
	            alert("Please provide billing country");return false;
	        }
	        if($("#bill_pin").val().search(/\S/) == -1){
	            alert("Please provide billing pincode");return false;
	        }

	        // if($("#paypalradio").attr('checked') == false && $("#codradio").attr('checked') == false){
	        // 	alert("Please select a payment method.");return false;
	        // }

	        if(document.getElementById("paypalradio").checked == false && document.getElementById("codradio").checked == false){
	        	alert("Please select a payment method");return false;
	        }

	        return true;

    	}

    	function not_available(){
    		alert('This option currently not available');
    		document.getElementById("paypalradio").checked = false;
    		//return false;
    	}
    </script>