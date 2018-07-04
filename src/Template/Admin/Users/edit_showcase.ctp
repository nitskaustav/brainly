
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
          <h1>Bank Showcase</h1>
        </div>
      </div>
      <hr/>
	  <?php echo  $this->Flash->render('success') ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="box">
            <header>
              <div class="icons"><i class="icon-th-large"></i></div>
              <h5>Bank Showcase</h5>
            </header>
            <div id="collapseOne" class="accordion-body collapse in body">
              <div class="col-sm-6">
                  
                  <div class="row">
						<?php echo  $this->Form->create("", ['enctype'=>'multipart/form-data', 'class' => 'form-horizontal', 'id'=>'block-validate']) ?>
						
						<input type="hidden" name="id" id="id" value="<?php if($showcase) echo $showcase->id;?>" />
                        <input type="hidden" name="service_provider_id" id="service_provider_id" value="<?php echo $this->request->Session()->read('Auth.User.id');?>" />
                   		
						<div class="form-group">
                          <label class="control-label col-lg-4" >Title</label>
                          <div class="col-lg-8">
							<input type="text" class="form-control" name="title" value="<?php echo $showcase->title;?>">
                          </div>                       
                        </div>
						
						<div class="form-group">
                          <label class="control-label col-lg-4" >Image</label>
                          <div class="col-lg-8">
                             <div data-provides="fileupload" class="fileupload fileupload-new">
                                <div style="width: 200px; height: 150px;" class="fileupload-preview thumbnail">
									<?
										if($showcase)
											echo $this->Html->image('showcase/'.$showcase->image_name); 
									?>								 
								</div>
                                <div>
                                    <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span>
                                    <span class="fileupload-exists">Change</span>
                                    <input type="file"  name="logo_img" ></span>
                                    <a data-dismiss="fileupload" class="btn btn-danger fileupload-exists" href="#">Remove</a>
                                </div>
							 </div>
	                       </div>                       
                        </div>
 
                        <div class="form-actions no-margin-bottom" style="text-align:center;">
                          <input type="submit" name="submit" value="Update Details" class="btn btn-primary" />
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