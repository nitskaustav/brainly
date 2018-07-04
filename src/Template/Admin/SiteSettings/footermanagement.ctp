<?php //pr($sitesettings); exit; ?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Edit Footer Content </h1>
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
                        <h5>Edit Footer Content</h5>
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
				  <?php echo $this->Form->create($sitesettings,['class' => 'form-horizontal', 'id' => 'footer-content-valid', 'type' => 'post', 'enctype' => 'multipart/form-data']);?>

                                <div class="form-group">
                                    <label class="control-label col-lg-3">Footer Text1</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="footer_text1" name="footer_text1" class="form-control" value="<?php echo $sitesettings->footer_text1;?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Footer First  Logo</label>
                                    <div class="col-lg-9">
                                     <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                                <?php $filePath2 = WWW_ROOT . 'logo' .DS.$sitesettings->footer_logo; ?>
                                                <?php if ($sitesettings->footer_logo != "" && file_exists($filePath2)) { ?>
                                                    <img src="<?php echo $this->Url->build('/logo/'.$sitesettings->footer_logo); ?>" width="200px" height="150px" />
                                                <?php } ?>                            


                                            </div>
                              <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                <input type="file" id="footer_logo" name="footer_logo" />
                                </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                    </div>    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Footer Second Logo</label>
                                    <div class="col-lg-9">
                                     <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                                <?php $filePath2 = WWW_ROOT . 'logo' .DS.$sitesettings->footer_logo2; ?>
                                                <?php if ($sitesettings->footer_logo != "" && file_exists($filePath2)) { ?>
                                                    <img src="<?php echo $this->Url->build('/logo/'.$sitesettings->footer_logo2); ?>" width="200px" height="150px" />
                                                <?php } ?>                            


                                            </div>
                              <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                <input type="file" id="footer_logo2" name="footer_logo2" />
                                </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                    </div>    
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Footer First Logo Link</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="footer_logo_link" name="footer_logo_link" class="form-control" value="<?php echo $sitesettings->footer_logo_link;?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Footer Second Logo Link</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="footer_logo2_link" name="footer_logo2_link" class="form-control" value="<?php echo $sitesettings->footer_logo2_link;?>"/>
                                    </div>
                                </div>
<!--                                <div class="form-group">
                                    <label class="control-label col-lg-3">Facebook URL</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="facebook_url" name="facebook_url" class="form-control" value="<?php echo $sitesettings->facebook_url;?>"/>
                                    </div>
                                </div>
                               <div class="form-group">
                                    <label class="control-label col-lg-3">Twitter URL</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="twitter_url" name="twitter_url" class="form-control" value="<?php echo $sitesettings->twitter_url;?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Goole Plus URL</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="gplus_url" name="gplus_url" class="form-control" value="<?php echo $sitesettings->gplus_url;?>"/>
                                    </div>
                                </div>-->
                                
                                <label class="control-label col-lg-3"></label>
                                <div class="col-lg-9" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Update Footer Content" class="btn btn-primary" />
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