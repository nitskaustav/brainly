<!--PAGE CONTENT -->
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Admin List </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5> Admin List</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group" style=" margin-top: 8px">
                                        <a href="<?php echo $this->Url->build(["action" => "add"]); ?>"> <button class="btn btn-info btn-xs"><i class="icon-cogs icon-white"></i> Add Admin </button>  </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-12">
                            <div class="row">                               
                                <div class="form-group"> 
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $this->Paginator->sort('id') ?></th>
                                                        <th><?php echo $this->Paginator->sort('name') ?></th>
                                                        <th><?php echo $this->Paginator->sort('email') ?></th>
                                                        <th><?php echo $this->Paginator->sort('username') ?></th>
                                                        <th><?php echo $this->Paginator->sort('created_on') ?></th>
                                                        <th><?php echo $this->Paginator->sort('modified_on') ?></th>
                                                        <th><?php echo $this->Paginator->sort('status') ?></th>
                                                        <th class="actions"><?php echo __('Actions') ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                            <?php $i =1; foreach ($doctors as $doct): ?>
                                                    <tr>
                                                        <td><?php echo $this->Number->format($i) ?></td>
                                                        <td><?php echo h($doct->first_name." ".$doct->last_name) ?></td>
                                                        <td><?php echo h($doct->email) ?></td>
                                                        <td><?php echo h($doct->username) ?></td>
                                                        <td><?php echo h($doct->created) ?></td>
                                                        <td><?php echo h($doct->modified) ?></td>
                                                        <th><?php echo (!empty($doct->status)?'Active':'Inactive'); ?></th>
                                                        <td class="actions">
                                                    <?php //echo $this->Html->link(__('View'), ['action' => 'view', $doct->id]) ?>
                                                    <?php //echo $this->Html->link(__('Edit'), ['action' => 'edit', $doct->id]) ?> 
                                                    <?php //echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $doct->id], ['confirm' => __('Are you sure you want to delete # {0}?', $doct->first_name." ".$doct->last_name)]) ?>
<!--                                                            <a href="<?php echo $this->Url->build(["action" => "view", $doct->id]); ?>"> <button class="btn-btn-info btn-xs"><i class="icon-eye-open"></i> View</button> </a>-->
                                                            <a href="<?php echo $this->Url->build(["action" => "edit", $doct->id]); ?>"> <button class="btn btn-primary btn-xs"><i class="icon-pencil icon-white"></i> Edit</button>  </a>
                                                            <?php
                                                            if($doct->id!=1)
                                                            {
                                                            ?>
                                                            <a href="<?php echo $this->Url->build(["action" => "delete", $doct->id]); ?>" onclick="return confirm('Are you sure you want to delete this admin?');"> <button class="btn btn-danger btn-xs"><i class="icon-remove icon-white"></i> Delete</button> </a>               
                                                            <?php  if ($doct->status == 1) { ?>
                                                                <a href="<?php echo $this->Url->build(["action" => "docstatus", $doct->id, '0']); ?>"> <button class="btn btn-info btn-xs"><i class="icon-thumbs-down"></i> Suspend</button> </a>
                                                            <?php } else if ($doct->status == 0) { ?>
                                                                <a href="<?php echo $this->Url->build(["action" => "docstatus", $doct->id, '1']); ?>"> <button class="btn btn-success btn-xs"><i class="icon-thumbs-up"></i> Active</button> </a>
                                                            <?php }  ?>
                                                            <?php }?>

                                                        </td>                
                                                    </tr>
                                            <?php $i++; endforeach; ?>
                                                </tbody>
                                            </table>
                                            <div class="paginator">
                                                <ul class="pagination"> 
                                            <?php echo $this->Paginator->prev('< ' . __('previous')) ?>
                                            <?php echo $this->Paginator->numbers() ?>
                                            <?php echo $this->Paginator->next(__('next') . ' >') ?>
                                                </ul>
                                                <p><?php //echo $this->Paginator->counter() ?></p>
                                            </div>
                                        </div>  
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>        
     </div>
</div>
<!--END PAGE CONTENT -->