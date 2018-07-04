<?php
	// echo "<pre>";
	// print_r($order_details);exit;
foreach ($order_details as $order_data){
  $shipping_address = $order_data->shipping_address;
  $billing_address = $order_data->billing_address;
  $order_status = $order_data->order_status;
}
$shipping_address_array = explode(",", $shipping_address);
$billing_address_array = explode(",",$billing_address);

foreach($shipping_address_array as $shipaddress){
  $ship .= $shipaddress."<br>";
}
foreach($billing_address_array as $billaddress){
  $bill .= $billaddress."<br>";
}

$pending_status = '';
$ship_status = '';
$deliver_status = '';

if($order_status == 'Pending')
  $pending_status = ' selected';
elseif($order_status == 'Shipped')
  $ship_status = ' selected';
elseif($order_status == 'Delivered')
  $deliver_status = ' selected';
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
                <h1> Order Details </h1>
            </div>
        </div>
        <hr />

        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Order Details </h5>
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
<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
  <tr>
    <th>Shipping Address</th>
    <th>Billing Address</th>
  </tr>
  <tr>
    <td><?php echo "<b>".$ship."<b>"; ?></td>
    <td><?php echo "<b>".$bill."<b>"; ?></td>
  </tr>
  
</table>
<br>
<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
  <tr>
    <td>
      Order Status:
      <select>
        <option value="Pending" <?php echo $pending_status ?>>Pending</option>
        <option value="Shipped" <?php echo $ship_status; ?>>Shipped</option>
        <option value="Delivered" <?php echo $deliver_status; ?>>Delivered</option>
      </select>
    </td>
  </tr>
</table>
<br>
<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover">
   <thead>
       <tr>
           <th><?php echo $this->Paginator->sort('Id') ?></th>
           <th><?php echo $this->Paginator->sort('Image') ?></th>
           <th><?php echo $this->Paginator->sort('Product Name') ?></th>
           <th><?php echo $this->Paginator->sort('Quantity') ?></th>
           <th><?php echo $this->Paginator->sort('Price') ?></th>
       </tr>
   </thead>
   <tbody>
<?php $i = 1; foreach ($order_details as $order_data){ 
				$order_data_array = $order_data->order_details;
				//echo "<pre>";print_r($order_data_array);die;
				foreach($order_data_array as $order_detailsdata){
					$upload = $order_detailsdata->gear->upload;
					//$upload_array = explode(",",$upload);

          $filename = WWW_ROOT.'gear_img/'.$upload;

          if(!file_exists($filename) || $upload == ''){
             $upload = 'no-image.png';
          }

          $total_price = $order_detailsdata->price*$order_detailsdata->quantity;
          $sub_total += $total_price;


	?>
       <tr>
           <td><?php echo $this->Number->format($i) ?></td>
           <td><img src="<?php echo $this->Url->build('/gear_img/'.$upload); ?>" width="140px" height="80px" /></td>
           <td><?php echo $order_detailsdata->gear->product_name; ?></td>
           <td><?php echo $order_detailsdata->quantity; ?></td>
           <td>$<?php echo $total_price; ?></td>
       </tr>
<?php $i++; } } ?>
        <tr>
          <td colspan="4"></td>
          <td>$<?php echo $sub_total;  ?></td>
        </tr>
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