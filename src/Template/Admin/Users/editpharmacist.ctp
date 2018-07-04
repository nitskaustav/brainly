<?php //pr($user); //exit; ?>


<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Edit Lab Technician </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Edit Lab Technician</h5>
<!--                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group"> 
                                        <a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "adddoctor"]); ?>">
                                            <button class="btn btn-xs btn-success close-box"> <i class="icon-plus"></i> Add Doctor</button></a>
                                        <a href="<?php echo $this->Url->build(["controller" => "Users","action" => "listdoctor"]);?>"><button class="btn btn-xs btn-success close-box">
                                                <i class="icon-list"></i>List Doctor</button></a>
                                    </div>
                                </li>

                            </ul>
                        </div>-->
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-6">

                            <div class="row">
                                <?php echo $this->Form->create($user, ['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data']); ?>

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
                                    <option value="<?php echo $category->id; ?>" <?php echo $category->id==$user->category_id?"selected":""  ?>   ><?php echo $category->name; ?></option>
                                    <?php }?>
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">First Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo $user->first_name ?>"/>
                                    </div>
                                </div>  

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Last Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo $user->last_name ?>"/>
                                    </div>
                                </div>                                 

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Phone</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $user->name ?><?php echo $user->phone ?>"/>
                                    </div>
                                </div>                                

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Email</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="email" name="email" class="form-control" readonly="readonly" value="<?php echo $user->email ?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Password</label>
                                    <div class="col-lg-8">
                                        <input type="password" id="epassword" name="epassword" class="form-control" value=""/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Lisence No</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="first_name" name="license_no" class="form-control" value="<?php echo $user->license_no ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Subscription Start</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('subscription_start', array('type'=>"text",'class'=>'subdate form-control','label' => false,'value'=>date('Y-m-d',strtotime($user->subscription_start)))); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Subscription End</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('subscription_end', array("type"=>"text",'class'=>'subdate form-control','label' => false,'value'=>date('Y-m-d',strtotime($user->subscription_end)))); ?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Address</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="address" name="address" class="form-control" value="<?php echo $user->address ?>"/>
                                    </div>
                                </div>                                
                                <!--
                                <div class="form-group">
                                    <label class="control-label col-lg-4">City</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="first_name" name="city" class="form-control" value="<?php echo $user->city ?>"/>
                                    </div>
                                </div>                                
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Country</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="first_name" name="country" class="form-control" value="<?php echo $user->country ?>"/>
                                    </div>
                                </div>
                                -->
                                <div class="form-group">
                                  <label class="control-label col-lg-4">User Image </label>
                                  <div class="col-lg-8">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                            <?php $filePath = WWW_ROOT . 'user_img' .DS. $user->pimg; ?>
                                            <?php if ($user->pimg != "" && file_exists($filePath)) { ?>
                                                <img src="<?php echo $this->Url->build('/user_img/'.$user->pimg); ?>" width="150px" height="150px" />
                                            <?php } ?>
                                        </div>
                                      <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                        <input type="file" id="image" name="image" />
                                        </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                    </div>
                                  </div>
                                </div>                                 
                                
                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Edit Lab Technician" class="btn btn-primary" />
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
