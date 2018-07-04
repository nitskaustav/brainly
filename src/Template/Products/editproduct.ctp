<section class="inner-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center inner-heading">
                    <h2>Sell Bike</h2>
                    <h5>Sell your bike 5 easy steps</h5>
                </div>
                <div class="col-lg-12">
                    <ul class="list-unstyled top-pagition text-center mt-3">
                        <li  class="active">
                            <a>
                                <span class="d-flex align-items-center justify-content-center">1</span>
                                <p>Step 1</p>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="d-flex align-items-center justify-content-center">2</span>
                                <p>Step 2</p>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="d-flex align-items-center justify-content-center">3</span>
                                <p>Step 3</p>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="d-flex align-items-center justify-content-center">4</span>
                                <p>Step 4</p>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="d-flex align-items-center justify-content-center">5</span>
                                <p>Step 5</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-5">
                    <div class="bike-icon d-flex align-items-center justify-content-center">
                        <img src="<?php echo $this->Url->build('/img/bike-icon.png'); ?>" alt="">
                    </div>
                    <form method="post" action="<?php echo $this->Url->build(["controller" => "Products","action" => "editproduct", $product->id]);?>" enctype='multipart/form-data' class="form-area text-center" id="frmProduct">
                        <div class="form-group">
                            <input type="text" placeholder="Enter reg number" class="form-control" name="reg_number" id="reg_number" value="<?php echo $product->reg_number;?>">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Enter mileage" class="form-control" name="mileage" id="mileage" value="<?php echo $product->mileage;?>">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg">Start</button>
                        </div>
                        <h4>OR</h4>
                        <p class="mt-3"><a href="#" class="text-primary">Click here</a> to enter details manually</p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
    $(function(){
        $( "#frmProduct" ).validate({
        rules: {
          'reg_number': "required",
          'mileage': "required"
        },
        messages: {
          'reg_number': "Please enter reg number.",
          'mileage': "Please enter mileage."
        },


      });
    })
    /**/
</script>