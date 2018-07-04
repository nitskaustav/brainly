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
    function deleteConfirm(){
        var x = window.confirm("Are you sure you want to delete this?")
        if (x){
            return true;
        } else {
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
                <h1 > User List </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5> User List</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group" style=" margin-top: 8px">
                                    <?php if (!empty($searchheadadm)) { ?>
                                    <div style="float: left; padding:7px 2px !important;"> 
                                    <a href="<?php echo $this->Url->build(["action" => "listdoctor"]); ?>/all"> All User </a>
                                    </div>
                                    <?php } ?>
                                    </div>
                                </li>                               
                                

                                
                                <li style="margin-right:15px">
                                    <div class="btn-group" style=" margin-top: 8px">
                                        <a href="<?php echo $this->Url->build(["action" => "adddoctor"]); ?>"> Add User </a>|
                                        <a href="javascript:void(0)" onclick="deleteConfirm();"> Delete All </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </header>
                    <?php //echo $this->Form->create('', ['class' => 'form-horizontal', 'id' => 'admsearch-validate']); ?>
                    <div class="icons"></div>
<!--                    <div class="toolbar" style=" margin-right: 50px">
                        <div class="form-group" style=" margin-top: 15px;">
                            <div style="float: left; padding: 7px 40px;">  

                                <?php if (!empty($searchheadadm)) { ?>
                                    <input type="text" name="searchheadadm" id="searchheadadm" style="width: 500px" value="<?php echo $searchheadadm; ?>" placeholder="Search"/>
                                <?php } else { ?>
                                    <input type="text" name="searchheadadm" id="searchheadadm" style="width: 500px" placeholder="Search" value=""/>
                                <?php } ?>                                    
                            </div>
                            <div style="float: left; padding:7px 2px !important;"> <input type="submit" name="submit" value="Search" class="btn btn-success btn-sm btn-flat" /> </div>
                            
                        </div>
                    </div>-->
                    <?php //echo $this->Form->end(); ?>
                    
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
                                                        <th><?php echo $this->Paginator->sort('email') ?></th>
                                                        <th><?php echo $this->Paginator->sort('status') ?></th>
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
                                                            <td><?php echo h($doct->email) ?></td>
                                                            <?php if ($doct->is_active == 1) { ?>
                                                                <td style="color: green"><?php echo h('Active') ?></td>
                                                            <?php } else if ($doct->is_active == 0) { ?>
                                                                <td style="color: red"><?php echo h('Suspended') ?></td>
                                                            <?php } ?>   
                                                           
                                                            <td class="actions">
                                                                <?php //echo $this->Html->link(__('View'), ['action' => 'view', $doct->id])  ?>
                                                                <?php //echo $this->Html->link(__('Edit'), ['action' => 'edit', $doct->id]) ?> 
                                                                <?php //echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $doct->id], ['confirm' => __('Are you sure you want to delete # {0}?', $doct->first_name." ".$doct->last_name)]) ?>
                                                                <a href="<?php echo $this->Url->build(["action" => "doctorview", $doct->id]); ?>"> <button class="btn-btn-info btn-xs"><i class="icon-eye-open"></i> View</button> </a>
                                                                <a href="<?php echo $this->Url->build(["action" => "editdoctor", $doct->id]); ?>"> <button class="btn btn-primary btn-xs"><i class="icon-pencil icon-white"></i> Edit</button>  </a>
                                                                <a href="<?php echo $this->Url->build(["action" => "doctordelete", $doct->id]); ?>" onclick="return confirm('Are you sure you want to delete?');"> <button class="btn btn-danger btn-xs"><i class="icon-remove icon-white"></i> Delete</button> </a>                
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
<script language="javascript" type="text/javascript">
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
              $.post("<?php echo $this->request->webroot;?>admin/users/balk_delete",data,function(result){
              if(result.trim()==1)
              {
              alert("All users has been deleted");    
              location.reload();
              }

             });
              
              
             } 
           
       }
       else
       {
           alert("Please select At least One");
       }
        
        

    }
</script>
