<h2 class="about">Delivery Information</h2>
<div class="dispatch-other-text">
    <?php echo trim(nl2br($mData['content'])); ?>
</div>
<div class="bordered-block">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="block-left">
                <div class="delivery-truck"><!--<img src="<?php echo $this->Url->build('/', true);?>images/delivery-truck.png" >--></div>
                <div class="delivery-para">
                    <h2>Track my delivery</h2>
                    <p>Enter Royal Mail parcel tracking number:</p>
                </div>

                <div class="row">
                    <div class="col-md-9 col-sm-9">
                        <input type="text" class="text-field">
                    </div>
                    <div class="col-md-3 col-sm-3 no-left-padding">
                        <button type="button" class="btn btn-success button-part">Track<i class="fa fa-truck"></i></button>
                    </div>
                </div>
                <p>Information is provided when a <a href="javascript:void(0)">delivery has been attempted</a> (deliveries are not tracked during transit). Express international orders: Please track your delivery at <a href="javascript:void(0)">DHL Express</a>.</p>
            </div>
        </div>
    </div>
</div>
<div class="cms-bottom-pic">
    <img src="<?php echo $this->Url->build('/', true);?>images/img-services.jpg" alt="Trusted Shops logo" width="89">
    </div>