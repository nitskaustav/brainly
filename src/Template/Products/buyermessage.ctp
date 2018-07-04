<?php 
// echo "<pre>";
// print_r($requestlist);die;


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
                  <h2 class="mb-4">Messages</h2>
                  <?php
                     if(count($requestlist) > 0){
                  ?>
                  <div class="ads-list-area">
                      <!-- <div class="row mb-4 pb-4">
                          
                          <div class="col-md-8 my-md-0 my-3">
                              <p class="mb-0"><b>Seller</b></p>
                          </div>
                          <div>
                              <p class="mb-0"><b>Bike Reg No.</b></p>
                          </div>
                          <div>
                              <p class="mb-0"><b>Message</b></p>
                          </div>
                      </div> -->
                       <?php                      
                        foreach ($requestlist as $request) { 
                          
                          //echo $image_path = $this->request->webroot;die;
                                              
                          $full_name = $request->user->business_name;
                          
                       ?> 
                      <div class="row mb-4 pb-4">
                          
                          <div class="col-md-8 my-md-0 my-3">
                              <p class="mb-0"><b>Seller: </b><?php echo $full_name;?></p>
                          </div>
                          <div class="col-md-8 my-md-0 my-3">
                              <p class="mb-0"><b>Bike Reg No: </b><a href="<?php echo $this->Url->build(["controller" => "Products","action" => "details", $request->product->id]);?>" style="text-decoration: none;"><?php echo $request->product->reg_number;?></a></p>
                          </div>
                          <div class="col-md-8 my-md-0 my-3">
                              <p class="mb-0"><b>Message: </b><?php echo $request->message;?></p>
                          </div>
                      </div>
                      <?php
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
                      echo '<div style="text-align: center;"> Requests Not found. </div>';
                    }
                  ?>
              </div>
          </div>
      </div>
  </div>
</section>