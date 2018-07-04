<script>
$(document).ready(function() {
	$("#ex1").slider({
		tooltip: 'always'
	});
});
</script>
<div id="content">
    <div class="inner">
          <div class="row">
        <div class="col-sm-10">
          <h2>General User </h2>
              
        </div>
        <div class="col-sm-2">
        <h2>

		<?php echo $this->Html->link('List General User', '/admin/users/generaluser', ['class' => 'btn btn-xs btn-success close-box', 'target' => '_self']);?>
        
         </h2>      
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="box">
            <header>
              <div class="icons"><i class="icon-th-large"></i></div>
              <h5>Edit General User</h5>
              <div class="toolbar">
             
              </div>
            </header>
            <div id="collapseOne" class="accordion-body collapse in body">





              <div class="col-sm-12">
                  
                  <div class="row">
                      
						<?php echo $this->Form->create($g_user,['enctype'=>'multipart/form-data','class' => 'form-horizontal', 'id' => 'signup-edit-validate']);?>
                        
                                      
    <div class="form-group">
       <label class="control-label col-lg-4">Full Name</label>
          <div class="col-lg-8">
<input type="text" id="name" name="name" class="form-control" value="<?php echo $g_user->name?>"/>

          </div>
    </div>
                        
    <div class="form-group">
        <label class="control-label col-lg-4">Email</label>
           <div class="col-lg-8">
 <input type="text"  id="email" readonly="readonly" name="email" class="form-control" value="<?php echo $g_user->email?>"/>
           </div>
    </div>  
    
    
    <div class="form-group">
        <label class="control-label col-lg-4">Phone</label>
           <div class="col-lg-8">
             <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $g_user->phone?>"/> 
           </div>
    </div>  
    
    
   <div class="form-group">
        <label class="control-label col-lg-4">Address</label>
           <div class="col-lg-8">
<input type="text" id="address" name="address" class="form-control" value="<?php echo $g_user->address?>"/> 
           </div>
    </div>
	
	<div class="form-group">
        <label class="control-label col-lg-4">City</label>
           <div class="col-lg-8">
              <input type="text" id="city" name="city" class="form-control" value="<?php echo $g_user->city?>"/> 
           </div>
    </div>

	<div class="form-group">
        <label class="control-label col-lg-4">State</label>
           <div class="col-lg-8">
             <input type="text" id="state" name="state" class="form-control" value="<?php echo $g_user->state?>"/> 
           </div>
    </div>	
	
	<div class="form-group">
        <label class="control-label col-lg-4">Zip</label>
           <div class="col-lg-8">
             <input type="text" id="zip" name="zip" class="form-control" value="<?php echo $g_user->zip?>"/> 
           </div>
    </div>	
	
	
	<div class="form-group">
                    	<label class="control-label col-lg-4">Gender</label>
					<div class="col-lg-8">	
                        <label class="radio-inline2"> <input type="radio" name="gender" value="male"<?php if($g_user->gender=='male'){?> checked="checked" <?php } ?>>Male</label>
						<label class="radio-inline2"> <input type="radio" name="gender" value="female"<?php if($g_user->gender=='female'){?> checked="checked" <?php } ?>>Felale</label>
					</div>	
						
                    </div>
	
		<div class="form-group">
				<label class="control-label col-lg-4">Birth Date</label>
				<div class="col-lg-6">
				<div class="col-lg-2">
							<?php
							 $dob = $g_user->dob;
							 $ex1 = explode("-",$dob);
						    
							?>
							<input type="text" name="month"  class="form-control" placeholder="MM" value="<?php echo $ex1['1']?>">
						
				</div>	
				<div class="col-lg-2">			
							<input type="text" name="day" value="<?php echo $ex1['2']?>" class="form-control" placeholder="DD">
						
				</div>	
				<div class="col-lg-4">			
							<input type="text" name="year" value="<?php echo $ex1['0']?>" class="form-control" placeholder="YY">
					
				</div>
				</div>
			</div>                                           
    
		<div class="form-group">
        <label class="control-label col-lg-4">Password</label>
           <div class="col-lg-8">
             <input type="password" id="password" name="password" class="form-control" value=""/> 
           </div>
    </div>	

     <div class="form-group">
                        <label class="control-label col-lg-4">Image Upload</label>
                          <div class="col-lg-8">
                             <div data-provides="fileupload" class="fileupload fileupload-new">
                                <div style="width: 200px; height: 150px;" class="fileupload-preview thumbnail">
                                
                           
                                
<?php echo  $this->Html->image('userimage/'.$g_user->user_img) ?>								 
                                                             
                                </div>
                                <div>
                                    <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span>
                                    <span class="fileupload-exists">Change</span>
                                    <input type="file"  name="user_img" ></span>
                                    <a data-dismiss="fileupload" class="btn btn-danger fileupload-exists" href="#">Remove</a>
                                </div>
                            </div>
	                        </div>
                    	</div>           
                        
                     
                        
                              
                    	<input type="hidden" name="uimage" value="<?php echo $g_user->user_img;?>">
                        <div class="form-actions no-margin-bottom" style="text-align:right;">
                          <input type="submit" name="submit" value="Edit User" class="btn btn-primary btn-lg" />
                        </div>
                      </form>
                  </div>
              </div>             






              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
