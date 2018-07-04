
    <section class="py-5 checkout-page">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-8">
                    <form method="post" action="<?php echo $this->request->webroot; ?>products/payment" class="" onsubmit="return validate();">
                    <div class="row">
                    	<div class="col-md-6">
                        <h3 class="mb-4">Shipping Information</h3>
                        <div class="form-group">
                            <label>First Name:</label>
                            <input type="text" name="ship_fname" id="ship_fname" class="form-control" value="<?php echo $user['first_name'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Last Name:</label>
                            <input type="text" name="ship_lname" id="ship_lname" class="form-control" value="<?php echo $user['last_name'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Mobile Number:</label>
                            <input type="text" id="ship_mob" name="ship_mob" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Pincode:</label>
                            <input type="text" id="ship_pin" name="ship_pin" class="form-control" value="<?php echo $user['postcode'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Flat, House no., Building, Company, Apartment: </label>
                            <input type="text" name="ship_flat" id="ship_flat" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Area, Colony, Street, Sector, Village:</label>
                            <input type="text" name="ship_area" id="ship_area" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Town/City:</label>
                            <input type="text" id="ship_city" name="ship_city" class="form-control" value="<?php echo $user['city'] ?>">
                        </div>
                        <div class="form-group">
                            <label>State:</label>
                            <input type="text" class="form-control" id="ship_state" name="ship_state">
                        </div>
                        <div class="form-group">
                            <label>Landmark e.g. near apollo hospital:</label>
                            <input type="text" id="ship_landmark" name="ship_landmark" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" class="form-control" id="ship_country" name="ship_country" value="<?php echo $user['country'] ?>">
                        </div>
                         <!-- <div class="form-group mt-4">
                                <button class="btn btn-primary btn-lg">Deliver to this address</button>
                        </div> -->
                        </div>
                        <div class="col-md-6">
                        <h3 class="mb-4">Billing Information</h3>
                        <div class="form-group">
                            <label>First Name:</label>
                            <input type="text" id="bill_fname" name="bill_fname" class="form-control" value="<?php echo $user['first_name'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Last Name:</label>
                            <input type="text" id="bill_lname" name="bill_lname" class="form-control" value="<?php echo $user['last_name'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Mobile Number:</label>
                            <input type="text" id="bill_mob" name="bill_mob" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Pincode:</label>
                            <input type="text" id="bill_pin" name="bill_pin" class="form-control" value="<?php echo $user['postcode'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Flat, House no., Building, Company, Apartment: </label>
                            <input type="text" name="bill_flat" id="bill_flat" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Area, Colony, Street, Sector, Village:</label>
                            <input type="text" id="bill_area" name="bill_area" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Town/City:</label>
                            <input type="text" id="bill_city" name="bill_city" class="form-control" value="<?php echo $user['city'] ?>">
                        </div>
                        <div class="form-group">
                            <label>State:</label>
                            <input type="text" id="bill_state" name="bill_state" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Landmark e.g. near apollo hospital:</label>
                            <input type="text" id="bill_landmark" name="bill_landmark" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" class="form-control" id="bill_country" name="bill_country" value="<?php echo $user['country'] ?>">
                        </div>
                        <!-- <div class="form-group mt-4">
                                <button class="btn btn-primary btn-lg">Deliver to this address</button>
                        </div> -->
                        </div>
                        <h3 class="my-4  ml-3">Payment Method</h3>
                        <div class="form-group col-12">
                            <span class="radios">
                                <input type="radio" name="paymethod" id="paypalradio" value="paypal" onclick="not_available();">
                                <span class="mx-2">Pay with <img src="<?php echo $this->request->webroot; ?>img/paypal-logo.png" style="width:100px;"></span>
                            </span>
                        </div>
                        <div class="form-group col-12">
                            <span class="radios">
                                <input type="radio" name="paymethod" id="codradio" value="cod">
                                <span class="mx-2">COD <img src="<?php echo $this->request->webroot; ?>img/cod.png" style="width:100px;"></span>
                            </span>
                        </div>
                        <div class="form-group col-4">
                            <button class="btn btn-primary btn-lg">Pay Now</button>
                        </div>
                        </div>
                    </form>
                    
                </div>
                <div class="col-lg-4">
                    <div class="product-info p-4 border">
                        <?php $total_price = ''; foreach ($all_temp_cart_data as $alltempdata) { 
                $total_price += $alltempdata->price;

                $filename = WWW_ROOT.'gear_img/'.$alltempdata->gear->upload;

                  if(!file_exists($filename) || $alltempdata->gear->upload == ''){
                     $alltempdata->gear->upload = 'no-image.png';
                  }
              ?>
              <figure class="row mt-4">
                <div class="col-2 pr-0">
                    <img src="<?php echo $this->request->webroot . 'gear_img/'.$alltempdata->gear->upload; ?>" alt="" class="img-fluid">
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
                            <!-- <li class="d-flex justify-content-between">
                                          <span>Shipping Charge</span>
                                          <span>$143</span>
                                      </li> -->
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
            if($("#ship_mob").val().search(/\S/) == -1){
                alert("Please provide shipping mobile number");return false;
            }
            if($("#ship_pin").val().search(/\S/) == -1){
                alert("Please provide shipping pincode");return false;
            }
            if($("#ship_flat").val().search(/\S/) == -1){
                alert("Please provide shipping Flat, House no details");return false;
            }
            if($("#ship_area").val().search(/\S/) == -1){
                alert("Please provide shipping area, street details");return false;
            }
            if($("#ship_city").val().search(/\S/) == -1){
                alert("Please provide shipping city");return false;
            }
            if($("#ship_state").val().search(/\S/) == -1){
                alert("Please provide shipping state details");return false;
            }
            if($("#ship_landmark").val().search(/\S/) == -1){
                alert("Please provide shipping landmark details");return false;
            }
            if($("#ship_country").val().search(/\S/) == -1){
                alert("Please provide shipping country");return false;
            }
            
            

            if($("#bill_fname").val().search(/\S/) == -1){
                alert("Please provide billing first name");return false;
            }
            if($("#bill_lname").val().search(/\S/) == -1){
                alert("Please provide billing last name");return false;
            }
            if($("#bill_mob").val().search(/\S/) == -1){
                alert("Please provide biling mobile number");return false;
            }
            if($("#bill_pin").val().search(/\S/) == -1){
                alert("Please provide billing pincode");return false;
            }
            if($("#bill_flat").val().search(/\S/) == -1){
                alert("Please provide billing Flat, House no details");return false;
            }
            if($("#bill_area").val().search(/\S/) == -1){
                alert("Please provide billing area, street details");return false;
            }
            if($("#bill_city").val().search(/\S/) == -1){
                alert("Please provide billing city");return false;
            }
            if($("#bill_state").val().search(/\S/) == -1){
                alert("Please provide billing state details");return false;
            }
            if($("#bill_landmark").val().search(/\S/) == -1){
                alert("Please provide billing state details");return false;
            }
            if($("#bill_country").val().search(/\S/) == -1){
                alert("Please provide billing country");return false;
            }

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