<?php
	$userid = $this->request->session()->read('Auth.User.id');
	$admin_checkid = $this->request->session()->read('Auth.User.is_admin');
	$base_url= "http://111.93.169.90/team6/brainly/";

	echo $this->element('head');
	echo $this->element('header');
?> 
<script>
   <?php if($userid){?>
   setInterval(function(){ 
      //alert('ok');
      latest_message_count(); 
      latest_request_count();
      latest_request_user_count();
      latest_booking_user_count();
   
   }, 1000);
   <?php } ?>
</script>
	<section>
		<div>
			<?php echo $this->Flash->render() ?>
			<?php echo $this->Flash->render('success') ?>
			<?php echo $this->Flash->render('error') ?>
		</div>
	</section>

	<div class="msg_box" style="right:290px;display:none;">
   <div class="msg_head text-white">
      <span id="chat_name"></span>
      <div class="close">x</div>
   </div>
   <div class="msg_wrap">
      <div class="msg_body p-0">
         <!-- <div class="msg_a w-100 float-left mb-2 mr-0">
            <div class="msg-img-box rounded-circle d-inline-block mr-1">
            	<img class="rounded-circle img-fluid" src="/team6/5star/user_img/thumb_1523631727.png" alt="">					
            </div>
            <div class="msg-txt-box d-inline-block p-relative">
            	<p class="mb-0 font-12 text-dark">This is from B, and its amazingly kool nah... i know it even i liked it :)</p>
            </div>
            <div class="msg-datetim-box float-right w-25 text-right">
            	<span class="text-muted font-12">14-04-2018</span>
            	<time class="text-muted font-12">08:15 am</time>
            </div>
            </div>
            
            <div class="msg_b w-100 float-left mb-2 mr-0">
            <div class="msg-datetim-box float-left w-25 text-left">
            	<span class="text-muted font-12">14-04-2018</span>
            	<time class="text-muted font-12">08:15 am</time>
            </div>	
            <div class="msg-txt-box d-inline-block p-relative mr-2">
            	<p class="mb-0 font-12 text-dark">This is from B, and its amazingly kool nah... i know it even i liked it :)</p>
            </div>
            <div class="msg-img-box rounded-circle d-inline-block mr-1">
            	<img class="rounded-circle img-fluid" src="/team6/5star/user_img/thumb_529cbc47f1eedfd0d901d41021ab564f.png" alt="">					
            </div>
            </div> -->
         <div class="msg_push"></div>
      </div>
      <img id="image_loader" src="<?php echo $this->request->webroot  ?>images/loader.gif" style="height: 100px">
      <!-- <form id="cht_frm"> -->
      <input type="hidden" name="last_message_id_foter" id="last_message_id_foot" value="">
      <input type="hidden" name="friend_id"  id="friend_id" />
      <div class="msg_footer">
         <textarea class="msg_input" name="message" rows="1"></textarea>
         <!-- <div id="cls"><img src="<?php echo $this->request->webroot ?>images/attach.png" class="img-fluid"></div> -->
         <!-- <div id="cls">
           <i class="icon ion-ios-camera text-dark cursor font-20"></i>
         </div> -->
         <!-- <input type='file' id="img_file" name="cht_img" onchange="readURL(this);" style="display:none;"/> -->
         <!-- <img id="blah" src="#" alt="your image" /> -->
         <button onclick="send()"><i class="icon ion-android-send"></i></button>
      </div>
      <!-- </form> -->
   </div>
</div>
<?php if($userid){ ?>
<div class="chat_box" style="display: none;">
   <div class="chat_head up_chk" data-id="1">
      <div class="col-md-10 col-sm-5">Chat Box</div>
      <div align="right" id="chat_icon_up"><i class="" aria-hidden="true"></i></div>
   </div>
   <div class="chat_head up_chk1" data-id="1" style="display:none;">
      <div class="col-md-10 col-sm-5">Chat Box</div>
      <div align="right" id="chat_icon_down" ><i class="" aria-hidden="true"></i></div>
   </div>
   <div class="chat_body">
      <?php foreach($login_friends as $logf){
         ?>
      <a href="javascript: select_friend_foot(<?php echo $logf['id'];?>)">
         <div class="user" data-id=<?php echo $logf['id'];?>> <?php if($logf['is_active']==1){?> <span class="on_line on_<?php echo $logf['id'];?>" ><i class="fa fa-circle" aria-hidden="true"></i></span><?php }else{ ?><span class="off_line off_<?php echo $logf['id'];?>"><i class="fa fa-circle" aria-hidden="true"></i></span><?php } ?><label style="margin-left: 17px;"><?php if($logf['business_name']==""){echo $logf['full_name'];}else{echo $logf['business_name'];}?></label></div>
      </a>
      <?php } ?>
   </div>
</div>
<?php } ?> 

	<?php echo $this->fetch('content');?>
  <?php echo $this->element('footer');?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<?php echo $this->Html->script('ie10-viewport-bug-workaround.js') ?>
<?php echo $this->Html->script('jquery.bxslider.js') ?>
<?php echo $this->Html->script('gallery.js') ?>
<?php echo $this->Html->script('ajaxupload.3.5.js') ?>
<script>
   base_url = '<?php echo $this->request->webroot;?>';       
   
   $(document).ready(function(){
   setTimeout(function() {
        $('.message').fadeOut('slow');
        $('.success').fadeOut('slow');
     }, 3000);
   
   $('.bxslider').bxSlider({
   mode: 'horizontal',
   controls: false
   });
   });
    
    
    
    $('.cbox').click(function(){
   $('.chat_box').slideToggle('slow');
     $('.cbox').hide();
   $('.cbox').show();
   
   });
</script>
<!--chat-->
<script>
   $(document).ready(function(){
   <?php if($this->Session->read('Auth.User.id')){?>
   
   $('.close').click(function(){
   	$('.msg_box').hide();
   });
   
   $('.user').click(function(){
   
   	$('.msg_wrap').show();
   	$('.msg_box').show();
   });
          
   <?php } ?>
   $('.msg_input').keypress(
      function(e){
          if (e.keyCode == 13) {
              e.preventDefault();
              var message_text = $(this).val();
   		var friend_id = $('#friend_id').val();
   		$(this).val('');
   		if(message_text!='')
   		{
   		$.ajax({
   				type: 'POST',
   				//url: '<?php //echo Router::url(array('controller' => 'messages', 'action' =>'insert_message_footer'), true); ?>',
                      url : '<?php echo $this->request->webroot;?>users/insertmessagefooter',
   				data: {friend_id:friend_id, message_text:message_text},
   				cache: false,
   				dataType: 'HTML',
   				success: function (data){
   					var data_arr = data.split("||");
   					$('#last_message_id_foot').val(data_arr[0]);
   					/*$('.msg_body').append(data_arr[1]);	*/
   					$('<div class="msg_a">'+data_arr[1]+'</div>').insertBefore('.msg_push');
   					$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
   				}
   			});
   		/*$('<div class="msg_a">'+message_text+'</div>').insertBefore('.msg_push');*/
   		}
   
          }
      });
   
        
          
          setInterval(function(){ latest_message_footer(); }, 10000);
   });
   
   
   function send(){
      
      var message_text = $('.msg_input').val();
   		var friend_id = $('#friend_id').val();
   		//alert(message_text+friend_id); return false;
   		$(this).val('');
   		if(message_text!='')
   		{
   		$.ajax({
   				type: 'POST',
   				//url: '<?php //echo Router::url(array('controller' => 'messages', 'action' =>'insert_message_footer'), true); ?>',
                      url : '<?php echo $this->request->webroot;?>users/insertmessagefooter',
                      headers: {'charset': 'utf-8'},
   				data: {friend_id:friend_id, message_text:message_text},
   				cache: false,
   				dataType: 'HTML',
   				success: function (data){
            //alert(data);return false;
   					var data_arr = data.split("||");
   					$('#last_message_id_foot').val(data_arr[0]);
   					/*$('.msg_body').append(data_arr[1]);	*/
   					$('<div class="msg_a">'+data_arr[1]+'</div>').insertBefore('.msg_push');
   					$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
                                                  $('.msg_input').val(""); 
   				}
                                         
   			});
   		/*$('<div class="msg_a">'+message_text+'</div>').insertBefore('.msg_push');*/
   		}
   
   }
   
   
   
   
   
   
   function select_friend_foot(friend_id){
          
      // alert(friend_id);
      // return false;
   		$('#friend_id').val(friend_id);
   		
   		$.ajax({
   				type: 'POST',
   				//url: '<?php //echo Router::url(array('controller' => 'messages', 'action' =>'footer_user_message'), true); ?>',
          url : '<?php echo $this->request->webroot;?>users/footerusermessage',
   				data: {friend_id:friend_id},
   				cache: false,
   				dataType: 'HTML',
   				success: function (data){
            //alert(data); return false;
   					var data_arr = data.split("||");
   					$('#last_message_id_foot').val(data_arr[0]);
   					$('#chat_name').html(data_arr[1]);
   					$('.msg_body').html(data_arr[2]);
   					$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
            $('.msg_input').focus();
   				}
   			});
   	}
                  
                  
function latest_message_count(){

  $.ajax({
    type: 'POST',
    url : '<?php echo $this->request->webroot;?>users/latestMessagefootercount',
    //data: {last_message_id:last_message_id},
    cache: false,
    //dataType: 'HTML',
    success: function (data){
    //alert(data);
    //var data_arr = data.split("||");
      if(data != ""){
        //$('#last_message_id_foot').val(data_arr[0]);
        $('.mcount').html(data);
      }
    }
  });
              
}
                  
   function latest_request_count(){
                  
                  //var last_message_id = $('#last_message_id_foot').val();
   	//alert(last_message_id);
   	//var friend_id = $('#friend_id').val();
   	//alert (friend_id);
   	$.ajax({
   			type: 'POST',
   			//url: '<?php //echo Router::url(array('controller' => 'messages', 'action' =>'latestMessage_footer_count'), true); ?>',
                                  
                                  url : '<?php echo $this->request->webroot;?>services/latestrequestfootercount',
   			//data: {last_message_id:last_message_id},
   			cache: false,
                                  //dataType: 'HTML',
   			success: function (data){
                                      //alert(data);
   				//var data_arr = data.split("||");
   				if(data != ""){
   					//$('#last_message_id_foot').val(data_arr[0]);
   					$('.rcount').html(data);
   					//alert($('.rcount').html(data));
   					
   				
   				}
   			}
   		});
                  
                  
                      }
   
   
   
   
   
   
   function latest_request_user_count(){
                  
                 
   	$.ajax({
   		type: 'POST',
                url : '<?php echo $this->request->webroot; ?>services/latestrequestfooterusercount',
                cache: false,
                                  
                success: function (data){
                                  
   				if(data != ""){
   					
   					$('.rucount').html(data);
   					
   					
   				
   				}
   			}
   		});
                  
                  
                      }
   
   
   function latest_booking_user_count(){
                  
                 
    $.ajax({
      type: 'POST',
                url : '<?php echo $this->request->webroot; ?>services/latestbookingfooterusercount',
                cache: false,
                                  
                success: function (data){
                                  
          if(data != ""){
            
            $('.bcount').html(data);
            
            
          
          }
        }
      });
                  
                  
                      }
   
   
   
   
   
   
   
   
   function latest_message_footer(){
   	var last_message_id = $('#last_message_id_foot').val();
   	//alert(last_message_id);
   	var friend_id = $('#friend_id').val();
   	//alert (friend_id);
   	$.ajax({
   			type: 'POST',
   			//url: '<?php //echo Router::url(array('controller' => 'messages', 'action' =>'latestMessage_footer'), true); ?>',
                  url : '<?php echo $this->request->webroot;?>users/latestMessagefooter',
   			data: {last_message_id:last_message_id, friend_id:friend_id},
   			cache: false,
   			dataType: 'HTML',
   			success: function (data){
   				var data_arr = data.split("||");
   				if(data_arr[1] != ""){
   					$('#last_message_id_foot').val(data_arr[0]);
   					$('.msg_body').append(data_arr[1]);
   					//$('<div class="msg_a">'+data_arr[1]+'</div>').insertBefore('.msg_push');
   					$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
   				}
   			}
   		});
   }
</script>
<script type="text/javascript">
   $('document').ready(function(){
   	$('#blah').hide();
   	$('#image_loader').hide();
   	$('#cls').click(function(){
   		//$('#img_file').click();
   	});
   
   
   
   
   
   $('body').on('change', '#img_file', function() {
   $('#image_loader').show();
   var friend_id = $('#friend_id').val();
     var file_data = $(this).prop('files')[0]; 
       var form_data = new FormData();                  
       form_data.append('file', file_data);
      form_data.append('id', friend_id);
       //alert(form_data);
       console.log(form_data);
           
          // $('#postfrm').serialize()
            $.ajax({
                               url: '<?php echo $this->request->webroot;?>/Users/chat-upload-temp-image',
                                dataType: 'text',  // what to expect back from the PHP script, if anything
                                 cache: false,
                                 contentType: false,
                                 processData: false,
                                data: form_data,                         
                                type: 'post',
                               success: function(data){ //alert(data);
                                   if(data)
                                   {
                                   	var data_arr = data.split("||");
   						$('#last_message_id_foot').val(data_arr[0]);
   						/*$('.msg_body').append(data_arr[1]);	*/
   						$('<div class="msg_a">'+data_arr[1]+'</div>').insertBefore('.msg_push');
   						$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
                                                   $('.msg_input').val(""); 
                   $('#image_loader').hide();
                   //$('#file').val('');
                      //$('.close').click();
                                    // $("#post_time").prepend( data );  
                                   }  
                                   else
                                   {
                                      
                                   }
                               }
                       });
   
   });
   
   
   
   
   
   
   
   
   });
   // 	function readURL(input) {
   
   // $('#image_loader').show();
   // var file_data = $(this).prop('files')[0]; 
   //     var form_data = new FormData();                  
   //     form_data.append('file', file_data);
   //     //alert(form_data);
           
   //        // $('#postfrm').serialize()
   //          $.ajax({
   //                             url: '<?php echo $this->request->webroot;?>/Users/chat-upload-temp-image',
   //                              dataType: 'text',  // what to expect back from the PHP script, if anything
   //                               cache: false,
   //                               contentType: false,
   //                               processData: false,
   //                              data: form_data,                         
   //                              type: 'post',
   //                             success: function(data){ 
   // //console.log(data);
   //                var data_arr = data.split("||");
   // 						$('#last_message_id_foot').val(data_arr[0]);
   // 						/*$('.msg_body').append(data_arr[1]);	*/
   // 						$('<div class="msg_a">'+data_arr[1]+'</div>').insertBefore('.msg_push');
   // 						$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
   //                                                 $('.msg_input').val(""); 
   
   
   //                                                 $('#image_loader').hide();
   //                             }
   //                     });
   
   
   		
   //     }
</script>
    
        
       
    <script>
        $(document).ready(function() {
            $(".more-btn").click(function() {
                $(this).parent().toggleClass("show-all")
            });
            $(".less-btn").click(function() {
                $(this).parent().parent().removeClass("show-all")
            });
        });
    </script>
</body>

</html>
