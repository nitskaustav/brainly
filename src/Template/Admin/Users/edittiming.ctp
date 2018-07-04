<?php //pr($user); //exit; ?>


<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Edit Timing </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Edit Timing</h5>
                        <div class="toolbar">

                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-6">

                            <div class="row">
                                <?php echo $this->Form->create($user, ['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data']); ?>

                                                               

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Day Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="first_name" name="day" class="form-control" value="<?php echo $user->day ?>"/>
                                    </div>
                                </div>  

                                                               

                                <div class="form-group">
                                    <label class="control-label col-lg-4">From Time</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="email" name="from_time" class="form-control"  value="<?php echo $user->from_time ?>"/>
                                    </div>
                                </div>

                               

                                
                                                               
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">To Time</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="first_name" name="to_time" class="form-control" value="<?php echo $user->to_time ?>"/>
                                    </div>
                                </div>                                
                                
                                
                                                             
                                
                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Edit Timing" class="btn btn-primary" />
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

<style>
    .datepicker{
        background:white !important;
    }    
</style>    