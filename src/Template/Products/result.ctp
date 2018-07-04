<?php
// echo "<pre>";
// print_r($post_data);die;
?>
<section class="inner-banner py-4">
    <div class="container">
        <div class="inner-banner-area">
            <img src="<?php echo $this->Url->build('/img/inner-banner.jpg'); ?>" alt="" class="img-fluid">
            <a class="close-btn"><i class="ion-close"></i></a>
        </div>
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
               <?php echo $this->element('filter');?>               
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
                    <?php
                        foreach ($products as $product) { 
                        //pr($product); 
                        $filename = WWW_ROOT.'product_img/'.$product->productsimages[0]->name;                         
                    ?>
                    <div class="col-lg-4 col-item">
                        <figure>
                            <a href="<?php echo $this->Url->build(["controller" => "Products","action" => "details", $product->id]);?>">
                            <?php
                                if(file_exists($filename) && $product->productsimages[0]->name != ""){
                            ?>
                            <div class="item-img" style="background:url(<?php echo $this->Url->build('/product_img/'.$product->productsimages[0]->name); ?>)"> 
                            </div>
                            <?php
                                }
                                else{
                             ?>
                             <div class="item-img" style="background:url(<?php echo $this->Url->build('/product_img/no-image.png'); ?>)"> 
                            </div>
                             <?php       
                                }
                            ?>
                            </a>
                            <figcaption>
                                <div class="top-part p-3">
                                    <h5 class="font-weight-bold"><?php echo $product->reg_number;?></h5>
                                     <h5 class="text-primary font-weight-bold mb-0">$<?php echo number_format($product->price,2);?></h5>
                                </div>
                                <div class="bottom-part p-3">
                                    <p class="mb-0">Model: <b><?php echo $product->Bikemodels->model_name;?></b></p>
                                    <p class="mb-0">Make: <b><?php echo $product->Makes->make_name;?></b></p>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                    <?php
                        }
                    ?>                  
                    
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
        //var form = document.getElementById("filter_form");
        //alert(form);
        //form.submit();
        //document.filter_form.submit();
        //$( "#filter_form" ).submit();
        $( "#filter_button" ).trigger( "click" );
    }
</script>