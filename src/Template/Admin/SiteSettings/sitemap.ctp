  <?php //pr($SiteSettings); exit; ?>
    <div id="content">
    <div class="inner">
      <div class="row">
        <div class="col-lg-12">
          <h2> Site Map Management </h2>
        </div>
      </div>
      <hr />
      <div class="row">
        <div class="col-lg-12">
          <div class="box">
            <header class="dark">
              <div class="icons"><i class="icon-cloud-upload"></i></div>
              <h5> Site Map Upload</h5>
            </header>
            <div class="body">
              <!-- <form class="form-horizontal"> -->
                  <?php echo $this->Form->create($sitesettings,['class' => 'form-horizontal', 'id' => 'admin-validate', 'type' => 'post', 'enctype' => 'multipart/form-data']);?>
                
                <div class="form-group">
                    <label class="control-label col-lg-4"> Upload Site Map </label>
                    <div class="col-lg-8">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <span class="btn btn-file btn-default">
                                <span class="fileupload-new">Select file</span>
                                <span class="fileupload-exists">Change</span>
                                <input type="file" id="site_map" name="site_map" />
                            </span>
                            <span class="fileupload-preview"></span>
                            <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
                        </div>
                    </div>
                </div>              
             
                <div class="form-group">
                  <label class="control-label col-lg-4"> </label>
                  <div class="col-lg-8">
                    <button type="submit" class="btn btn-primary" style="margin-top: 15px">Upload Site Map</button>
                  </div>
                </div>  
                <!-- </form> -->
                <?php echo $this->Form->end() ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--END PAGE CONTENT --> 
    
  </div>