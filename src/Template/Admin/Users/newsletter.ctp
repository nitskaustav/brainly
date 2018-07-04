<?php echo $this->Html->script('/plugins/dataTables/jquery.dataTables.js')?>
<?php echo $this->Html->script('/plugins/dataTables/dataTables.bootstrap.js')?>
<script>
	 $(document).ready(function () {
		 $('#dataTables-example').dataTable();
	 });
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});
</script>

<script language="javascript" type="text/javascript">
function deleteConfirm() {
	var x=window.confirm("Are you sure you want to delete this?");
	if (x) {
		return true;
	} else {
		return false;
	}
	return false;
}
</script>

<div id="content">
    <div class="inner">
      <div class="row">
        <div class="col-lg-12">
          <h2> Newsletter List </h2>
        </div>
      </div>
      <hr />
	  <?php echo  $this->Flash->render('success') ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading"><h5>Newsletter List</h5></div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Email</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                    <?php
					
                     if($newsletter){?>
					<?php foreach($newsletter as $val){ ?>
                    <tr class="odd gradeX">
                      <td><?php echo $val->name?></td>
                      <td><?php echo $val->phone?></td>
                      <td><?php echo $val->email?></td>
                      
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