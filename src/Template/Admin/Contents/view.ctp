<!--<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Run'), ['action' => 'edit', $run->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Run'), ['action' => 'delete', $run->id], ['confirm' => __('Are you sure you want to delete # {0}?', $run->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Runs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Run'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Addresses'), ['controller' => 'Addresses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Address'), ['controller' => 'Addresses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
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
                <h3><?= h($run->id) ?></h3>
                <table class="vertical-table table table-striped table-bordered table-hover">
                    <tr>
                        <th><?= __('Run Name') ?></th>
                        <td><?= h($run->run_name) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Run No') ?></th>
                        <td><?= h($run->run_no) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Id') ?></th>
                        <td><?= $this->Number->format($run->id) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Created') ?></th>
                        <td><?= h($run->created) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modified') ?></th>
                        <td><?= h($run->modified) ?></td>
                    </tr>
                </table>
            </div>
        </div>
</div>
</div>
