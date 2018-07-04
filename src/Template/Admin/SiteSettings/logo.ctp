  <?php //pr($SiteSettings); exit; ?>
    <div id="content">
    <div class="inner">
      <div class="row">
        <div class="col-lg-12">
          <h2> Site Logo And favicon Management </h2>
        </div>
      </div>
      <hr />
      <div class="row">
        <div class="col-lg-12">
          <div class="box">
            <header class="dark">
              <div class="icons"><i class="icon-cloud-upload"></i></div>
              <h5>File Upload</h5>
            </header>
            <div class="body">
              <!-- <form class="form-horizontal"> -->
                  <?php echo $this->Form->create($sitesettings,['class' => 'form-horizontal', 'id' => 'admin-validate', 'type' => 'post', 'enctype' => 'multipart/form-data']);?>
                  <!--
                <div class="form-group">
                  <label class="control-label col-lg-4">Browser Default</label>
                  <div class="col-lg-8">
                    <input type="file" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-4">Bootstrap Style</label>
                  <div class="col-lg-8">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="input-group"> <span class="btn btn-file btn-info"> <span class="fileupload-new">Select file</span> <span class="fileupload-exists">Change</span>
                        <input type="file" />
                        </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> <br />
                        <br />
                        <div class="col-lg-3"> <i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span> </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-4">No Input</label>
                  <div class="col-lg-8">
                    <div class="fileupload fileupload-new" data-provides="fileupload"> <span class="btn btn-file btn-default"> <span class="fileupload-new">Select file</span> <span class="fileupload-exists">Change</span>
                      <input type="file" />
                      </span> <span class="fileupload-preview"></span> <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">�</a> </div>
                  </div>
                </div>
                  -->
                <div class="form-group">
                  <label class="control-label col-lg-4">Logo Upload</label>
                  <div class="col-lg-8">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                            <?php $filePath1 = WWW_ROOT . 'logo' .DS.$sitesettings->site_logo; ?>
                            <?php if ($sitesettings->site_logo != "" && file_exists($filePath1)) { ?>
                                <img src="<?php echo $this->Url->build('/logo/'.$sitesettings->site_logo); ?>" width="200px" height="150px" />
                            <?php } ?>
                        </div>
                      <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                        <input type="file" id="site_logo" name="site_logo" />
                        </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                    </div>
                  </div>
                </div>
                  
                  <!--
                <div class="form-group">
                    <label class="control-label col-sm-4">Logo Image</label>
                    <div class="col-sm-8">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-preview thumbnail" style="width: 100px; height: 75px;"><?php if ($result->site_logo != "") { ?>
                                <img src="<?= base_url() ?>assets/logo_img/<?= $result->site_logo ?>" width="100px" height="75px" /><?php } ?></div>
                            <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                <input type="file" id="site_logo" name="site_logo" />
                                </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                        </div>
                    </div>
                </div>                  
                  -->
                  
                <div class="form-group">
                  <label class="control-label col-lg-4"> Favicon Upload</label>
                  <div class="col-lg-8">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                            <?php $filePath2 = WWW_ROOT . 'logo' .DS.$sitesettings->site_favicon; ?>
                            <?php if ($sitesettings->site_favicon != "" && file_exists($filePath2)) { ?>
                                <img src="<?php echo $this->Url->build('/logo/'.$sitesettings->site_favicon); ?>" width="200px" height="150px" />
                            <?php } ?>                            
                            
                            
                        </div>
                      <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                        <input type="file" id="site_favicon" name="site_favicon" />
                        </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                    </div>
                  </div>
                </div>                  
                  
                  
                  <!--
                <div class="form-group">
                  <label class="control-label col-lg-4">Pre Defined Image</label>
                  <div class="col-lg-8">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="assets/img/demoUpload.jpg" alt="" /></div>
                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div> <span class="btn btn-file btn-primary"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                        <input type="file" />
                        </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                    </div>
                  </div>
                </div>
                  -->
                  
                <div class="form-group">
                  <label class="control-label col-lg-4"> </label>
                  <div class="col-lg-8">
                    <button type="submit" class="btn btn-primary" style="margin-top: 15px">Change Site Images</button>
                  </div>
                </div>  
                  
                <!-- <div class="alert alert-warning"><strong>Notice!</strong> Image preview only works in IE10+, FF3.6+, Chrome6.0+ and Opera11.1+. In older browsers and Safari, the filename is shown instead.</div> -->
              <!-- </form> -->
                <?php echo $this->Form->end() ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--END PAGE CONTENT --> 
    
  </div>