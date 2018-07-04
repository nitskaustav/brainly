<?php
	// echo "<pre>";
	// print_r($order_details);exit;
?>

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
                <h1> Order List </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Order List</h5>
                        <div class="toolbar">
                            
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
           <th><?php echo $this->Paginator->sort('User Name') ?></th>
           <th><?php echo $this->Paginator->sort('Order Date') ?></th>
           <th><?php echo $this->Paginator->sort('Total price') ?></th>
           <th><?php echo $this->Paginator->sort('Payment Mode') ?></th>
           <th><?php echo $this->Paginator->sort('Shipping Address ') ?></th>
           <th><?php echo $this->Paginator->sort('Order Status') ?></th>
           <th>Action</th>
       </tr>
   </thead>
   <tbody>
<?php $i = 1; foreach ($order_details as $order_data): ?>
       <tr>
           <td><?php echo $this->Number->format($i) ?></td>
           <td><?php echo $order_data->user->first_name." ".$order_data->user->last_name ?></td>
           <td><?php echo $order_data->order_date; ?></td>
           <td>$<?php echo $order_data->total_price; ?></td>
           <td><?php echo $order_data->payment_mode; ?></td>
           <td><?php echo $order_data->shipping_address; ?></td>
           <td><?php echo $order_data->order_status; ?></td>
           <td><a href="<?php echo $this->request->webroot; ?>admin/products/listorderdetails/<?php echo $order_data->id; ?>">Details</a></td>
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