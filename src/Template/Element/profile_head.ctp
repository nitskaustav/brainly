<?php if ($user_details['utype'] == 1) { ?>
    <section class="edit-profilesection">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="edit-profil-img">
                        <?php if ($user_details->pimg != '') { ?>
                            <img src="<?php echo $this->Url->build('/user_img/' . $user->pimg); ?>" alt="" class="img-responsive center-block img-thumbnail">
                        <?php } else { ?>
                            <img src="<?php echo $this->Url->build('/user_img/default.png'); ?>" alt="" class="img-responsive center-block img-thumbnail">
                        <?php } ?>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="edit-profil-txtdiv">
                        <h3 class="h4"><?php echo $user_details->full_name; ?> </h3>	
                        <h4 class="h6">
                            <i class="fa fa-map-marker"></i>
                            <?php echo $user_details->address; ?> <br>

                            <i class="fa fa-phone"></i>	
                            <a href="tel:123456789"><?php echo $user_details->phone; ?></a> <br>

                            <i class="fa fa-envelope"></i>	
                            <a href="mailto:info@support.com"><?php echo $user_details->email; ?></a>	 <br>

                            <!--						Rating: 
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>	
                                                                            <i class="fa fa-star-half-empty"></i>
                                                                            <i class="fa fa-star-o"></i>-->
                        </h4>

                        <!--					<a href="#" class="add">Add Review</a>
                                                                <a href="#" class="add">Add Place</a>-->
                    </div>	
                </div>
            </div>	
        </div>
    </section>
<?php }else{ ?>



<section class="edit-profilesection">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="edit-profil-img">
                        <?php if ($user_details->pimg != '') { ?>
                            <img src="<?php echo $this->Url->build('/user_img/' . $user->pimg); ?>" alt="" class="img-responsive center-block img-thumbnail">
                        <?php } else { ?>
                            <img src="<?php echo $this->Url->build('/user_img/default.png'); ?>" alt="" class="img-responsive center-block img-thumbnail">
                        <?php } ?>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="edit-profil-txtdiv">
                        <h3 class="h4"><?php echo $user_details->full_name; ?> </h3>	
                        <h4 class="h6">
                            <i class="fa fa-map-marker"></i>
                            <?php echo $user_details->address; ?> <br>

                            <i class="fa fa-phone"></i>	
                            <a href="tel:123456789"><?php echo $user_details->phone; ?></a> <br>

                            <i class="fa fa-envelope"></i>	
                            <a href="mailto:info@support.com"><?php echo $user_details->email; ?></a>	 <br>

                            <span class="stars"><?php $avgrating=(($provider_avg_review[0]['ap']+$provider_avg_review[0]['af']+$provider_avg_review[0]['ac']+$provider_avg_review[0]['ase']+$provider_avg_review[0]['aa']+$provider_avg_review[0]['afd'])/6);if($avgrating!=''){echo $avgrating;}else{ echo 0;}?></span>
                        </h4>

                        <!--					<a href="#" class="add">Add Review</a>
                                                                <a href="#" class="add">Add Place</a>-->
                    </div>	
                </div>
            </div>	
        </div>
    </section>







<?php } ?>
<style>
   .form-horizontal .control-label {
	text-align: left;
    }
    
    
    span.stars, span.stars span {
    display: block;
    background: url(../../jimja/image/stars.png) 0 -16px repeat-x;
    width: 80px;
    height: 16px;
}

span.stars span {
    background-position: 0 0;
}
    
    
</style>
<script>
$.fn.stars = function() {
    return $(this).each(function() {
        // Get the value
        var val = parseFloat($(this).html());
        // Make sure that the value is in 0 - 5 range, multiply to get width
        var size = Math.max(0, (Math.min(5, val))) * 16;
        // Create stars holder
        var $span = $('<span />').width(size);
        // Replace the numerical value with stars
        $(this).html($span);
    });
}
$(function() {
    $('span.stars').stars();
});

</script>