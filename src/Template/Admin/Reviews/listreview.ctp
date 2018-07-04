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
                <h1 > Review List </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5> Review List</h5>
                        <div class="toolbar">
                            
                        </div>
                    </header>
                    <div class="accordion-body collapse in body">
                        <div class="col-sm-12">
                            <div class="row">  
                                <?php echo $this->Form->create('Filter', array('class'=>'form-inline','type'=>'get'));?>
                                <div class="form-group">

                                  <?php echo $this->Form->input('title', array('class'=>'form-control','label'=>false,'placeholder'=>'Search By Customer Name','div'=>false,'value'=>!empty($_REQUEST['title'])?$_REQUEST['title']:'')); ?>
                                </div>
                                <div class="form-group">

                                  <?php echo $this->Form->input('sname', array('class'=>'form-control','label'=>false,'placeholder'=>'Search By Service Name','div'=>false,'value'=>!empty($_REQUEST['sname'])?$_REQUEST['sname']:'')); ?>
                                </div>
                                <div class="form-group">

                                  <?php echo $this->Form->input('location', array('class'=>'form-control','label'=>false,'placeholder'=>'Search By Location','div'=>false,'value'=>!empty($_REQUEST['location'])?$_REQUEST['location']:'')); ?>
                                </div>
                                
                                <div class="form-group">

                                     <select class="form-control" name='stype'>
                                        <option value=''>--Select Service Type--</option>
                                        <?php foreach($stypes as $t){?>
                                        <option value='<?php echo $t->id ?>'><?php echo $t->type_name?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">

                                     <select class="form-control" name='status'>
                                        <option value=''>--Select Status--</option>
                                        <option value='1' >Approved</option>
                                        <option value='0' >Suspended</option>
                                        
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success" style='margin-top:7px;margin-bottom:6px;'>Search</button>


                                <?php echo $this->Form->end();?>
                            </div>
                            
                          <h4>Total Review: <?php echo $countreview;?></h4> 
<!--                          <h4>Total verified Review: <?php echo $countreview_verified;?></h4>
                          <h4>Total non verified Review: <?php echo $countreview_nonverified;?></h4>-->
                        </div>
                        <div>
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
                                                       <th><?php echo $this->Paginator->sort('customer name') ?></th>
                                                       
                                                       <th><?php echo $this->Paginator->sort('service name') ?></th>
                                                       <th><?php echo $this->Paginator->sort('service provider name') ?></th>
                                                       <th><?php echo $this->Paginator->sort('review') ?></th>
                                                       <th><?php echo $this->Paginator->sort('rating') ?></th>
                                                       <th><?php echo $this->Paginator->sort('post date') ?></th>
                                                       
                                                       <th><?php echo $this->Paginator->sort('is_active','Status') ?></th>
                                                       <th class="actions"><?php echo __('Actions') ?></th>
                                                   </tr>
                                               </thead>
                                               <tbody>
                                           <?php $i = 1; foreach ($service as $dt): ?>
                                                   <tr>
                                                       <td><?php echo $this->Number->format($i) ?></td>
                                                       <td><?php echo h($dt['user']['full_name']) ?></td>
                                                       
                                                       <td><?php echo h($dt['service']['service_name']) ?></td>
                                                       <td><?php echo h($dt['company']['full_name']) ?></td> 
                                                        <td><?php echo h($dt->review) ?></td>
                                                        <td><?php echo h($dt->rating) ?></td>
                                                        <td><?php echo h($dt->post_date) ?></td>                                 
                                                         <?php if ($dt->is_active == 1) { ?>
                                                            <td style="color: green"><?php echo h('Approved') ?></td>
                                                        <?php } else if ($dt->is_active == 0) { ?>
                                                            <td style="color: red"><?php echo h('Not approve') ?></td>
                                                        <?php } ?> 
                                                       <td class="actions">
                                                  
                                                           <a href="<?php echo $this->Url->build(["action" => "reviewview", $dt->id]); ?>"> <button class="btn-btn-info btn-xs"><i class="icon-eye-open"></i> View</button> </a>
                                                           <a href="<?php echo $this->Url->build(["action" => "editreview", $dt->id]); ?>"> <button class="btn btn-primary btn-xs"><i class="icon-pencil icon-white"></i> Edit</button>  </a>
                                                           <a href="<?php echo $this->Url->build(["action" => "reviewdelete", $dt->id]); ?>" onclick="return confirm('Are you sure you want to delete?');"> <button class="btn btn-danger btn-xs"><i class="icon-remove icon-white"></i> Delete</button> </a>                
                                                            <?php if ($dt->is_active == 1) { ?>
                                                                <a href="<?php echo $this->Url->build(["action" => "reviewstatus", $dt->id, '0']); ?>"> <button class="btn btn-info btn-xs"><i class="icon-thumbs-down"></i> Suspend</button> </a>
                                                            <?php } else if ($dt->is_active == 0) { ?>
                                                                <a href="<?php echo $this->Url->build(["action" => "reviewstatus", $dt->id, '1']); ?>"> <button class="btn btn-success btn-xs"><i class="icon-thumbs-up"></i> Approve</button> </a>
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