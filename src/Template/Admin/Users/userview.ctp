<?php ?>
<div id="content">
    <div class="inner">
      <div class="row">
        <div class="col-lg-12">
        </div>
      </div>
      <hr />
       <div class="table-responsive">
            <div class="runs view large-9 medium-8 columns content">
                <h3> User Detail</h3>
                <table class="vertical-table table table-striped table-bordered table-hover">
                    <tr>
                        <th style="width:20%"><?php echo __('Full Name') ?></th>
                        <td style="width:80%"><?php echo ($users->first_name) ?> <?php echo h($users->last_name) ?></td>
                    </tr>

                    <tr>
                        <th style="width:20%"><?php echo __('User Name') ?></th>
                        <td style="width:80%"><?php echo ($users->username) ?></td>
                    </tr>

                    <tr>
                        <th><?php echo __('Gender') ?></th>
                        <td><?php echo $users->gender ?></td>
                    </tr>

                    <tr>
                        <th><?php echo __('Birth Year') ?></th>
                        <td><?php echo $users->birth_year ?></td>
                    </tr>

                    <tr>
                        <th><?php echo __('Month') ?></th>
                        <td><?php echo jdmonthname(gregoriantojd($users->month, 1, 1), CAL_MONTH_GREGORIAN_LONG); ?></td>
                    </tr>

                    <tr>
                        <th><?php echo __('Day') ?></th>
                        <td><?php echo $users->day ?></td>
                    </tr>

                    <tr>
                        <th><?php echo __('Level') ?></th>
                        <td><?php echo $users->level ?></td>
                    </tr>

                    <tr>
                        <th><?php echo __('Email') ?></th>
                        <td><?php echo $users->email ?></td>
                    </tr>                                 
                    
                     <tr>
                        <th><?php echo __('Image') ?></th>
                        <td> <img src="<?php echo $this->Url->build('/user_img/'.$users->pimg); ?>" width="240px" height="140px" /> </td>
                    </tr>                    
                    
                    <tr>
                        <th><?php echo __('Created On') ?></th>
                        <td><?php echo $users->created ?></td>
                    </tr>
                    
                    <tr>
                        <th><?php echo __('Modified On') ?></th>
                        <td><?php echo $users->modified ?></td>
                    </tr>
                    
                </table>
            </div>
        </div>
</div>
</div>