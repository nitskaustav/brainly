<?php ?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1> Send Email</h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Send Email</h5>
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
				
                                <form method="post" class="form-horizontal" action="<?php echo $this->Url->build(["controller" => "Services", "action" => "sendemail"]); ?>">
                                
                                
                                
                                <div class="form-block">

                                 <div class="form-group">
                                    <label class="control-label col-lg-4">Subscribers</label>
                                    <div class="col-lg-8">
                                        <input type="radio" required="" name="subscriber_number" value="1">All
<!--                                        <input type="radio">Custom Users-->
                                    </div>
                                </div>                               

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Mail Text</label>
                                    <div class="col-lg-8">
                                        <textarea class="form-control" name="mail_text"></textarea>
                                    </div>
                                </div>
                                
                                
                              
                                
                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Send mail" class="btn btn-primary" />
                                </div>
                                
                            </div>
                                    </form>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>