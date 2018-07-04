<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Template'), ['action' => 'edit', $template->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Template'), ['action' => 'delete', $template->id], ['confirm' => __('Are you sure you want to delete # {0}?', $template->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Templates'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Template'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
-->


<div id="content">
    <div class="inner">
      <div class="row">
        <div class="col-lg-12">
         
        </div>
      </div>
      <hr />
       <div class="table-responsive">
            <div class="runs view large-9 medium-8 columns content">
			    <h3>Detail of <?= h($template->id) ?></h3>
			    <table class="vertical-table">
			        <tr>
			            <th><?= __('Customer') ?></th>
			            <td><?= $template->has('customer') ? $this->Html->link($template->customer->name, ['controller' => 'Customers', 'action' => 'view', $template->customer->id]) : '' ?></td>
			        </tr>
			        <tr>
			            <th><?= __('Day') ?></th>
			            <td><?= h($template->day) ?></td>
			        </tr>
			        <tr>
			            <th><?= __('Id') ?></th>
			            <td><?= $this->Number->format($template->id) ?></td>
			        </tr>
			        <tr>
			            <th><?= __('Created') ?></th>
			            <td><?= h($template->created) ?></td>
			        </tr>
			        <tr>
			            <th><?= __('Modified') ?></th>
			            <td><?= h($template->modified) ?></td>
			        </tr>
			    </table>
            </div>
        </div>
       
       <!--
       <div class="table-responsive">
            <div class="runs view large-12 medium-12 columns content">
		        <h4><?= __('Comment') ?></h4>
		        <?= $this->Text->autoParagraph(h($order->comment)); ?>
            </div>
        </div>        
		-->
		
        <div class="table-responsive">
            <div class="runs view large-9 medium-8 columns content">
        	<h4><?= __('Product Detail') ?></h4>
        	<?php if (!empty($prod)): ?>
	        <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover">
	            <tr>
	                <th><?= $this->Paginator->sort('id') ?></th>
	                <th><?= $this->Paginator->sort('product') ?></th>
	                <th><?= $this->Paginator->sort('qty') ?></th>
	            </tr>
	        <tbody>
	            <?php foreach ($prod as $product): ?>
	            <tr>
	                <td><?= $this->Number->format($product->id) ?></td>
	                <td><?= h($product->description) ?></td>
	                <td><?= h($product->qty) ?></td>
	            <?php endforeach; ?>
	        </tbody>
	        </table>
        	<?php endif; ?>
            </div>
        </div>       
        
       
</div>
</div>

