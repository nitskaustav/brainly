<section class="inner-page">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="photo-upload-area thankyou-page text-center">
                <h1><i class="ion-checkmark-circled"></i></h1>
                <h2>Thank You!</h2>
                <h4>Your ad will be approved shortly.</h4>
                <div class="text-center mt-5">
                    <a href="<?php echo $this->Url->build(["controller" => "Users","action" => "index"]);?>" class="btn btn-secondary btn-lg m-3">Main Page</a>
                    <a href="<?php echo $this->Url->build(["controller" => "Users","action" => "sellerdashboard"]);?>" class="btn btn-primary btn-lg m-3">List Another</a>
                </div>
            </div>
        </div>
    </div>
</div>
</section>