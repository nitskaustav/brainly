
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
          <h1>Bank Details</h1>
        </div>
      </div>
      <hr/>
	  <?php echo  $this->Flash->render('success') ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="box">
            <header>
              <div class="icons"><i class="icon-th-large"></i></div>
              <h5>Bank Info</h5>
            </header>
            <div id="collapseOne" class="accordion-body collapse in body">
              <div class="col-sm-6">
                  
                  <div class="row">
						<?php echo  $this->Form->create("", ['enctype'=>'multipart/form-data', 'class' => 'form-horizontal', 'id'=>'block-validate']) ?>
						
						<input type="hidden" name="id" id="id" value="<?php if($bankdetail) echo $bankdetail['0']->id;?>" />
                        <input type="hidden" name="service_provider_id" id="service_provider_id" value="<?php echo $this->request->Session()->read('Auth.User.id');?>" />
                        
                        <div class="form-group">
                          <label class="control-label col-lg-4" >Bank Website </label>
                          <div class="col-lg-8">
                          <textarea  name="bank_website" id="bank_website" class="form-control" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 133px;"><?php if($bankdetail) echo $bankdetail['0']->bank_website;?></textarea>
                          </div>                       
                        </div>
						
						<div class="form-group">
                          <label class="control-label col-lg-4" >Call Center Email </label>
                          <div class="col-lg-8">
                          <input type="text"  name="call_center_email" id="call_center_email" class="form-control" value="<?php if($bankdetail) echo $bankdetail['0']->call_center_email;?>">
                          </div>                       
                        </div>
						
						<div class="form-group">
                          <label class="control-label col-lg-4" >Enquiries Email </label>
                          <div class="col-lg-8">
                          <input type="text"  name="enquiries_email" id="enquiries_email" class="form-control" value="<?php if($bankdetail) echo $bankdetail['0']->enquiries_email;?>">
						  </div>                       
                        </div>
						
						
						<div class="form-group">
                          <label class="control-label col-lg-4" >Bank Description (English)</label>
                          <div class="col-lg-8">
                          <textarea  name="bank_desc_eng" class="form-control" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 133px;"><?php if($bankdetail) echo $bankdetail['0']->bank_desc_eng;?></textarea>
                          </div>                       
                        </div>

						<div class="form-group">
                          <label class="control-label col-lg-4" >Bank Description (Arabic)</label>
                          <div class="col-lg-8">
                          <textarea  name="bank_desc_arabic" class="form-control" style="direction:rtl;overflow: hidden; word-wrap: break-word; resize: horizontal; height: 133px;"><?php if($bankdetail) echo $bankdetail['0']->bank_desc_arabic;?></textarea> 
                          </div>                       
                        </div>

						<div class="form-group">
                          <label class="control-label col-lg-4" >Service Description (English)</label>
                          <div class="col-lg-8">
                          <textarea  name="service_desc_eng" class="form-control" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 133px;"><?php if($bankdetail) echo $bankdetail['0']->service_desc_eng;?></textarea>
                          </div>                       
                        </div>
						
						<div class="form-group">
                          <label class="control-label col-lg-4" >Service Description (Arabic)</label>
                          <div class="col-lg-8">
                          <textarea  name="service_desc_arabic" class="form-control" style="direction:rtl;overflow: hidden; word-wrap: break-word; resize: horizontal; height: 133px;"><?php if($bankdetail) echo $bankdetail['0']->service_desc_arabic;?></textarea> 
                          </div>                       
                        </div> 						
                        
                        <div class="form-group">
                          <label class="control-label col-lg-4" >Branch Description (English)</label>
                          <div class="col-lg-8">
                          <textarea  name="branch_desc_eng" class="form-control" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 133px;"><?php if($bankdetail) echo $bankdetail['0']->branch_desc_eng;?></textarea>
                          </div>                       
                        </div>
						
						<div class="form-group">
                          <label class="control-label col-lg-4" >Branch Description (Arabic)</label>
                          <div class="col-lg-8">
                          <textarea  name="branch_desc_arabic" class="form-control" style="direction:rtl;overflow: hidden; word-wrap: break-word; resize: horizontal; height: 133px;"><?php if($bankdetail) echo $bankdetail['0']->branch_desc_arabic;?></textarea> 
                          </div>                       
                        </div>
						
						
						
						<!--<div class="form-group">
                          <label class="control-label col-lg-4">Call Me Back</label>
                          <div class="col-lg-8">
							<select class="form-control" name="call_me_back">
								<option value="yes" <?php if($bankdetail) { if($bankdetail['0']->call_me_back == "yes") { echo "selected"; }} ?>>Yes</option>
								<option value="no" <?php if($bankdetail) { if($bankdetail['0']->call_me_back == "no") { echo "selected"; }} ?>>No</option>
							</select>
                          </div>                       
                        </div>
						
						<div class="form-group">
                          <label class="control-label col-lg-4">Apply Online</label>
                          <div class="col-lg-8">
							<select class="form-control" name="website">
								<option value="yes" <?php if($bankdetail) { if($bankdetail['0']->website == "yes") { echo "selected"; }} ?>>Yes</option>
								<option value="no" <?php if($bankdetail) { if($bankdetail['0']->website == "no") { echo "selected"; }} ?>>No</option>
							</select>
                          </div>                       
                        </div>
						
						<div class="form-group">
                          <label class="control-label col-lg-4">Find Nearest Branch</label>
                          <div class="col-lg-8">
							<select class="form-control" name="nearest_branch">
								<option value="yes" <?php if($bankdetail) { if($bankdetail['0']->nearest_branch == "yes") { echo "selected"; }} ?>>Yes</option>
								<option value="no" <?php if($bankdetail) { if($bankdetail['0']->nearest_branch == "no") { echo "selected"; }} ?>>No</option>
							</select>
                          </div>                       
                        </div>-->
						
						<div class="form-group">
                          <label class="control-label col-lg-4" >Bank Logo</label>
                          <div class="col-lg-8">
                             <div data-provides="fileupload" class="fileupload fileupload-new">
                                <div style="width: 200px; height: 150px;" class="fileupload-preview thumbnail">
									<?
										if($bankdetail)
											echo $this->Html->image('banklogo/'.$bankdetail['0']->logo); 
									?>								 
								</div>
								<h5>Logo size(width: 300px and Height: 90px)</h5>
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