<?php ?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1> Add Testimonial</h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Add Testimonial</h5>
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
				            <?php echo $this->Form->create($testimonial,['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data']);?>                                
                                <div class="form-block">
                                 <div class="form-group">
                                    <label class="control-label col-lg-4">User Name</label>
                                    <div class="col-lg-8">
                                        <select name="user_id" class="form-control">
                                            <?php
                                                foreach ($users as $user) {
                                                    echo '<option value="'.$user->id.'">'.$user->full_name.'</option>';
                                                }                                                 
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Title</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('title', array('class'=>'form-control','label' => false)); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Description</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('description', array('class'=>'form-control','label' => false,'type'=>'textarea')); ?>
                                    </div>
                                </div>
                                

                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" value="Add" class="btn btn-primary" />
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
</div>