   <!--   gear  -->
    <section class="py-5">
        <div class="container">
            <h2 class="heading text-center mb-5">Choose Your Gear Category</h2>
            <div class="row">
                <?php foreach($categories as $cat_val) { ?>

                    <div class="col-lg-3 col-md-4 col-sm-6 col-category">

                        <figure>
                            <a href="<?php echo $this->request->webroot; ?>products/searchcategory/<?php echo $cat_val->id; ?>">
                            <div class="icon-img d-flex align-items-center justify-content-center" style="width: 70px;height: 70px;    border-radius: 100%;overflow: hidden;    background: #f56f30;margin: auto;">
                            <img src="<?php echo $this->request->webroot.'category_img/'.$cat_val->path; ?>" alt="">
                            </div>
                        </a>
                            <!-- <i class="flaticon-man"></i> -->
                            <h5><?php echo $cat_val->name ?></h5>
                            <p class="text-grey"></p>
                            <a href="<?php echo $this->request->webroot; ?>products/searchcategory/<?php echo $cat_val->id; ?>" class="btn btn-primary">View</a>
                        </figure>
                    </div>

                    <!-- <li class="text-center">
                        <a href="<?php echo $this->request->webroot; ?>products/searchcategory/<?php echo $cat_val->id; ?>"><div class="icon-img d-flex align-items-center justify-content-center">
                            <img src="<?php echo $this->request->webroot.'category_img/'.$cat_val->path; ?>" alt="">
                        </div></a>
                        <p><?php echo $cat_val->name ?></p>
                    </li> -->
                <?php } ?>
                <!-- <div class="col-lg-3 col-md-4 col-sm-6 col-category">
                    <figure>
                        <i class="flaticon-man"></i>
                        <h5>Clothing</h5>
                        <p class="text-grey">Lorem Ipsum is simply dummy text of the printing</p>
                        <a href="#" class="btn btn-primary">View</a>
                    </figure>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-category">
                    <figure>
                        <i class="flaticon-helmet"></i>
                        <h5>Helmet</h5>
                        <p class="text-grey">Lorem Ipsum is simply dummy text of the printing</p>
                        <a href="#" class="btn btn-primary">View</a>
                    </figure>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-category">
                    <figure>
                        <i class="flaticon-transport"></i>
                        <h5>Oil & Lubricants</h5>
                        <p class="text-grey">Lorem Ipsum is simply dummy text of the printing</p>
                        <a href="#" class="btn btn-primary">View</a>
                    </figure>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-category">
                    <figure>
                        <i class="flaticon-travel"></i>
                        <h5>Luggage</h5>
                        <p class="text-grey">Lorem Ipsum is simply dummy text of the printing</p>
                        <a href="#" class="btn btn-primary">View</a>
                    </figure>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-category">
                    <figure>
                        <i class="flaticon-gear"></i>
                        <h5>maintanance</h5>
                        <p class="text-grey">Lorem Ipsum is simply dummy text of the printing</p>
                        <a href="#" class="btn btn-primary">View</a>
                    </figure>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-category">
                    <figure>
                        <i class="flaticon-light-bulb"></i>
                        <h5>Electronics</h5>
                        <p class="text-grey">Lorem Ipsum is simply dummy text of the printing</p>
                        <a href="#" class="btn btn-primary">View</a>
                    </figure>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-category">
                    <figure>
                        <i class="flaticon-tyre"></i>
                        <h5>Tyres</h5>
                        <p class="text-grey">Lorem Ipsum is simply dummy text of the printing</p>
                        <a href="#" class="btn btn-primary">View</a>
                    </figure>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-category">
                    <figure>
                        <i class="flaticon-pilot-sunglasses"></i>
                        <h5>Accessories</h5>
                        <p class="text-grey">Lorem Ipsum is simply dummy text of the printing</p>
                        <a href="#" class="btn btn-primary">View</a>
                    </figure>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-category">
                    <figure>
                        <i class="flaticon-unlocked"></i>
                        <h5>Security</h5>
                        <p class="text-grey">Lorem Ipsum is simply dummy text of the printing</p>
                        <a href="#" class="btn btn-primary">View</a>
                    </figure>
                </div> -->
            </div>
        </div>
    </section>
    