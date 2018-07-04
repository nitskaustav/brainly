<script>
	 $(document).ready(function () {
		 $('#dataTables-example').dataTable();
	 });
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>



<div id="content">
    <div class="inner">
      <div class="row">
        <div class="col-sm-6">
          <h2> General User </h2>
              
        </div>
        <div class="col-sm-6">
        
		    
		      
             
         
      
               
        </div>
      </div>
      <hr />
	  <?php echo  $this->Flash->render('success') ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-primary">
		 
		  <?php echo  $this->Flash->render('positive') ?>
            <div class="panel-heading">General User List
              
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>City</th>
                      <th width="100px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                   $i=0;                    
                    if($g_user):?>
					 <?php foreach ($g_user as $val): ?>
                    <tr <?php if($i & 1){ ?>class="success"<?php } else { ?>class="warning"<?php } ?>>
                      <td><?php echo $val->name?></td>
                      <td ><?php echo $val->email?></td>
                      <td><?php echo $val->phone?></td>
                       <td><?php echo $val->city?></td>
                      
                      <td class="center">

						
<?php echo $this->Html->link('', '/admin/users/generaluseredit/'.$val->id, ['data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Edit User','class' => 'icon-edit', 'target' => '_self']);?>
                      
                      
                  <?php echo  $this->Form->postLink(__(''), ['action' => 'generaluserdelete', $val->id], ['confirm' => __('Are you sure you want to delete # {0}?', $val->id),'data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Delete User','class' => 'icon-remove']) ?>
                      <?php                      
                      $i++;  endforeach; ?>
					  </td>
                    </tr>
                    <?php endif;  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>