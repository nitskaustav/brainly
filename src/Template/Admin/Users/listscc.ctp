<?php

echo $this->Html->script('/plugins/dataTables/jquery.dataTables.js')?>
<?php echo $this->Html->script('/plugins/dataTables/dataTables.bootstrap.js')?>
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
                <h1 > Venue List </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5> Venue List</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group" style=" margin-top: 8px">
                                        <a href="<?php echo $this->Url->build(["action" => "addservice/", $id]); ?>"> <button class="btn btn-info btn-xs"><i class="icon-cogs icon-white"></i> Add Venue </button>  </a>
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
                                                       <th><?php echo $this->Paginator->sort('venue name') ?></th>
                                                       
                                                       <th><?php echo $this->Paginator->sort('address') ?></th>
                                                       <th><?php echo $this->Paginator->sort('pricing') ?></th>
                                                       <th><?php echo $this->Paginator->sort('start time') ?></th>
                                                       <th><?php echo $this->Paginator->sort('is_active','Status') ?></th>
                                                       <th class="actions"><?php echo __('Actions') ?></th>
                                                   </tr>
                                               </thead>
                                               <tbody>
                                           <?php $i = 1; foreach ($service as $dt): ?>
                                                   <tr>
                                                       <td><?php echo $this->Number->format($i) ?></td>
                                                       <td><?php echo h($dt->service_name) ?></td>
                                                       
                                                       <td><?php echo h($dt->address) ?></td>
                                                         
                                                        <td><?php echo h($dt->price) ?></td>
                                                        <td><?php echo h($dt->start_time) ?></td>
                                                                                         
                                                         <?php if ($dt->is_active == 1) { ?>
                                                            <td style="color: green"><?php echo h('Active') ?></td>
                                                        <?php } else if ($dt->is_active == 0) { ?>
                                                            <td style="color: red"><?php echo h('Suspended') ?></td>
                                                        <?php } ?> 
                                                       <td class="actions">
                                                  
                                                           
                                                           <a href="<?php echo $this->Url->build(["action" => "editservice", $dt->id, $id]); ?>"> <button class="btn btn-primary btn-xs"><i class="icon-pencil icon-white"></i> Edit</button>  </a>
                                                           <a href="<?php echo $this->Url->build(["action" => "servicedelete", $dt->id,  $id]); ?>" onclick="return deleteConfirm('Are you sure you want to delete?');"> <button class="btn btn-danger btn-xs"><i class="icon-remove icon-white"></i> Delete</button> </a>                
                                                            <?php if ($dt->is_active == 1) { ?>
                                                                <a href="<?php echo $this->Url->build(["action" => "servicestatus", $dt->id, '0',$id]); ?>"> <button class="btn btn-info btn-xs"><i class="icon-thumbs-down"></i> Suspend</button> </a>
                                                            <?php } else if ($dt->is_active == 0) { ?>
                                                                <a href="<?php echo $this->Url->build(["action" => "servicestatus", $dt->id, '1',$id]); ?>"> <button class="btn btn-success btn-xs"><i class="icon-thumbs-up"></i> Active</button> </a>
                                                            <?php } ?>

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
<script>
function resetForm()
{
    window.location.href="<?php echo $this->Url->build(["action" => "index"]); ?>";

  
}
</script> 
<!--END PAGE CONTENT -->