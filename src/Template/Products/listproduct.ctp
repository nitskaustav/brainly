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
                  <h2 class="mb-4">Ads list</h2>
                  <?php
                     if(count($products) > 0){
                  ?>
                  <div class="ads-list-area">
                       <?php                      
                        foreach ($products as $product) { 
                        //pr($product);
                        $filename = WWW_ROOT.'product_img/'.$product->productsimages[0]->name;                       
                       ?> 
                      <div class="row mb-4 pb-4">
                          <div class="col-md-2">
                              <?php
                                if(file_exists($filename) && $product->productsimages[0]->name != ""){
                              ?>   
                              <img src="<?php echo $this->Url->build('/product_img/'.$product->productsimages[0]->name); ?>" alt="" class="img-fluid">
                            <?php
                                }
                                else{
                             ?>
                                <img src="<?php echo $this->Url->build('/product_img/no-image.png'); ?>" alt="" class="img-fluid">
                             <?php       
                                }
                            ?>
                          </div>
                          <div class="col-md-8 my-md-0 my-3">
                              <h5 class="mb-0"><?php echo $product->reg_number;?></h5>
                              <p class="mb-0">Model: <b> <?php echo ((isset($product->Bikemodels->model_name))? $product->Bikemodels->model_name : '');?></b></p>
                              <p class="mb-0">Make: <b><?php echo ((isset($product->Makes->make_name))? $product->Makes->make_name : '');?></b></p>
                          </div>
                          <div class="col-md-2">
                              <h5>Price : <b class="text-primary">$<?php echo $product->price;?></b></h5>                        
                               <a href="<?php echo $this->Url->build(["controller" => "Products","action" => "editproduct", $product->id]);?>" class="btn btn-sm btn-secondary">Edit</a>
                               
                                <a href="<?php echo $this->Url->build(["controller" => "Products","action" => "productdelete", $product->id]);?>" onclick="return confirm('Are you sure you want to delete?');" class="btn btn-sm btn-danger">Delete</a>
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
                      echo '<div style="text-align: center;"> Product Not found. </div>';
                    }
                  ?>
              </div>
          </div>
      </div>
  </div>
</section>