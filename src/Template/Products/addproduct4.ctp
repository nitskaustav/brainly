<section class="inner-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center inner-heading">
                    <h2>Sell Bike</h2>
                    <h5>Sell your bike 5 easy steps</h5>
                </div>
                <div class="col-lg-12">
                    <ul class="list-unstyled top-pagition text-center mt-3">
                        <li class="active">
                            <a>
                                <span class="d-flex align-items-center justify-content-center"><i class="ion-checkmark-round"></i></span>
                                <p>Step 1</p>
                            </a>
                        </li>
                        <li class="active">
                            <a>
                                <span class="d-flex align-items-center justify-content-center"><i class="ion-checkmark-round"></i></span>
                                <p>Step 2</p>
                            </a>
                        </li>
                        <li class="active">
                            <a>
                                <span class="d-flex align-items-center justify-content-center"><i class="ion-checkmark-round"></i></span>
                                <p>Step 3</p>
                            </a>
                        </li>
                        <li  class="active">
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
                    <form method="post" action="<?php echo $this->Url->build(["controller" => "Products","action" => "addproduct4", $product->id]);?>" enctype='multipart/form-data' class="form-area text-center" onsubmit="return validate();">
                    <div class="photo-upload-area form-area ">
                        <h4>It’s <span class="text-primary font-weight-bold">FREE</span> to list on biketory for a limited time</h4>
                        <div class="step-4-area">
                        <div class="text-center step-4-box">
                            <img src="<?php echo $this->Url->build('/img/euro.png'); ?>" alt="">
                            <h4 class="text-danger font-weight-bold">FREE</h4>
                            <p>Weeks on the website: 4</p>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Postalcode" name="postal_code" id="postal_code" value="<?php echo $product->postal_code;?>">
                        </div>
                            <div class="form-group check-box-area text-left">
                            <div class="checkboxes">
                                <input id="c" type="checkbox">
                                <label class="green-background" for="c"></label>
                            </div>
                            <p>Save my address for future adverts. Your postcode WILL NOT be shared

</p>
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <button type="submit" name="back" value="back" class="btn btn-secondary btn-lg m-3">Back</button>
                            <button type="submit" name="finish" value="finish" class="btn btn-primary btn-lg m-3">Finish</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        function validate(){
            if($("#postal_code").val().search(/\S/) == -1){
                alert("Please provide valid postal code");return false;
            }

            var postal_code = $("#postal_code").val();
            if(isNaN(postal_code)){
                alert("Postal code should be numeric"); return false;
            }
            if(postal_code < 0){
                alert("Postal code should be non negative"); return false;
            }
        }
    </script>