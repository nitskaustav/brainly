<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Add Lab Technician </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Add Lab Technician </h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group"> 
                                        <a href="<?php echo $this->Url->build(["controller" => "Users","action" => "listpharmacist"]);?>"><button class="btn btn-xs btn-success close-box">
                                                <i class="icon-list"></i>List Lab Technician</button></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body"> 
                        <div class="col-sm-6">
                            <div class="row">
				<?php echo $this->Form->create($user,['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data']);?>
                                <input type="hidden" name="utype" id="utype" value="3" />
                                <input type="hidden" name="is_active" id="is_active" value="1" />
                                <input type="hidden" name="is_mail_verified" id="is_mail_verified" value="1" />
                                
                                <div class="form-block">

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Gender</label>
                                    <div class="col-lg-8">
                                        <?php 
                                        $options = ['Male' => 'Male', 'Female' => 'Female'];
                                        $attributes = ['legend' => true, 'value' => $user->gender];
                                        echo $this->Form->radio('gender', $options, $attributes);
                                        ?>
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Category</label>
                                    <div class="col-lg-8">
                                    <select name="category_id" class="form-control">
                                    <option value="">Choose Category</option>
                                    <?php
                                    foreach($categories as $category)
                                    {
                                    ?>
                                    <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                    <?php }?>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">First Name</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('first_name', array('class'=>'form-control','label' => false)); ?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Last Name</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('last_name', array('class'=>'form-control','label' => false)); ?>
                                    </div>
                                </div>
 
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Phone</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('phone', array('class'=>'form-control','label' => false)); ?>
                                    </div>
                                </div>                                
                                <!--
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Username</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="username" name="username" class="form-control" value=""/>
                                    </div>
                                </div>
                                -->
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Email</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('email', array('class'=>'form-control','label' => false)); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Password</label>
                                    <div class="col-lg-8">
                                        <input type="password" id="password" name="password" class="form-control" value=""/>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">License No</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('license_no', array('class'=>'form-control','label' => false)); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Subscription Start</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('subscription_start', array("type"=>"text",'class'=>'subdate form-control','label' => false)); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Subscription End</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('subscription_end', array("type"=>"text",'class'=>'subdate form-control','label' => false)); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Address</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('address', array('class'=>'form-control','label' => false)); ?>
                                    </div>
                                </div>
                                <!--
                                <div class="form-group">
                                    <label class="control-label col-lg-4">City</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('city', array('class'=>'form-control','label' => false)); ?>
                                    </div>
                                </div>                                
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Country</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('country', array('class'=>'form-control','label' => false)); ?>
                                    </div>
                                </div>
                                -->
                                <div class="form-group"> 
                                  <label class="control-label col-lg-4">User Image </label>
                                  <div class="col-lg-8">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-preview thumbnail" style="width: 150px; height: 150px;">
                                        </div>
                                      <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                        <input type="file" id="image" name="image" />
                                        </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                    </div>
                                  </div>
                                </div>                                
                                
                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Add Lab Technician" class="btn btn-primary" />
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
<script src="<?php echo $this->request->webroot;?>js/bootstrap-datepicker.js"></script>
<script>
$(document).ready(function(){
    $('.subdate').datepicker({
    format:"yyyy-mm-dd",
    startDate:"today"
    });
});
</script>
<style>
    .datepicker{
        background:white !important;
    }    
</style>    

