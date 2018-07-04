    <?php
      // echo "<pre>";
      // print_r($all_temp_cart_data);die;
      $user_id = $user['id'];
      if(count($all_temp_cart_data) == 0){
        echo "<center><h2>Your cart is empty</h2></center>";
      }
      else{
    ?>
    <section class=" py-5">
          <div class="container">
              <div class="row">
              <div class="col-lg-8">
                      <div class="right-side p-4">
                          <h2 class="mb-4">Shopping Bag</h2>
                          <div class="oder-list cart-list">
                                <?php
                                  foreach ($all_temp_cart_data as $alltempdata) { 
                                        $filename = WWW_ROOT.'gear_img/'.$alltempdata->gear->upload;

                                        if(!file_exists($filename) || $alltempdata->gear->upload == ''){
                                           $alltempdata->gear->upload = 'no-image.png';
                                        }

                                    ?>
                                <form name="frm_<?php echo $alltempdata->id; ?>" method="POST" action="<?php echo $this->request->webroot; ?>products/updatecart">
                                <div class="row mb-4 pb-4" id="div_<?php echo $alltempdata->id; ?>">
                                  <div class="col-lg-2">
                                    <a href="<?php echo $this->request->webroot; ?>products/categorydetails/<?php echo $alltempdata->prd_id; ?>">
                                      <img src="<?php echo $this->request->webroot . 'gear_img/'.$alltempdata->gear->upload; ?>" alt="" class="img-fluid">
                                    </a>
                                  </div>
                                  <div class="col-lg-9">
                                      <p><?php echo $alltempdata->name; ?></p>
                                      <!--<p>Quantity : 3</p>-->
                                      <p>Price : <b>$<?php echo $alltempdata->price; ?></b></p>
                                      <div class="qty">
                                      <span style="float: left;">Quantity</span>
                                      <div class="qut_box">             <input type="number" name="qty" value="<?php echo $alltempdata->quantity; ?>" onchange="this.form.submit();">
                                      <input type="hidden" name="id" value="<?php echo $alltempdata->id; ?>">
                                      <input name="user_id" type="hidden" value="<?php echo $alltempdata->user_id; ?>">
                                      <input name="prd_id" type="hidden" value="<?php echo $alltempdata->prd_id; ?>">

                                        <!-- <div class="qtysectionbox">
                                          <div class="qtysectionunit l">
                                            <input type="hidden">2
                                          </div>
                                          <div class="qtysectionnav l">
                                            <div class="qtysectionnavplus l"><a>+</a></div>
                                            <div class="qtysectionnavminus l"><a>-</a></div>
                                          </div>
                                          
                                        </div> -->
                                        </div>       
                                        </div>
                                        <!-- <p><a href="#" class="btn btn-primary btn-sm">Proceed to Purchase</a></p> -->
                                      </div>
                                  
                                  <div class="col-lg-1">
                                      <a href="#" style="text-align: right; color: red;" onclick="javascript: remove_product('<?php echo $alltempdata->id; ?>');"><i class="ion-close-circled"></i></a>
                                  </div>
                              </div>
                            </form>
                                  <?php } ?>
                               
                              
                             
                          </div>
						 
                      </div>
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
            <!-- 
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
                                          
                                          <span><?php echo $total_price; ?></span>
                                      </li>
                            <!-- <li class="d-flex justify-content-between">
                                          <span>Shipping Charge</span>
                                          <span>$143</span>
                            </li> -->
                            <li class="d-flex justify-content-between">
                                          <b>Total</b>
                                          <b><?php echo $total_price; ?></b>
                                      </li>
                        </ul>
                        
                        <form method="get" action="<?php echo $this->request->webroot; ?>products/proceedtocheckout/<?php echo $user_id ?>">
                          <!-- <input type="text" name="user_id" value="<?php echo $user_id; ?>"> -->
                        <button class="btn btn-primary btn-block">PROCEED TO CHECKOUT</button>
                      </form>
                    </div>
                </div>
                  
              </div>
          </div>
      </section>
      <?php } ?>
<script type="text/javascript">

  function remove_product(id){
    if(confirm("Are you sure you want to delete?") == true){
      $.ajax({
            method: "POST",
            url: '<?php echo $this->request->webroot; ?>products/removefromcart',
            data: { id: id}
          })
          .done(function( data ) {
            //alert(data);
            var div_id = "div_"+id;
            $("#"+div_id+"").html("");

             var url = "<?php echo $this->request->webroot; ?>products/cart";
              $(location).attr('href',url);
          });
    }
    
  }
</script>
    