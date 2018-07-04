
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
	    
        $("#del"+inpid).remove();
    }	

    function delTempProd(inpid) {
	    //alert(inpid);
        $(inpid).remove();
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
            <div class="col-lg-12">
                  <div class="box">
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-6">
                            <div class="row">                 
							    <?= $this->Form->create($template) ?>
							    <fieldset>
							        <legend><?= __('Edit Template') ?></legend>
							        
							        
									<div class="form-group">
										<div class="input">
											<label>Customer</label>
											<select data-placeholder="Choose Customer" name="customer_id" id="customer_id" required="required" 
											class="form-control chzn-select">
											<option value="">Choose Customers</option>
											<?php foreach($customers as $custKey=>$custval){?>
												<?php if($template->customer_id != $custKey){ ?>
													<option value="<?=$custKey?>"><?=$custval?></option>
												<?php } else { ?>
													<option value="<?=$custKey?>" selected><?=$custval?></option>
												<?php } ?>
												
											<?php } ?>
											</select>
										</div>
									</div>							        
							        
									<div class="form-group">
										<div class="input">
											<div id="valOrder" >  
												<?php echo '<div class="form-group">'.$this->Form->input('day', array('empty' => 'Choose Templete Day', 'label'=>'Day', 'type'=>'select', 
													'class'=>'form-control chzn-select', 'options'=>$tempDays)).'</div>';?></div>
										</div>
									</div>							        
							        
							        
							        
						          <div class="box">
						            <div id="collapseOne" class="accordion-body collapse in body">
						                <div class="col-sm-12">
						                    <div class="row">
										    <fieldset>
										        <legend><?= __('Items') ?> <a href="javascript:void(0)" onclick="addExpPhotos();" class="btn btn-default">Add More Item</a></legend>
												
												<?php foreach ($prod as $product) { ?>

												<div class="form-group" id="<?='temprod'.$product->id?>">
													<div class="input col-md-6">
														<label>Product</label>	
														<select data-placeholder="Choose Products" name="product_idn[]"
														class="form-control chzn-select">
														<option value="">Choose Products</option>
														<?php foreach($products as $pval) { ?>
															<?php if($pval->id != $product->id){ ?>
																<option value="<?=$pval->id?>"> <?=$pval->description?></option>
															<?php } else { ?>
																<option value="<?=$pval->id?>" selected> <?=$pval->description?></option>
															<?php } ?>
															
														<?php } ?>
														</select>
													</div>
													<div class="input col-md-5">
														<label>Qty</label> <input class="form-control" type="text" name="product_qtyn[]" id="product_qtyn0" value="<?=$product->qty?>" >
													</div>	
													<div class="clearfix"></div>
													<?php $idtempprod = 'temprod'.$product->id?>
													<a href="javascript:void(0)" onclick="delTempProd(<?=$idtempprod?>)" class="btn btn-default">Remove</a>
												</div>
												
												<?php } ?>
												
												
												
						                        <div id="expPhoto"></div>		        
										    </fieldset>
						                    </div>
						                </div>
						            </div>
						        </div>							        
							        
							    </fieldset>
							    <?= $this->Form->button(__('Submit')) ?>
							    <?= $this->Form->end() ?>                           	
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $template->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $template->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Templates'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="templates form large-9 medium-8 columns content">
    <?= $this->Form->create($template) ?>
    <fieldset>
        <legend><?= __('Edit Template') ?></legend>
        <?php
            echo $this->Form->input('customer_id', ['options' => $customers, 'empty' => true]);
            echo $this->Form->input('day');
            echo $this->Form->input('detail');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
-->

