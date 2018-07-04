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
                                    <legend><?php echo __('Edit Doctor') ?></legend>
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