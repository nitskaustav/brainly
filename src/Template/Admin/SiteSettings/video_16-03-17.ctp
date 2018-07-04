    <?php ?>
    <div id="content">
    <div class="inner">
      <div class="row">
        <div class="col-lg-12">
          <h2> Site Video Management </h2>
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
                <?php echo $this->Form->create($sitesettings,['class' => 'form-horizontal', 'id' => 'admin-validate', 'type' => 'post', 'enctype' => 'multipart/form-data']);?>
                <?php $filePath1 = WWW_ROOT . 'video' .DS.$sitesettings->video; ?>
                <?php if ($sitesettings->video != "" && file_exists($filePath1)) { ?>
                <div class="form-group">
                  <label class="control-label col-lg-4">VIdeo</label>
                  <div class="col-lg-8">
                    <video width="400" controls>
                        <source src="<?php echo $this->Url->build('/video/'.$sitesettings->video);?>" type="video/mp4">
                        Your browser does not support HTML5 video.
                    </video>
                  </div>
                </div>                    
                <!--    
                <div class="form-group">
                  <label class="control-label col-lg-4">VIdeo</label>
                  <div class="col-lg-8">
                    <video width="400" controls>
                        <source src="http://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                        Your browser does not support HTML5 video.
                    </video>
                  </div>
                </div>                       
                -->
                <?php } ?>                

                <div class="form-group">
                  <label class="control-label col-lg-4">VIdeo Upload</label>
                  <div class="col-lg-8">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-preview thumbnail">
                        </div>
                      <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select video</span><span class="fileupload-exists">Change</span>
                        <input type="file" id="site_logo" name="site_video" />
                        </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-4"> </label>
                  <div class="col-lg-8">
                    <button type="submit" class="btn btn-primary" style="margin-top: 15px">Change Site Video</button>
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





