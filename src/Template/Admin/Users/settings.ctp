
<?php echo $this->Html->script('/plugins/validationengine/js/jquery.validationEngine.js')?>
<?php echo $this->Html->script('/plugins/validationengine/js/languages/jquery.validationEngine-en.js')?>
<?php echo $this->Html->script('/plugins/jquery-validation-1.11.1/dist/jquery.validate.min.js')?>
<?php echo $this->Html->script('admin/validationInit.js')?> 
<?php echo $this->Html->script('/plugins/jasny/js/bootstrap-fileupload.js')?>

<script type="text/javascript">
	$(function () { formValidation(); });
</script>


<div id="content">
    <div class="inner">
      <div class="row">
        <div class="col-lg-12">
          <h1>Admin Details</h1>
        </div>
      </div>
      <hr/>
	  <?php echo  $this->Flash->render('success') ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="box">
            <header>
              <div class="icons"><i class="icon-th-large"></i></div>
              <h5>Admin Info</h5>
            </header>
            <div id="collapseOne" class="accordion-body collapse in body">
              <div class="col-sm-6">
                  
                  <div class="row">
						<?php echo  $this->Form->create($user, ['class' => 'form-horizontal', 'id'=>'block-validate']) ?>
						
                        <input type="hidden" name="id" id="id" value="<?php echo $user['id'];?>" />
                        
                        <div class="form-group">
                          <label class="control-label col-lg-4" >User name</label>
                          <div class="col-lg-8">
                          <input type="text" name="username" id="username" class="form-control" value="<?php echo $user['username'];?>">
                          </div>                       
                        </div> 
                        
                        <div class="form-group">
                          <label class="control-label col-lg-4" >Email</label>
                          <div class="col-lg-8">
                          <input type="text" name="email" id="email" class="form-control" value="<?php echo $user['email'];?>">
                          </div>                       
                        </div> 
                        
                        <div class="form-group">
                          <label class="control-label col-lg-4" >New Password</label>
                          <div class="col-lg-8">
                          <input type="password" name="admin_password"  class="form-control">
                          </div>                       
                        </div> 
 
                        <div class="form-actions no-margin-bottom" style="text-align:center;">
                          <input type="submit" name="submit" value="Edit Admin" class="btn btn-primary" />
                        </div>
                      <?php echo $this->Form->end();?>
                  </div>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>