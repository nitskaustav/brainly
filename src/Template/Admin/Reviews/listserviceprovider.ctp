<?php echo $this->Html->script('/plugins/dataTables/jquery.dataTables.js') ?>
<?php echo $this->Html->script('/plugins/dataTables/dataTables.bootstrap.js') ?>
<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script language="javascript" type="text/javascript">

    function deleteConfirm()
    {
        var x = window.confirm("Are you sure you want to delete this?")
        if (x)
        {
            return true;
        }
        else
        {
            return false;
        }
        return false;
    }
</script>


<!--PAGE CONTENT -->
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1> Sellers Awaiting Approval List </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5> Sellers Awaiting Approval List</h5>

                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group" style=" margin-top: 8px">
                                        <a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "addserviceprovider"]); ?>"> <button class="btn btn-info btn-xs"><i class="icon-cogs icon-white"></i> Add Seller </button>  </a>
                                    </div>
                                </li>
                            </ul>
                        </div>


                    </header>
                    <div class="accordion-body collapse in body">
                        <div class="col-sm-12">
                            <div class="row">  
                                <?php echo $this->Form->create('Filter', array('class' => 'form-inline', 'type' => 'get')); ?>
                                <div class="form-group">

                                    <?php echo $this->Form->input('title', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Search By Name or Email', 'div' => false, 'value' => !empty($_REQUEST['title']) ? $_REQUEST['title'] : '')); ?>
                                </div>

                                <div class="form-group">

                                    <?php echo $this->Form->input('location', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Search By Location', 'div' => false, 'value' => !empty($_REQUEST['location']) ? $_REQUEST['location'] : '')); ?>
                                </div>

                                <!--                                <div class="form-group">
                                
                                                                     <select class="form-control" name='stype'>
                                                                        <option value=''>--Select Service Type--</option>
                                <?php foreach ($stypes as $t) { ?>
                                                                                                <option value='<?php echo $t->id ?>'><?php echo $t->type_name ?></option>
                                <?php } ?>
                                                                    </select>
                                                                </div>-->

                                <button type="submit" class="btn btn-success" style='margin-top:7px;margin-bottom:6px;'>Search</button>


                                <?php echo $this->Form->end(); ?>
                            </div>
                            <div><h4><b>Total Clients: <?php echo $countprovider; ?></b></h4></div>

                        </div>
                    </div>
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
                                                        <th><?php echo $this->Paginator->sort('Seller name') ?></th>

                                                        <th><?php echo $this->Paginator->sort('email') ?></th>
                                                        <th><?php echo $this->Paginator->sort('location') ?></th>
                                                        <th><?php echo $this->Paginator->sort('created_on', 'Added') ?></th>
                                                        <th><?php echo $this->Paginator->sort('modified_on', 'Updated') ?></th>

                                                        <th class="actions"><?php echo __('Actions') ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($user as $doct):
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $this->Number->format($i) ?></td>
                                                            <td><?php echo h($doct->full_name) ?></td>

                                                            <td><?php echo h($doct->email) ?></td>

                                                            <td><?php echo h($doct->address) ?></td>

                                                            <td><?php echo $this->requestAction('admin/users/change_datetimeformat/' . strtotime($doct->created)) ?></td>
                                                            <td><?php echo $this->requestAction('admin/users/change_datetimeformat/' . strtotime($doct->modified)) ?></td>                                 
                                                            <td class="actions">

                                                                <a href="<?php echo $this->Url->build(["action" => "serviceproviderview", $doct->id]); ?>"> <button class="btn-btn-info btn-xs"><i class="icon-eye-open"></i> View</button> </a>
                                                                <a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "editserviceprovider", $doct->id]); ?>"> <button class="btn btn-primary btn-xs"><i class="icon-pencil icon-white"></i> Edit</button>  </a>
                                                                <a href="<?php echo $this->Url->build(["action" => "companydelete", $doct->id]); ?>" onclick="return confirm('Are you sure you want to delete?');"> <button class="btn btn-danger btn-xs"><i class="icon-remove icon-white"></i> Delete</button> </a>                









                                                            </td>                
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    endforeach;
                                                    ?>
                                                </tbody>
                                            </table>
                                            <div class="paginator">
                                                <ul class="pagination">
                                                    <?php echo $this->Paginator->prev('< ' . __('previous')) ?>
                                                    <?php echo $this->Paginator->numbers() ?>
                                                    <?php echo $this->Paginator->next(__('next') . ' >') ?>
                                                </ul>
                                                <p><?php //echo $this->Paginator->counter()       ?></p>
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
<script>
    function resetForm()
    {
        window.location.href = "<?php echo $this->Url->build(["action" => "index"]); ?>";


    }
</script> 
<!--END PAGE CONTENT -->