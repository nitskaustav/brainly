<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Edit Admin    </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Edit Admin</h5>
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
				  <?php echo $this->Form->create($doctor,['class' => 'form-horizontal', 'id' => 'user-validate']);?>

                                <input type="hidden" name="active" id="active" value="1" />

                                <div class="form-group">
                                    <label class="control-label col-lg-4">First Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo $this->request->data['first_name'] ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Last Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo $this->request->data['last_name'] ?>"/>
                                    </div>
                                </div>
 
                                                             

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Username</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="username" name="username" readonly="readonly" class="form-control" value="<?php echo $this->request->data['username'] ?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Email</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="email" name="email" class="form-control" value="<?php echo $this->request->data['email'] ?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Password</label>
                                    <div class="col-lg-8">
                                        <input type="password" id="epassword" name="password" class="form-control" value=""/>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Active</label>
                                    <div class="col-lg-2">
                                        <input type="checkbox" id="status" name="status" class="form-control" value="1" <?php echo (!empty($this->request->data['status'])?'checked':''); ?>/>
                                    </div>
                                </div>
                                

                                
                                                                 

                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Edit Admin" class="btn btn-primary" />
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


<!--
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">

            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                  <div class="box">
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-6">
                            <div class="row">
                                <?php //echo $this->Form->create($doctor) ?>
                                <?php echo $this->Form->create($doctor,['class' => 'form-horizontal', 'id' => 'admin-validate']);?>
                                <fieldset>
                                    <legend><?php echo __('Add Doctor') ?></legend>
                                    <?php
                                        echo '<div class="form-group">'.$this->Form->input('first_name', array('class'=>'form-control')).'</div>';
                                        echo '<div class="form-group">'.$this->Form->input('last_name', array('class'=>'form-control')).'</div>';
                                        echo '<div class="form-group">'.$this->Form->input('phone', array('class'=>'form-control')).'</div>';
                                        echo '<div class="form-group">'.$this->Form->input('username', array('class'=>'form-control','readonly')).'</div>';
                                        echo '<div class="form-group">'.$this->Form->input('password', array('class'=>'form-control','value'=>'')).'</div>';
                                        echo '<div class="form-group">'.$this->Form->input('email', array('class'=>'form-control','readonly')).'</div>';
                                    ?>
                                </fieldset>

                                <fieldset>
                                    <button type="submit" class="btn btn-primary" style="margin-top: 15px">Edit Doctor</button>
                                </fieldset>


                                <?php //echo $this->Form->button(__('Edit Doctor')) ?>
                                <?php echo $this->Form->end() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->