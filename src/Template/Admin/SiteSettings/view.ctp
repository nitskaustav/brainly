<!--<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Customer'), ['action' => 'edit', $customer->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Customer'), ['action' => 'delete', $customer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customer->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Addresses'), ['controller' => 'Addresses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Address'), ['controller' => 'Addresses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Templates'), ['controller' => 'Templates', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Template'), ['controller' => 'Templates', 'action' => 'add']) ?> </li>
    </ul>
</nav>-->
<div id="content">
    <div class="inner">
      <div class="row">
        <div class="col-lg-12">
         
        </div>
      </div>
      <hr />
       <div class="table-responsive">
            <div class="runs view large-9 medium-8 columns content">
			    <h3>Detail of <?= h($doctors->first_name." ".$doctors->last_name) ?></h3>
			    <table class="vertical-table">
			        <tr>
			            <th><?= __('Name') ?></th>
			            <td><?= h($doctors->first_name." ".$doctors->last_name) ?></td>
			        </tr>
			        <tr>
			            <th><?= __('Phone') ?></th>
			            <td><?= h($doctors->phone) ?></td>
			        </tr>
			        <tr>
			            <th><?= __('Email') ?></th>
			            <td><?= h($doctors->email) ?></td>
			        </tr>
			        <tr>
			            <th><?= __('Created') ?></th>
			            <td><?= h($doctors->created) ?></td>
			        </tr>
			        <tr>
			            <th><?= __('Modified') ?></th>
			            <td><?= h($doctors->modified) ?></td>
			        </tr>
			    </table>
            </div>
        </div>
       
       <?php /* ?>
       <div class="table-responsive">
            <div class="runs view large-12 medium-12 columns content">
		        <h4><?= __('Related Addresses') ?></h4>
		        <?php if (!empty($customer->addresses)): ?>
		        <table cellpadding="0" cellspacing="0">
		            <tr>
		                <!--<th><?= __('Id') ?></th>
		                <th><?= __('Customer Id') ?></th>
		                <th><?= __('Run Id') ?></th> -->
		                <th><?= __('Address') ?></th>
		                <!--<th><?= __('Created') ?></th>
		                <th><?= __('Modified') ?></th>-->
		                <th class="actions"><?= __('Actions') ?></th>
		            </tr>
		            <?php foreach ($customer->addresses as $addresses): ?>
		            <tr>
		                <!--<td><?= h($addresses->id) ?></td>
		                <td><?= h($addresses->customer_id) ?></td>
		                <td><?= h($addresses->run_id) ?></td> -->
		                <td><?= h($addresses->address) ?></td>
		                <!--<td><?= h($addresses->created) ?></td>
		                <td><?= h($addresses->modified) ?></td>-->
		                <td class="actions">
		                    <!-- <?= $this->Html->link(__('View'), ['controller' => 'Addresses', 'action' => 'view', $addresses->id]) ?> -->
		                    <?= $this->Html->link(__('Edit'), ['controller' => 'Addresses', 'action' => 'edit', $addresses->id, $addresses->customer_id]) ?>
		                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Addresses', 'action' => 'delete', $addresses->id, $addresses->customer_id], ['confirm' => __('Are you sure you want to delete # {0}?', $addresses->id)]) ?>
		                </td>
		            </tr>
		            <?php endforeach; ?>
		        </table>
		        <?php endif; ?>
            </div>
        </div>        

        <div class="table-responsive">
            <div class="runs view large-9 medium-8 columns content">
		        <h4><?= __('Related Orders') ?></h4>
		        <?php if (!empty($customer->orders)): ?>
		        <table cellpadding="0" cellspacing="0">
		            <tr>
		                <th><?= __('Id') ?></th>
		                <th><?= __('Customer Id') ?></th>
		                <th><?= __('Customer Name') ?></th>
		                <th><?= __('Address Id') ?></th>
		                <th><?= __('Address Name') ?></th>
		                <th><?= __('Run Id') ?></th>
		                <th><?= __('Run Name') ?></th>
		                <th><?= __('Order Date') ?></th>
		                <th><?= __('Delivery Date') ?></th>
		                <th><?= __('Comment') ?></th>
		                <th><?= __('Payment Status') ?></th>
		                <th><?= __('Created') ?></th>
		                <th><?= __('Modified') ?></th>
		                <th class="actions"><?= __('Actions') ?></th>
		            </tr>
		            <?php foreach ($customer->orders as $orders): ?>
		            <tr>
		                <td><?= h($orders->id) ?></td>
		                <td><?= h($orders->customer_id) ?></td>
		                <td><?= h($orders->customer_name) ?></td>
		                <td><?= h($orders->address_id) ?></td>
		                <td><?= h($orders->address_name) ?></td>
		                <td><?= h($orders->run_id) ?></td>
		                <td><?= h($orders->run_name) ?></td>
		                <td><?= h($orders->order_date) ?></td>
		                <td><?= h($orders->delivery_date) ?></td>
		                <td><?= h($orders->comment) ?></td>
		                <td><?= h($orders->payment_status) ?></td>
		                <td><?= h($orders->created) ?></td>
		                <td><?= h($orders->modified) ?></td>
		                <td class="actions">
		                    <?= $this->Html->link(__('View'), ['controller' => 'Orders', 'action' => 'view', $orders->id]) ?>
		                    <?= $this->Html->link(__('Edit'), ['controller' => 'Orders', 'action' => 'edit', $orders->id]) ?>
		                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Orders', 'action' => 'delete', $orders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orders->id)]) ?>
		                </td>
		            </tr>
		            <?php endforeach; ?>
		        </table>
		        <?php endif; ?>
            </div>
        </div>       
        
        
        <div class="table-responsive">
            <div class="runs view large-9 medium-8 columns content">
        <h4><?= __('Related Templates') ?></h4>
        <?php if (!empty($customer->templates)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Customer Id') ?></th>
                <th><?= __('Day') ?></th>
                <th><?= __('Detail') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($customer->templates as $templates): ?>
            <tr>
                <td><?= h($templates->id) ?></td>
                <td><?= h($templates->customer_id) ?></td>
                <td><?= h($templates->day) ?></td>
                <td><?= h($templates->detail) ?></td>
                <td><?= h($templates->created) ?></td>
                <td><?= h($templates->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Templates', 'action' => 'view', $templates->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Templates', 'action' => 'edit', $templates->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Templates', 'action' => 'delete', $templates->id], ['confirm' => __('Are you sure you want to delete # {0}?', $templates->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
            </div>
        </div> 
        <?php */ ?>

</div>
</div>