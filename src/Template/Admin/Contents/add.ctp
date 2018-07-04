<!--<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Runs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Addresses'), ['controller' => 'Addresses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Address'), ['controller' => 'Addresses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
    </ul>
</nav>-->

<?php echo $this->Html->script('ckeditor/ckeditor.js') ?>
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
                                <?= $this->Form->create($run) ?>
                                <fieldset>
                                    <legend><?= __('Add Run') ?></legend>
                                    <?php
                                        echo '<div class="form-group">'.$this->Form->input('run_name', array('class'=>'form-control')).'</div>';
                                        echo '<div class="form-group">'.$this->Form->input('run_no', array('class'=>'form-control')).'</div>';
                                    ?>
                                </fieldset>

                                <fieldset>
                                    <legend><?= __('CMS Page') ?></legend>
                                    <textarea class="form-control ckeditor" id="editor1" rows="6" name="content"></textarea>
                                </fieldset>

                                <?= $this->Form->button(__('Submit')) ?>
                                <?= $this->Form->end() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

