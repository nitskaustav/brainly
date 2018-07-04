<?php //pr($sitesettings); exit; ?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Edit Site Social Detail </h1>
            </div>
        </div>
        <hr />
	  <?php //echo  $this->Flash->render('success') ?>
	  <?php //echo  $this->Flash->render('error') ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5> Edit Site Social Detail </h5>
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
<!--                                <div class="form-group">
                                    <label class="control-label col-lg-2">Twitter Url</label>
                                    <div class="col-lg-10">
                                        <input type="text" id="twitter_url" name="twitter_url" class="form-control" value="<?php echo $sitesettings->twitter_url;?>"/>
                                    </div>
                                </div>                                -->
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Instagram Url</label>
                                    <div class="col-lg-10">
                                        <input type="text" id="linkedIn_url" name="instagram_url" class="form-control" value="<?php echo $sitesettings->instagram_url;?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Facebook Url</label>
                                    <div class="col-lg-10">
                                        <input type="text" id="facebook_url" name="facebook_url" class="form-control" value="<?php echo $sitesettings->facebook_url;?>"/>
                                    </div>
                                </div>                                
<!--                                <div class="form-group">
                                    <label class="control-label col-lg-2">GPlus Url</label>
                                    <div class="col-lg-10">
                                        <input type="text" id="gplus_url" name="gplus_url" class="form-control" value="<?php echo $sitesettings->gplus_url;?>"/>
                                    </div>
                                </div>                                -->
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Youtube Url</label>
                                    <div class="col-lg-10">
                                        <input type="text" id="youtube_url" name="youtube_url" class="form-control" value="<?php echo $sitesettings->youtube_url;?>"/>
                                    </div>
                                </div>  
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Android Url</label>
                                    <div class="col-lg-10">
                                        <input type="text" id="androaid_link" name="androaid_link" class="form-control" value="<?php echo $sitesettings->androaid_link;?>"/>
                                    </div>
                                </div> 
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Youtube Url</label>
                                    <div class="col-lg-10">
                                        <input type="text" id=" ios_link" name="ios_link" class="form-control" value="<?php echo $sitesettings->ios_link;?>"/>
                                    </div>
                                </div> 
                                
<!--                                <div class="form-group">
                                    <label class="control-label col-lg-2" for="autosize">Google Analytics Code</label>
                                    <div class="col-lg-10">
                                        <textarea id="google_analytics" name="google_analytics" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 200px;"><?php echo $sitesettings->google_analytics;?></textarea>
                                    </div>
                                </div>-->

                                <label class="control-label col-lg-2"></label>
                                <div class="col-lg-10" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Update Site Social Detail" class="btn btn-primary" />
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