<?php //pr($sitesettings); exit; ?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Edit Site SEO Detail </h1>
            </div>
        </div>
        <hr />
	  <?php //echo $this->Flash->render('success') ?>
	  <?php //echo $this->Flash->render('error') ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5> Edit Site SEO Detail </h5>
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
                        <div class="col-sm-12">

                            <div class="row">
				  <?php echo $this->Form->create($sitesettings,['class' => 'form-horizontal', 'id' => 'siteset-validate', 'type' => 'post', 'enctype' => 'multipart/form-data']);?>

                                <div class="form-group">
                                    <label class="control-label col-lg-3">Site Meta Title</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="site_meta_title" name="site_meta_title" class="form-control" value="<?php echo $sitesettings->site_meta_title;?>"/>
                                    </div>
                                </div>
<!--                            <div class="form-group">
                                <label class="control-label col-lg-3">Site Meta Key</label>
                                <div class="col-lg-9">
                                    <input type="text" id="site_meta_key" name="site_meta_key" class="form-control" value="<?php echo $sitesettings->site_meta_key;?>"/>
                                    <input type="text" style="direction:rtl;" id="bank_name_arabic" name="last_name" class="form-control" value=""/>
                                </div>
                            </div>-->
                                
<!--                                <div class="form-group">
                                    <label class="control-label col-lg-3" for="autosize">Site Meta Description</label>
                                    <div class="col-lg-9">
                                        <textarea id="site_meta_description" name="site_meta_description" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 200px;"><?php echo $sitesettings->site_meta_description;?></textarea>
                                    </div>
                                </div>-->
                                 <div class="form-group">
                                    <label class="control-label col-lg-3" for="autosize">Site Meta Description</label>
                                    <div class="col-lg-9">
                                        <textarea id="site_meta_description" name="site_meta_description" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 200px;"><?php echo $sitesettings->site_meta_description;?></textarea>
                                    </div>
                                </div> 
                                 <div class="form-group">
                                    <label class="control-label col-lg-3" for="autosize">Meta Tags field</label>
                                    <div class="col-lg-9">
                                        <textarea id="site_meta_tags" name="site_meta_tags" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 200px;"><?php echo $sitesettings->site_meta_tags;?></textarea>
                                    </div>
                                </div> 
                                
                                                          
<!--                                <div class="form-group">
                                    <label class="control-label col-lg-3" for="autosize">Google Analytics Code</label>
                                    <div class="col-lg-9">
                                        <textarea id="google_analytics" name="google_analytics" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 200px;"><?php echo $sitesettings->google_analytics;?></textarea>
                                    </div>
                                </div>-->

                                <label class="control-label col-lg-3"></label>
                                <div class="col-lg-9" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Update Site SEO Detail" class="btn btn-primary" />
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>