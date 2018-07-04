    <!--   inner  banner   -->
    
    <section class="inner-banner py-4">
        <div class="container">
            <!-- <div class="inner-banner-area">
                <img src="img/inner-banner.jpg" alt="" class="img-fluid">
                <a class="close-btn"><i class="ion-close"></i></a>
            </div> -->
        </div>
    </section>
    
    <!--   search   result   -->

    <section class="pb-5">
        <div class="container">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Library</li>
              </ol>
            </nav>
            <div class="row">
                <div class="col-lg-3">
                    <?php echo $this->element('filtergear');?>
                </div>
                <div class="col-lg-9">
                    <div class="row border border-top-0 border-right-0 border-left-0 pb-3 align-items-center">
                        <div class="col-lg-8 col-sm-6">
                            <p class="text-grey text-uppercase mb-lg-0">Showing 1 of 234</p>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="d-flex align-items-center sort-by">
                                <span class="mr-3 text-uppercase font-weight-bold">Sort by</span>
                                <select class="form-control" name="sortby" id="sortby" onchange="submit_form_data(this.value);">
                                <?php
                                    if($post_data['sortbyval'] == 'h'){
                                        $hselected = ' selected';
                                        $lselected = '';
                                    }elseif($post_data['sortbyval'] == 'l'){
                                        $lselected = ' selected';
                                        $hselected = '';
                                    }
                                ?>
                                <option value="">Select</option>
                                <option value="h" <?php echo $hselected; ?>>Price (High to low)</option>
                                <option value="l" <?php echo $lselected; ?>>Price (Low to high)</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <?php foreach($gears as $gear_val) { 
                                // $upload = $gear_val->upload;
                                // $upload_array = explode(",", $upload);
                              $filename = WWW_ROOT.'gear_img/'.$gear_val->upload;

                              if(!file_exists($filename) || $gear_val->upload == ''){
                                 $gear_val->upload = 'no-image.png';
                              }

                                $product_image_path = $this->request->webroot . 'gear_img/' . $gear_val->upload;

                      ?>
                          <div class="col-lg-4 col-item">
                            <figure>
                              <a href="<?php echo $this->request->webroot; ?>products/categorydetails/<?php echo $gear_val->id; ?>">
                                <div class="item-img" style="background:url(<?php echo $product_image_path; ?>)"> 
                                </div>
                              </a>
                                <figcaption>
                                    <div class="top-part p-3">
                                        <h5 class="font-weight-bold"><?php echo $gear_val->product_name; ?></h5>
                                         <h5 class="text-primary font-weight-bold mb-0">$<?php echo $gear_val->price; ?>.00</h5>
                                    </div>
                                    <div class="bottom-part p-3">
                                        <p class="mb-0">Category: <b><?php echo $gear_val->category->name; ?></b></p>
                                        <p class="mb-0">Brand: <b><?php echo $gear_val->brand->brand_name; ?></b></p>
                                        <p>
                                          <?php
                                            $details = $this->Url->build(["controller" => "Products","action" => "categorydetails", $gear_val->id]);
                                          ?>
                                          <a href="<?php echo $details; ?>" class="btn btn-sm btn-secondary">Details</a></p>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                      <?php } ?>
                        <!-- 
                        <div class="col-lg-4 col-item">
                            <figure>
                                <div class="item-img" style="background:url(./img/pic/1.jpg)"> 
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
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
    function submit_form_data(sortbyval){
        if($("#sortby").val().search(/\S/) == -1)
            return false;
        var sortbyval = $("#sortby").val();
        $("#sortbyval").val(sortbyval);
        $( "#filter_button" ).trigger( "click" );
    }
</script>