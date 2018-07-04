<div id="content">
    <div class="inner">
      <div class="row">
        <div class="col-lg-12">
        </div>
      </div>
      <hr />
       <div class="table-responsive">
            <div class="runs view large-9 medium-8 columns content">
                <h3> Doctor Detail</h3>
                <table class="vertical-table table table-striped table-bordered table-hover">
                    <tr>
                        <th style="width:20%"><?php echo __('First Name') ?></th>
                        <td style="width:80%"><?php echo h($doctors->first_name) ?></td>
                    </tr>

                    <tr>
                        <th><?php echo __('Last Name') ?></th>
                        <td><?php echo h($doctors->last_name) ?></td>
                    </tr>


                    <tr>
                        <th><?php echo __('Phone') ?></th>
                        <td><?php echo $doctors->phone ?></td>
                    </tr>

                    <tr>
                        <th><?php echo __('Email') ?></th>
                        <td><?php echo $doctors->email ?></td>
                    </tr>

                    <tr>
                        <th><?php echo __('Created On') ?></th>
                        <td><?php echo $doctors->created ?></td>
                    </tr>

                    <tr>
                        <th><?php echo __('Modified On') ?></th>
                        <td><?php echo $doctors->modified ?></td>
                    </tr>

                </table>
            </div>
        </div>
</div>
</div>