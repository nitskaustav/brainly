<section class="user-dashboard">
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
        <div class="col-lg-9 col-md-8">
          <div class="edit-pro p-3 p-lg-4">
            <h5 class="common-title mb-3 pb-2"> Messages</h5>
           
              <ul class="list-unstyled list-messages">
              		<?php
              		foreach ($messages as $message) {               			          			
              		?>	
					  <li class="media">
					    <a href="javascript: select_friend_foot(<?php echo $message['id'];?>)"><div class="user userCurrent click_msg" data-id=<?php echo $message['id'];?>><img class="mr-3 rounded-circle" src="<?php echo $this->request->webroot;?>user_img/<?php echo (($message['pimg'] != "")? 'thumb_'.$message['pimg'] : 'default.png'); ?>" alt="Generic placeholder image"></div></a>
					    <div class="media-body">
					    <!-- <div class="relative"><?php echo $message['full_name'];?><span class="cmcount"><b><?php echo $message['read_count'];?></b></span></div> -->
					     
                                              <h5 class="mt-0 mb-1 relative"><?php if($message['business_name']==""){ echo $message['full_name'];}else{echo $message['business_name'];}?>
	 <?php if($message['read_count'] > 0) {?>
					      <span class="cmcount" id="mg_<?php echo $message['id'];?>" style="color: white;"><b><?php echo $message['read_count'];?></b></span>
<?php } ?>
					      </h5>
					      <span><?php echo $message['date_time'];?></span>
					      <p><?php echo $message['message'];?></p>
					      
					    </div>
					    <div class="media-right">					    	
					    	<a href="javascript: select_friend_foot(<?php echo $message['id'];?>)"  style="display: inline-block" 
					    		class="btn btn-primary text-center"> 
					    		<div class="user userCurrent click_msg text-center" data-id=<?php echo $message['id'];?> style="color: #fff; "> 
					    		<i class="icon ion-chatboxes text-white"></i>
	                        	</div>
	                    	</a>
					    </div>
					  </li>
					  <?php
						}
					  ?>
					  
					</ul>

          </div>
        </div>
        
      </div>
    </div>
  </section>

  <script type="text/javascript">
$(document).ready(function() {

   

   $(document).on("click",".click_msg",function() {
        var msg_id = $(this).data('id');
        //alert(msg_id);
        $('#mg_'+msg_id).hide();
    });
});
</script>
