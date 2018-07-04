<?php //pr($sitesettings); exit; ?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Edit Site Detail </h1>
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
                        <h5> Edit Site Detail </h5>
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
				  <?php echo $this->Form->create($sitesettings,['class' => 'form-horizontal', 'id' => 'siteset-validate', 'type' => 'post', 'enctype' => 'multipart/form-data']);?>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Site Title</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="site_title" name="site_title" class="form-control" value="<?php echo $sitesettings->site_title;?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Paypal Email</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="paypal_email" name="paypal_email" class="form-control" value="<?php echo $sitesettings->paypal_email;?>"/>
                                        <!--<input type="text" style="direction:rtl;" id="bank_name_arabic" name="last_name" class="form-control" value=""/>-->
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Contact Email</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="contact_email" name="contact_email" class="form-control" value="<?php echo $sitesettings->contact_email;?>"/>
                                        <!--<input type="text" style="direction:rtl;" id="bank_name_arabic" name="last_name" class="form-control" value=""/>-->
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Contact Fax</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="contact_fax" name="contact_fax" class="form-control" value="<?php echo $sitesettings->contact_fax;?>"/>
                                        <!--<input type="text" style="direction:rtl;" id="bank_name_arabic" name="last_name" class="form-control" value=""/>-->
                                    </div>
                                </div>                                
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Contact Phone</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="contact_phone" name="contact_phone" class="form-control" value="<?php echo $sitesettings->contact_phone;?>"/>
                                        <!--<input type="text" style="direction:rtl;" id="bank_name_arabic" name="last_name" class="form-control" value=""/>-->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Copyright Text</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="footer_text1" name="footer_text1" class="form-control" value="<?php echo $sitesettings->footer_text1;?>"/>
                                        <!--<input type="text" style="direction:rtl;" id="bank_name_arabic" name="last_name" class="form-control" value=""/>-->
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label class="control-label col-lg-4">Payment Method</label>
                                    <div class="col-lg-8"> -->
<!--                                        <div class=" col-md-6"><input type="checkbox"  name="is_paypal" class="form-control" value="1" <?php echo $sitesettings->is_paypal?'checked':'';?>/>Payapal</div>
                                        <div class="col-md-6"><input type="checkbox"  name="is_stripe" class="form-control" value="1" <?php echo $sitesettings->is_stripe?'checked':'';?>/>Stripe
</div>-->
                                        
                                       <!--  <div class="checkbox">
                                            <label><input type="checkbox" value="1" name="is_paypal" <?php echo $sitesettings->is_paypal?'checked':'';?>>Payapal</label>
                                        </div>
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="1" name="is_stripe" <?php echo $sitesettings->is_stripe?'checked':'';?>>Stripe</label>
                                            </div>
                                        
                                        
                                    </div>
                                </div> -->
                                
                                <!--
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Twitter Url</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="twitter_url" name="twitter_url" class="form-control" value="<?php echo $sitesettings->twitter_url;?>"/>
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Linkedin Url</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="linkedIn_url" name="linkedIn_url" class="form-control" value="<?php echo $sitesettings->linkedIn_url;?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Facebook Url</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="facebook_url" name="facebook_url" class="form-control" value="<?php echo $sitesettings->facebook_url;?>"/>
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">GPlus Url</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="gplus_url" name="gplus_url" class="form-control" value="<?php echo $sitesettings->gplus_url;?>"/>
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Youtube Url</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="youtube_url" name="youtube_url" class="form-control" value="<?php echo $sitesettings->youtube_url;?>"/>
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="autosize">Google Analytics Code</label>
                                    <div class="col-lg-8">
                                        <textarea id="google_analytics" name="google_analytics" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 200px;"><?php echo $sitesettings->google_analytics;?></textarea>
                                    </div>
                                </div>
                                -->
                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Update Site Detail" class="btn btn-primary" />
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