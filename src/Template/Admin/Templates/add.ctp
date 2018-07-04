<?php 
use Cake\Routing\Router; 
$price_product = array();
foreach($products as $pval) {
	$price_product[$pval->id] = array('p1'=>$pval->p1, 'p2'=>$pval->p2, 'p3'=>$pval->p3, 'p4'=>$pval->p4, 'p5'=>$pval->p5); 
}
									
?>
<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Addresses'), ['controller' => 'Addresses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Address'), ['controller' => 'Addresses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Runs'), ['controller' => 'Runs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Run'), ['controller' => 'Runs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orderdetails'), ['controller' => 'Orderdetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Orderdetail'), ['controller' => 'Orderdetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
-->

<script>
 
  var countBoxPhotos = 1 ;	
 function addExpPhotos() {

	   var str = '<div class="form-group" id="del'+countBoxPhotos+'">'+
					'<div class="input col-md-6">'+
						'<label>Product</label>'+
						'<select data-placeholder="Choose Products" name="product_idn[]" required="required" '+ 
						'class="form-control chzn-select" onchange="change_price(this.value, '+countBoxPhotos+')">'+
						'<option value="">Choose Products</option>'+
						'<?php foreach($products as $pval){?>'+
							'<option value="<?=$pval->id?>"><?=$pval->description?></option>'+
						'<?php } ?>'+
						'</select>'+
					'</div>'+
					'<div class="input col-md-5">'+
						'<label>Qty</label> <input class="form-control" type="text" required="required" name="product_qtyn[]" id="product_qtyn'+countBoxPhotos+'" onchange="setFinalVAl(this.value,'+countBoxPhotos+')">'+
					'</div>'+	
					'<div class="clearfix"></div>'+
					'<div id="prodDetail'+countBoxPhotos+'"> </div>'+
					'<a href="javascript:void(0)" onclick="delExpPhotos(this.value,'+countBoxPhotos+')" class="btn btn-default">Remove</a>'+			
				'</div>';
	   
	    //alert(countBoxPhotos);
        $("#expPhoto").append(str);
        $(".chzn-select").chosen();
        countBoxPhotos += 1;
        //alert(countBoxPhotos);
    }
     
    function delExpPhotos(val,inpid) {
	    //alert('ok');
	    //alert($("#product_qtyn"+inpid).val()); alert($("#product_price"+inpid).val());  alert(inpid);
	    //var qty = $("#product_qtyn"+inpid).val();
	    //var price = $("#product_price"+inpid).val();
	    //var curPrice = qty * price;
		//final_price = final_price - curPrice;
		//$('#valOrder').html(final_price);
        $("#del"+inpid).remove();
    }	
	
		
</script>




<div id="content">
<div class="inner">
<div class="row">
    <div class="col-lg-12">
    </div>
</div>
<hr />
<div class="row">
	 <?= $this->Form->create($template) ?>
    <div class="col-lg-6">
          <div class="box">
            <div id="collapseOne" class="accordion-body collapse in body">
                <div class="col-sm-12">
                    <div class="row">
				    <fieldset>
				        <legend><?= __('Add Template') ?></legend>

						<div class="form-group">
							<div class="input">
								<label>Customer</label>
								<select data-placeholder="Choose Customer" name="customer_id" id="customer_id" required="required" 
								class="form-control chzn-select">
								<option value="">Choose Customers</option>
								<?php foreach($customers as $custKey=>$custval){?>
									<option value="<?=$custKey?>"><?=$custval?></option>
								<?php } ?>
								</select>
							</div>
						</div>
						
						<!--
						<div class="form-group" id="location">
							<div class="input">
								<label>Locations</label>
								<select data-placeholder="Choose Location" name="address_id" id="address_id" required="required" 
								class="form-control chzn-select" onchange="getCustValueszz(this.value)">
								<option value="">Choose customer to get location</option>
								</select>
							</div>
						</div>
						-->
						
						<div class="form-group">
							<div class="input">
								<div id="valOrder" >  
									<?php echo '<div class="form-group">'.$this->Form->input('day', array('empty' => 'Choose Templete Day', 'label'=>'Day', 'type'=>'select', 
										'class'=>'form-control chzn-select', 'options'=>$tempDays)).'</div>';?></div>
							</div>
						</div>

				    </fieldset>
					<!--  -->
                    </div>
                </div>
            </div>
        </div>

          <div class="box">
            <div id="collapseOne" class="accordion-body collapse in body">
                <div class="col-sm-12">
                    <div class="row">
				    <fieldset>
				        <legend><?= __('Items') ?> <a href="javascript:void(0)" onclick="addExpPhotos();" class="btn btn-default">Add More Item</a></legend>
						<div class="form-group">
							<div class="input col-md-6">
								<label>Product</label>	
								<select data-placeholder="Choose Products" name="product_idn[]"
								class="form-control chzn-select">
								<option value="">Choose Products</option>
								<?php $price_product = array(); 
										foreach($products as $pval) { ?>
									<option value="<?=$pval->id?>"> <?=$pval->description?></option>
								<?php } ?>
								</select>
							</div>
							<div class="input col-md-5">
								<label>Qty</label> <input class="form-control" type="text" name="product_qtyn[]" id="product_qtyn0">
							</div>	
							<div class="clearfix"></div>
							<div id="prodDetail"> </div>

						</div>
                        <div id="expPhoto"></div>		        
				    </fieldset>
                    </div>
                </div>
            </div>
        </div> 

          <div class="box">
            <div id="collapseOne" class="accordion-body collapse in body">
                <div class="col-sm-12">
                    <div class="row">
				    	    <fieldset> <?= $this->Form->button(__('Add Templete')) ?> </fieldset>
                    </div>
                </div>
            </div>
        </div>        

    </div>
      <?= $this->Form->end() ?>
</div>
</div>
</div>


<!--
<div class="orders form large-9 medium-8 columns content">
    <?= $this->Form->create($order) ?>
    <fieldset>
        <legend><?= __('Add Order') ?></legend>
        <?php
            echo $this->Form->input('customer_id', ['options' => $customers, 'empty' => true]);
            echo $this->Form->input('customer_name');
            echo $this->Form->input('address_id', ['options' => $addresses, 'empty' => true]);
            echo $this->Form->input('address_name');
            echo $this->Form->input('run_id', ['options' => $runs, 'empty' => true]);
            echo $this->Form->input('run_name');
            echo $this->Form->input('order_date', ['empty' => true]);
            echo $this->Form->input('delivery_date', ['empty' => true]);
            echo $this->Form->input('comment');
            echo $this->Form->input('payment_status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
