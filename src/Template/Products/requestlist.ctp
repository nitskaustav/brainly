<?php 
// echo "<pre>";
// print_r($user);
// print_r($gears);die;
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
                  <h2 class="mb-4">Request list</h2>
                  <?php
                     if(count($requestlist) > 0){
                  ?>
                  <div class="ads-list-area">
                       <?php                      
                        foreach ($requestlist as $request) { 
                          
                          //echo $image_path = $this->request->webroot;die;                           
                       ?> 
                      <div class="row mb-4 pb-4">
                          
                          <div class="col-md-2">
                            <!-- <img src="<?php echo $this->Url->build('/product_img/'.$upload_array[0]); ?>" alt="" class="img-fluid"> -->
                          </div>
                          <div class="col-md-8 my-md-0 my-3">
                              <p class="mb-0">Name:<b><?php echo $request->name;?></b></p>
                          </div>
                          <div>
                              <p class="mb-0">Email: <b><?php echo $request->email;?></b></p>
                          </div>
                          <div>
                              <p class="mb-0">Phone: <b><?php echo $request->phone;?></b></p>
                          </div>
                          <div>
                              <p class="mb-0">Message: <b><?php echo $request->message;?></b></p>
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