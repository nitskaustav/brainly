
    <section class="py-5">
        <div class="container">
            <h2 class="heading text-center mb-5">Choose Your Bike Model</h2>
            <div class="row">
            	<?php foreach ($makes as $make_val) { ?>
            		
            	
                <div class="col-lg-3 col-md-4 col-sm-6 col-category">
                    <figure>
                        <!-- <i class="flaticon-man"></i> -->
                        <form name="frm_<?php echo $make_val->id; ?>" id="frm_<?php echo $make_val->id; ?>" method="POST" action="<?php echo $this->request->webroot; ?>products/result">
	                        <h5><?php echo $make_val->make_name; ?></h5>
	                        <p class="text-grey"></p>
	                        <input type="hidden" name="make_id" value="<?php echo $make_val->id; ?>">
	                        <a href="#" class="btn btn-primary" onclick="submitform('<?php echo $make_val->id; ?>');">View</a>
                    	</form>
                    </figure>
                </div>
                <?php } ?>
                
            </div>
        </div>
    </section>
    <script type="text/javascript">
    	function submitform(id){
    		var form_id = "frm_"+id;
    		$("#"+form_id+"").submit();
    	}
    </script>