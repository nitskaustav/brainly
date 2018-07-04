<?php

// echo "<pre>";
// print_r($order_details);exit;

foreach($order_details as $order_data){
	
	$user_details['id'] = $order_data->user_id;
	$user_details['order_date'] = $order_data->order_date;
	$user_details['total_price'] = $order_data->total_price;
	$user_details['payment_mode'] = $order_data->payment_mode;
	$user_details['shipping_address'] = $order_data->shipping_address;
  $shipping_address = $order_data->shipping_address;
	$user_details['billing_address'] = $order_data->billing_address;
  $billing_address = $order_data->billing_address;
	$user_details['order_status'] = $order_data->order_status;

	$order_details_data = $order_data->order_details;
}

$shipping_address_array = explode(",", $shipping_address);
$billing_address_array = explode(",", $billing_address);


//print_r($order_details_data);die;


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
            <div class="row">
              <div class="col-lg-9">
                <div class="right-side p-4">
                    <h2 class="mb-4">Order history</h2>
                      <div class="row mb-4 pb-4">
                          <div class="col-md-2">
                              <img src="img/pic/1.jpg" alt="" class="img-fluid">
                          </div>
                          <div class="col-md-10 my-md-0 my-3">
                              <!-- <h5 class="mb-0">Harley-Davidson-Fat-Bob Good</h5>
                              <p class="mb-0">Model: <b>Fat-Bob-9949 - M</b></p>
                              <p class="mb-0">Make: <b>2017</b></p> -->
                          </div>
                                              
                          <div class="col-md-6">
                            <ul class="detail_lists mt-4">
                              <h5 class="font-weight-bold">Shipping Details</h5>
                              <?php foreach ($shipping_address_array as $shipping_key) { ?>
                                <li><?php echo $shipping_key; ?></li>
                              <?php } ?>
                              <!-- <li>Customers Name : Alina Wilson</li>
                              <li>Email : demo@example.com </li>
                              <li>Contact No : 98360600851</li>
                              <li>Address : Viale Maraini 100</li> -->
                            </ul>
                          </div>
                          <div class="col-sm-6">
                            <ul class="detail_lists mt-4">
                              <h5 class="font-weight-bold">Billing Details</h5>
                              <?php foreach ($billing_address_array as $billing_key) { ?>
                              <li><?php echo $billing_key; ?></li>
                              <?php } ?>
                              <!-- <li>Payment Type : Card</li>
                              <li>Delivery Date : Jan 3, 2018</li>
                              <li>Amount : <b class="text-primary">$ 22</b></li> -->
                            </ul>
                          </div>
                      </div>    
                </div>
            </div>
            </div>
              <div class="right-side p-4">
                  <h2 class="mb-4">Order Details</h2>
                  <?php
                  	 $i = 1;
                     if(count($order_details) > 0){
                  ?>
                  <div class="ads-list-area">
                       <?php                      
                        foreach($order_details_data as $order_data){
                        	// $upload_data = $order_data->gear->upload;
                        	// $upload_array = explode(",", $upload_data);

                        	$quantity = $order_data->quantity;
                        	$price = $order_data->gear->price;

                        	$total_price = $quantity*$price;                  	                       
                       ?> 
                      <div class="row mb-4 pb-4">
                          
                          <div class="col-md-2">
                            <a href="<?php echo $this->request->webroot; ?>products/categorydetails/<?php echo $order_data->gear->id; ?>">
                            <img src="<?php echo $this->Url->build('/gear_img/'.$order_data->gear->upload); ?>" alt="" class="img-fluid"></a>
                          </div>
                          <!-- <div class="col-md-2">
                            <?php echo $user_details['order_status']; ?>
                          </div> -->
                          <div class="col-md-8 my-md-0 my-3">
                          	  <p class="mb-0">Order Date: <b><?php echo $user_details->order_date;?></b></p>

                          	  <p class="mb-0">Product Name: <b><?php echo $order_data->gear->product_name;?></b></p>
                              
                              <p class="mb-0">Payment Mode: <b><?php echo $user_details->payment_mode;?></b></p>
                              <p class="mb-0">Quantity: <b><?php echo $quantity;?></b></p>
                              <p class="mb-0">
                                Seller Info:
                                <?php echo $order_data->gear->user->first_name." ".$order_data->gear->user->last_name.",".$order_data->gear->user->phone; ?>
                              </p>
                          </div>
                          <div class="col-md-2">
                              <h5>Price : <b class="text-primary">$<?php echo $total_price;?></b></h5>                        
                               <!-- <a href="<?php echo $this->Url->build(["controller" => "Products","action" => "listorderdetails", $order_data->id]);?>" class="btn btn-sm btn-secondary">Details</a> -->
                               
                          </div>
                      </div>
                      <?php
                      		$i++;
                        }
                      ?>
                     <div class="paging">
                        <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-5">
                    <?php
                          echo $this->Paginator->prev('&laquo;', array('tag' => 'li', 'escape' => false), '<a href="#" class="page-link">&laquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
                          echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'page-item active', 'currentTag' => 'a'));
                          echo $this->Paginator->next('&raquo;', array('tag' => 'li', 'escape' => false), '<a href="#" class="page-link">&raquo;</a>', array('class' => 'prev disabled page-link', 'tag' => 'li', 'escape' => false));
                    ?>
                        </ul>
                        </nav>
                    
                </div>
                  </div>
                  <?php
                    }
                    else{
                      echo '<div style="text-align: center;"> Gears Not found. </div>';
                    }
                  ?>
              </div>
          </div>
      </div>
  </div>
</section>