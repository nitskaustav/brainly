<?php ?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1> Add  Model</h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Add  Model</h5>
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




                                <div class="form-block">

                                    <!-- <div class="form-group">
                                        <label class="control-label col-lg-4">Maker Name</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="make_id" required="">
                                                <option value="">Choose Maker</option>
                                    <?php foreach ($makes as $dt) {
                                        ?>
                                                            
                                                         <option value="<?php echo $dt->id; ?>"><?php echo $dt->make_name; ?></option>
                                        <?php
                                    }
                                    ?>
                                            </select>
                                        </div>
                                    </div>   -->                            

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Model Name</label>
                                        <div class="col-lg-8">
                                            <?php echo $this->Form->input('model_name', array('class' => 'form-control', 'label' => false)); ?>
                                        </div>
                                    </div>




                                    <label class="control-label col-lg-4"></label>
                                    <div class="col-lg-8" style="text-align:left;"> 
                                        <input type="submit" name="submit" value="Add Model" class="btn btn-primary" />
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