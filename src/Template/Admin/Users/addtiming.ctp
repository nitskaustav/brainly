<?php ?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Add Service </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Add Timing</h5>
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
				<?php echo $this->Form->create($service,['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data']);?>
                                
                                <input type="hidden" name="is_active" id="is_active" value="1" />
                                
                                
                                <div class="form-block">

                                                                

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Day Name</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('day', array('class'=>'form-control','label' => false)); ?>
                                    </div>
                                </div>
                                
                                
 
                                                              
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">From Time</label>
                                    <div class="col-lg-8">
                                        <?php echo $this->Form->input('from_time', array('class'=>'form-control','label' => false)); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">To Time</label>
                                    <div class="col-lg-8">
                                        <input type="text"  name="to_time" class="form-control" value=""/>
                                    </div>
                                </div>
                                
                                
                                
                                                               
                                
                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Add Timing" class="btn btn-primary" />
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