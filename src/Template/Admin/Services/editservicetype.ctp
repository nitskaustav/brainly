<?php //pr($user); //exit;      ?>


<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Edit Type </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Edit Type</h5>
                        <div class="toolbar">

                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-6">

                            <div class="row">
                                <?php echo $this->Form->create($user, ['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data']); ?>



                                <div class="form-group">
                                    <label class="control-label col-lg-4">Type Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="first_name" name="type_name" class="form-control" value="<?php echo $user->type_name ?>"/>
                                    </div>
                                </div>  

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Type Description</label>
                                    <div class="col-lg-8">
                                        <textarea id="first_name" name="description" class="form-control"><?php echo $user->description ?></textarea>
                                    </div>
                                </div>


                                <?php //$sttag_id=explode(',',$user->tag_id); ?>    

                                <!--                            <div class="form-group">
                                                                    <label class="control-label col-lg-4">Service Tag</label>
                                                                    <div class="col-lg-8"> 
                                <?php foreach ($tags as $dt) {
                                    ?>
                                                                                                    <div class="col-lg-1">
                                                                                                        <input type="checkbox" name="tag_id[]" value="<?php echo $dt->id; ?>" <?php
                                    if (in_array($dt->id, $sttag_id)) {
                                        echo 'checked';
                                    }
                                    ?>>
                                                                                                    </div>
                                                                                                    <div class="col-lg-7">
                                    <?php echo $dt->tag_name; ?>
                                                                                                    </div>
                                                                                                    <div class="clearfix"></div>
                                    <?php
                                }
                                ?>
                                                                    </div>
                                                                </div>                              -->

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Type Icon</label>
                                    <div class="col-lg-8">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                                <?php $filePath = WWW_ROOT . 'service_img' . DS . $user->icon; ?>
                                                <?php if ($user->icon != "" && file_exists($filePath)) { ?>
                                                    <img src="<?php echo $this->Url->build('/service_img/' . $user->icon); ?>" width="150px" height="150px" />
                                                <?php } ?>
                                            </div>
                                            <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                                    <input type="file" id="image" name="icon" />
                                                </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                        </div>
                                    </div>
                                </div>


                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Edit Bike Type" class="btn btn-primary" />
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

<style>
    .datepicker{
        background:white !important;
    }    
</style>    