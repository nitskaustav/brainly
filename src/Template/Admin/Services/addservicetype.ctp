<?php ?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Add Type</h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Add Type</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group"> 


                                    </div>
                                </li>

                            </ul>
                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body"> 
                        <div class="col-sm-6">
                            <div class="row">
                                <?php echo $this->Form->create($service, ['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data']); ?>

                                <input type="hidden" name="is_active" id="is_active" value="1" />


                                <div class="form-block">



                                    <div class="form-group">
                                        <label class="control-label col-lg-4"> Type Name</label>
                                        <div class="col-lg-8">
                                            <?php echo $this->Form->input('type_name', array('class' => 'form-control', 'label' => false)); ?>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Type Description</label>
                                        <div class="col-lg-8">
                                            <?php echo $this->Form->input('description', array('class' => 'form-control', 'label' => false, 'type' => 'textarea')); ?>
                                        </div>
                                    </div>


                                    <!--                                <div class="form-group">
                                                                        <label class="control-label col-lg-4">Select Tag</label>
                                                                        <div class="col-lg-8"> 
                                    <?php foreach ($tags as $dt) {
                                        ?>
                                                                                                    <div class="col-lg-1">
                                                                                                        <input type="checkbox" name="tag_id[]" value="<?php echo $dt->id; ?>">
                                                                                                    </div>
                                                                                                    <div class="col-lg-7">
                                        <?php echo $dt->tag_name; ?>
                                                                                                    </div>
                                                                                                    <div class="clearfix"></div>
                                        <?php
                                    }
                                    ?>
                                                                        </div>
                                                                    </div>    -->


                                    <div class="form-group"> 
                                        <label class="control-label col-lg-4">Type Icon</label>
                                        <div class="col-lg-8">
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <div class="fileupload-preview thumbnail" style="width: 150px; height: 150px;">
                                                </div>
                                                <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                                        <input type="file" id="image" name="icon" />
                                                    </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                            </div>
                                        </div>
                                    </div>     

                                    <label class="control-label col-lg-4"></label>
                                    <div class="col-lg-8" style="text-align:left;"> 
                                        <input type="submit" name="submit" value="Add Bike Type" class="btn btn-primary" />
                                    </div>
                                    <?php echo $this->Form->end(); ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>