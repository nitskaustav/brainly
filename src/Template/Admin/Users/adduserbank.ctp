
<div id="content">
    <div class="inner">
      <div class="row">
        <div class="col-lg-12">
          <h1 > Bank Data Entry User </h1>
        </div>
      </div>
      <hr />
	  <?php echo  $this->Flash->render('success') ?>
	  <?php echo  $this->Flash->render('error') ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="box">
            <header>
              <div class="icons"><i class="icon-th-large"></i></div>
              <h5>Add Bank Data Entry User</h5>
              <div class="toolbar">
                <ul class="nav">
                  <li style="margin-right:15px">
                    <div class="btn-group"> 
                      
                      <a href="<?php echo $this->Url->build(["controller" => "Users","action" => "listuserbank"]);?>"><button class="btn btn-xs btn-success close-box">
                      <i class="icon-list"></i>List Bank Data Entry User</button></a>
                    </div>
                  </li>
                
                </ul>
              </div>
            </header>
            <div id="collapseOne" class="accordion-body collapse in body">
              <div class="col-sm-6">
                  
                  <div class="row">
				  <?php echo $this->Form->create($user,['class' => 'form-horizontal', 'id' => 'admin-validate']);?>
                      
                        <input type="hidden" name="active" id="active" value="1" />
                        
                        <input type="hidden" name="type" value="bankadmin"/>             
                        <input type="hidden" name="dataentry" value="yes"/>
						<input type="hidden" name="provider_id" value="<?php echo $this->request->Session()->read('Auth.User.id')?>"/> 						
						<div class="form-group">
                          <label class="control-label col-lg-4">Username</label>
                          <div class="col-lg-8">
                                 <input type="text" id="username" name="username" class="form-control" value=""/>
                          </div>
                        </div>
                      
                        <div class="form-group">
                          <label class="control-label col-lg-4">Password</label>
                          <div class="col-lg-8">
                                 <input type="password" id="password" name="password" class="form-control" value=""/>
                          </div>
                        </div>
                        
   
                              
                    	
                        <div class="form-actions no-margin-bottom" style="text-align:center;">
                          <input type="submit" name="submit" value="Add Bank User" class="btn btn-primary" />
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