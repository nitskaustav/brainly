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
                <h1 >  Model List </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>  Model List</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group" style=" margin-top: 8px">
                                        <a href="<?php echo $this->Url->build(["action" => "addmodel/"]); ?>"> <button class="btn btn-info btn-xs"><i class="icon-cogs icon-white"></i> Add Model</button>  </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </header>
                    <div class="accordion-body collapse in body">

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

                                                        <th><?php echo $this->Paginator->sort('Model name') ?></th>                       


                                                        <th><?php echo $this->Paginator->sort('is_active', 'Status') ?></th>
                                                        <th class="actions"><?php echo __('Actions') ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php //pr($service); ?>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($service as $dt):
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $this->Number->format($i) ?></td>


                                                            <td><?php echo h($dt->model_name) ?></td>

                                                            <?php if ($dt->status == 1) { ?>
                                                                <td style="color: green"><?php echo h('Active') ?></td>
                                                            <?php } else if ($dt->status == 0) { ?>
                                                                <td style="color: red"><?php echo h('Suspended') ?></td>
    <?php } ?> 
                                                            <td class="actions">


                                                                <a href="<?php echo $this->Url->build(["action" => "editmodel", $dt->id]); ?>"> <button class="btn btn-primary btn-xs"><i class="icon-pencil icon-white"></i> Edit</button>  </a>
                                                                <a href="<?php echo $this->Url->build(["action" => "modeldelete", $dt->id]); ?>" onclick="return deleteConfirm('Are you sure you want to delete?');"> <button class="btn btn-danger btn-xs"><i class="icon-remove icon-white"></i> Delete</button> </a>                
                                                                <?php if ($dt->status == 1) { ?>
                                                                    <a href="<?php echo $this->Url->build(["action" => "modelstatus", $dt->id, '0']); ?>"> <button class="btn btn-info btn-xs"><i class="icon-thumbs-down"></i> Suspend</button> </a>
                                                                <?php } else if ($dt->status == 0) { ?>
                                                                    <a href="<?php echo $this->Url->build(["action" => "modelstatus", $dt->id, '1']); ?>"> <button class="btn btn-success btn-xs"><i class="icon-thumbs-up"></i> Active</button> </a>
    <?php } ?>

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
                                                <p><?php //echo $this->Paginator->counter()    ?></p>
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