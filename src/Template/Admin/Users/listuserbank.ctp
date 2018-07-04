<?php echo $this->Html->script('/plugins/dataTables/jquery.dataTables.js')?>
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
var x=window.confirm("Are you sure you want to delete this?")
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

<div id="content">
    <div class="inner">
      <div class="row">
        <div class="col-lg-12">
          <h2> Bank Data Entry User List </h2>
        </div>
      </div>
      <hr />
	  <?php echo  $this->Flash->render('success') ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading"><h5>Bank Data Entry User List</h5></div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                    <tr>
                      <th>Username</th>
                      <th width="100px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                     if($user){?>
					<?php foreach($user as $val){?>
                    <tr class="odd gradeX">
                      <td><?php echo $val->username?></td>
					 
                      <td class="center">
					  
                      <?php echo  $this->Form->postLink(__(''), ['action' => 'bankuserentrydelete', $val->id], ['confirm' => __('Are you sure you want to delete # {0}?', $val->id),'data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Delete Bank User','class' => 'icon-remove']) ?>
					  
					  <?php
					  if($val->is_active==1){?>
					  <?php echo  $this->Form->postLink(__(''), ['action' => 'changestatus', $val->id , 0], ['confirm' => __('Are you sure you want to change status # {0}?', $val->id),'data-toggle'=>'tooltip','data-placement'=>'top','title'=>'want to Suspend Now?','class' => 'icon-thumbs-up']) ?>
					  <?php
					  }else{
						  ?>
					   <?php echo  $this->Form->postLink(__(''), ['action' => 'changestatus', $val->id , 1], ['confirm' => __('Are you sure you want to change status # {0}?', $val->id),'data-toggle'=>'tooltip','data-placement'=>'top','title'=>'want to Active Now?','class' => 'icon-thumbs-down-alt']) ?>	  
						  <?php
					  }
					  ?>
					  </td>
                    </tr>
					 <?php }} ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>