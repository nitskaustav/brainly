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

<!--PAGE CONTENT -->
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Lab Technician List</h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5> Lab Technician List</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group" style=" margin-top: 8px">
                                    <?php if (!empty($searchheadadm)) { ?>
                                    <div style="float: left; padding:7px 2px !important;"> 
                                    <a href="<?php echo $this->Url->build(["action" => "listdoctor"]); ?>/all"> All Doctor </a>
                                    </div>
                                    <?php } ?>
                                    </div>
                                </li>                               
                                

                                
                                <li style="margin-right:15px">
                                    <div class="btn-group" style=" margin-top: 8px">
                                        <a href="<?php echo $this->Url->build(["action" => "addpharmacist"]); ?>"> Add Lab Technician </a>|
                                        <a href="javascript:void(0)" onclick="deleteConfirm()"> Delete All </a>

                                    </div>
                                </li>
                            </ul>
                        </div>
                    </header>
<!--                   <div class="accordion-body collapse in body">
                        <div class="col-sm-12">
                            <div class="row">  
                                <?php //echo $this->Form->create('Filter', array('class'=>'form-inline','type'=>'get'));?>
                                <div class="form-group">

                                  <?php echo $this->Form->input('title', array('class'=>'form-control','label'=>false,'placeholder'=>'Search By Name or Email','div'=>false,'value'=>!empty($_REQUEST['title'])?$_REQUEST['title']:'')); ?>
                                </div>
                                <button type="submit" class="btn btn-success" style='margin-top:7px;margin-bottom:6px;'>Search</button>
                                <button type="button" class="btn btn-success" style="margin-top:7px;margin-bottom:6px;" onclick="resetForm()">Clear Search</button>
                                <?php //echo $this->Form->end();?>
                             <button type="button" class="btn btn-danger" style="margin-top:7px;margin-bottom:6px;" onclick="deleteConfirm()">Delete All</button>

                            </div>
                        </div>
                    </div>-->
                    
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-12">
                            <div class="row">                               
                                <div class="form-group"> 
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" id="checkall"></th>
                                                        <th><?php echo $this->Paginator->sort('id') ?></th>
                                                        <th><?php echo $this->Paginator->sort('name') ?></th>
                                                        <th><?php echo $this->Paginator->sort('liesence','License') ?></th>
                                                        <th><?php echo $this->Paginator->sort('category_id','Category') ?></th>
                                                        <th><?php echo $this->Paginator->sort('email') ?></th>
                                                        <th><?php echo $this->Paginator->sort('status') ?></th>
                                                         <th><?php echo $this->Paginator->sort('subscription_start','Subscription Start') ?></th>
                                                        <th><?php echo $this->Paginator->sort('subscription_end','Subscription End') ?></th> 
                                                        <th class="actions"><?php echo __('Actions') ?></th>
                                                    </tr>
                                                </thead>
                                                
                                                
                                                <tbody>
                                                    
<?php $i = 1;
foreach ($user as $doct): ?>
                                                        <tr>
                                                            <td><input type="checkbox" name="userid[]" class="userid" value="<?php echo $doct->id; ?>"></td>
                                                            <td><?php echo $this->Number->format($i) ?></td>
                                                            <td><?php echo h($doct->first_name . " " . $doct->last_name) ?></td>
                                                            <td><?php echo h($doct->license_no) ?></td>
                                                            <td><?php echo h($doct->Labcategories["name"]) ?></td>
                                                            <td><?php echo h($doct->email) ?></td>
                                                            <?php if ($doct->is_active == 1) { ?>
                                                                <td style="color: green"><?php echo h('Active') ?></td>
                                                            <?php } else if ($doct->is_active == 0) { ?>
                                                                <td style="color: red"><?php echo h('Suspended') ?></td>
                                                            <?php } ?>   
                                                             <td><?php echo date("d/m/Y",strtotime($doct->subscription_start)); ?></td>
                                                            <td><?php echo date("d/m/Y",strtotime($doct->subscription_end)); ?></td>
                                                            <td class="actions">
                                                                <?php //echo $this->Html->link(__('View'), ['action' => 'view', $doct->id])  ?>
                                                                <?php //echo $this->Html->link(__('Edit'), ['action' => 'edit', $doct->id]) ?> 
                                                                <?php //echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $doct->id], ['confirm' => __('Are you sure you want to delete # {0}?', $doct->first_name." ".$doct->last_name)]) ?>
<!--                                                                <a href="<?php echo $this->Url->build(["action" => "doctorview", $doct->id]); ?>"> <button class="btn-btn-info btn-xs"><i class="icon-eye-open"></i> View</button> </a>-->
                                                                <a href="<?php echo $this->Url->build(["action" => "editpharmacist", $doct->id]); ?>"> <button class="btn btn-primary btn-xs"><i class="icon-pencil icon-white"></i> Edit</button>  </a>
                                                                <a href="<?php echo $this->Url->build(["action" => "labdelete", $doct->id]); ?>" onclick="return confirm('Are you sure you want to delete?');"> <button class="btn btn-danger btn-xs"><i class="icon-remove icon-white"></i> Delete</button> </a>                
                                                                <?php if ($doct->is_active == 1) { ?>
                                                                    <a href="<?php echo $this->Url->build(["action" => "docstatus", $doct->id, '0']); ?>"> <button class="btn btn-info btn-xs"><i class="icon-thumbs-down"></i> Suspend</button> </a>
                                                                <?php } else if ($doct->is_active == 0) { ?>
                                                                    <a href="<?php echo $this->Url->build(["action" => "docstatus", $doct->id, '1']); ?>"> <button class="btn btn-success btn-xs"><i class="icon-thumbs-up"></i> Active</button> </a>
                                                                <?php } ?>

                                                            </td>                
                                                        </tr>
                                                        <?php $i++;
                                                    endforeach; ?>
                                                </tbody>
                                            </table>
                                            <div class="paginator">
                                                <ul class="pagination">
                                                    <?php echo $this->Paginator->prev('< ' . __('previous')) ?>
                                                    <?php echo $this->Paginator->numbers() ?>
                                                    <?php echo $this->Paginator->next(__('next') . ' >') ?>
                                                </ul>
                                                <p><?php //echo $this->Paginator->counter()  ?></p>
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
<script>
function resetForm()
{
    window.location.href="<?php echo $this->Url->build(["action" => "index"]); ?>";

  
}
$(document).ready(function(){
$("#checkall").click(function(){
if($(this).is(':checked'))    
{
    $(".userid").prop("checked",true);
}
else
{
    $(".userid").prop("checked",false);
}
});    
})



</script>
<script language="javascript" type="text/javascript">
    function deleteConfirm(){
       if($(".userid:checked").length>0)
       {
            var selectusers=[];
            var x = window.confirm("Are you sure you want to delete this?")
             if (x){
             $(".userid").each(function(){
                if($(this).is(':checked'))
                {
                selectusers.push($(this).val());
                }
              }); 
              var data={users:selectusers};
              $.post("<?php echo $this->request->webroot;?>admin/users/balk_delete",data,function(){
              alert("All users has been deleted");    
              location.reload();

             });
              
              
             } 
           
       }
       else
       {
           alert("Please select At least One");
       }
        
        

    }
</script>