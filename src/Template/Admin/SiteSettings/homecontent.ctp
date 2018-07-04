<?php //pr($sitesettings); exit; ?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Edit Home Page Content </h1>
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
                        <h5> Edit Home Page Content </h5>
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
				  <?php echo $this->Form->create($sitesettings,['class' => 'form-horizontal', 'id' => 'siteset-homecontent', 'type' => 'post', 'enctype' => 'multipart/form-data']);?>

                                <div class="form-group">
                                    <label class="control-label col-lg-3">Banner Heading</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="bannerheading" name="bannerheading" class="form-control" value="<?php echo $sitesettings->bannerheading;?>" required=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Banner Heading2</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="bannerheading2" name="bannerheading2" class="form-control" value="<?php echo $sitesettings->bannerheading2;?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Banner Text1</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="bannner_subtxt1" name="bannner_subtxt1" class="form-control" value="<?php echo $sitesettings->bannner_subtxt1;?>"/>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-3" for="autosize">Banner Text2</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="bannner_subtxt2" name="bannner_subtxt2" class="form-control" value="<?php echo $sitesettings->bannner_subtxt2;?>"/>
                                    </div>
                                </div>                                
                                                          
                                <div class="form-group">
                                    <label class="control-label col-lg-3" for="autosize">Banner Text3</label>
                                    <div class="col-lg-9">
                                    <input type="text" id="bannner_subtxt3" name="bannner_subtxt3" class="form-control" value="<?php echo $sitesettings->bannner_subtxt3;?>"/>
    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3" for="autosize">How It Heading1</label>
                                    <div class="col-lg-9">
                                     <input type="text" id="howit_heading1" name="howit_heading1" class="form-control" value="<?php echo $sitesettings->howit_heading1;?>"/>
    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3" for="autosize">How It Heading1 Text</label>
                                    <div class="col-lg-9">
                                        <textarea id="howit_text1" name="howit_text1" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 200px;"><?php echo $sitesettings->howit_text1;?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3" for="autosize">How It Heading2</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="howit_heading2" name="howit_heading2" class="form-control" value="<?php echo $sitesettings->howit_heading2;?>"/>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-lg-3" for="autosize">How It Heading2 Text</label>
                                    <div class="col-lg-9">
                                        <textarea id="howit_text2" name="howit_text2" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 200px;"><?php echo $sitesettings->howit_text2;?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3" for="autosize">How It Heading3</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="howit_heading3" name="howit_heading3" class="form-control" value="<?php echo $sitesettings->howit_heading3;?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3" for="autosize">How It Heading3 Text</label>
                                    <div class="col-lg-9">
                                        <textarea id="howit_text3" name="howit_text3" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 200px;"><?php echo $sitesettings->howit_text3;?></textarea>
                                    </div>
                                </div>
                                <label class="control-label col-lg-3"></label>
                                <div class="col-lg-9" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Update Home Content" class="btn btn-primary" />
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