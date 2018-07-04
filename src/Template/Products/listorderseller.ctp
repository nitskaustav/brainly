<?php
// echo "<pre>";
// print_r($seller_order);die;
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
                  <h2 class="mb-4">Order list</h2>
                  <?php
                  	 $i = 1;
                     if(count($seller_order) > 0){
                  ?>
                  <div class="ads-list-area">
                       <?php                      
                        foreach ($seller_order as $seller_order_data) { 
                        //pr($product);                           
                       ?> 
                      <div class="row mb-4 pb-4">
                          
                          <!-- <div class="col-md-2">
                            <?php echo $order_data->order_date; ?>
                          </div> -->
                          <div class="col-md-2">
                            <?php echo $i; ?>
                          </div>
                          
                          <div class="col-md-8 my-md-0 my-3">
                          	  <p class="mb-0">Order Date: <b><?php echo $seller_order_data->order->order_date;?></b></p>

                              <p  class="mb-0">Order Status:<b><?php echo $seller_order_data->order->order_status; ?></b>
                                
                              </p>
                                                     
                              <p class="mb-0">Payment Mode: <b><?php echo $seller_order_data->order->payment_mode;?></b></p>

                              
                          </div>
                          <div class="col-md-2">
                              <h5>Price : <b class="text-primary">$<?php echo $seller_order_data->order->total_price;?></b></h5>                        
                               <a href="<?php echo $this->Url->build(["controller" => "Products","action" => "listsellerorderdetails", $seller_order_data->order->id]);?>" class="btn btn-primary btn-block">Details</a>
                               
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