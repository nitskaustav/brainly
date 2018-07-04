<!--PAGE CONTENT -->
<div id="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <h2> <?php echo  __('EMAIl TEMPLATES LIST') ?> </h2>
      </div>
    </div>
    <hr />
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading"> <?php echo  __('EMAIl TEMPLATES  LIST') ?> </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th style="width: 5%">Sl No</th>
                    <th style="width: 45%"><?php echo $this->Paginator->sort('subject') ?></th>
                    <th style="width: 10%"><?php echo  __('Actions') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($email_tpls as $dt): ?>  
                  <tr>
                    <td> <?php echo $i ?> </td>
                    <td><?php echo h($dt->subject) ?></td>
                    <td>
                      <a href="<?php echo $this->Url->build(["action" => "edit", $dt->id]); ?>"> <button class="btn btn-primary"><i class="icon-pencil icon-white"></i> Edit</button>  </a>
                    </td>
                  </tr>
                  <?php $i ++; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <div class="paginator">
                  <ul class="pagination">
                      <?php echo  $this->Paginator->prev('< ' . __('previous')) ?>
                      <?php echo  $this->Paginator->numbers() ?>
                      <?php echo  $this->Paginator->next(__('next') . ' >') ?>
                  </ul>
                  <p><?php //echo  $this->Paginator->counter() ?></p>
              </div>                  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--END PAGE CONTENT --> 







<!--<div id="content">
    <div class="inner">
      <div class="row">
        <div class="col-lg-12">
         
        </div>
      </div>
      <hr />
<div class="table-responsive">
    <h3><?php echo  __('CMS PAGES LIST') ?></h3>
    <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('id') ?></th>
                <th><?php echo $this->Paginator->sort('page_title') ?></th>
                <th><?php echo $this->Paginator->sort('page_slug') ?></th>
                <th class="actions"><?php echo  __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contents as $dt): ?>
            <tr>
                <td><?php echo $this->Number->format($dt->id) ?></td>
                <td><?php echo h($dt->page_title) ?></td>
                <td><?php echo h($dt->page_slug) ?></td>
                <td class="actions">
                    <?php //echo //$this->Html->link(__('View'), ['action' => 'view', $dt->id]) ?>
                    <?php //echo $this->Html->link(__('Edit'), ['action' => 'edit', $dt->id]) ?>
                    
                    <a href="<?php echo $this->Url->build(["action" => "edit", $dt->id]); ?>"> <button class="btn btn-primary"><i class="icon-pencil icon-white"></i> Edit</button>  </a>
                    
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?php echo  $this->Paginator->prev('< ' . __('previous')) ?>
            <?php echo  $this->Paginator->numbers() ?>
            <?php echo  $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?php echo  $this->Paginator->counter() ?></p>
    </div>
</div>
</div>
</div>-->

