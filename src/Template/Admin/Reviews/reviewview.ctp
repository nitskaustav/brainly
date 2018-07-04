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
                <h3> Review Detail</h3>
                <table class="vertical-table table table-striped table-bordered table-hover">
                    <tr>
                        <th style="width:20%"><?php echo __('Full Name') ?></th>
                        <td style="width:80%"><?php echo h($users->user->full_name) ?></td>
                    </tr>

                    

                    <tr>
                        <th><?php echo __('Service Name') ?></th>
                        <td><?php echo $users->service->service_name ?></td>
                    </tr>                    
                    
                                      
                   
                    <tr>
                        <th><?php echo __('Service Provider Name') ?></th>
                        <td><?php echo $users->company->full_name ?></td>
                    </tr> 
                    
                    
                    
                    <tr>
                        <th><?php echo __('Review') ?></th>
                        <td><?php echo $users->review ?></td>
                    </tr>
                    
                     <tr>
                        <th><?php echo __('Photos') ?></th>
                        <td>
                            <?php foreach($rimages as $i){?>
                            <img src="<?php echo $this->Url->build('/review_img/'.$i->image_name); ?>" width="160px" height="160px" /> 
                            
                            <?php } ?>
                        </td>
                    </tr> 
                    
                    <tr>
                        <th><?php echo __('Rating') ?></th>
                        <td><?php echo $users->rating ?></td>
                    </tr>
                    
                    
                     <tr>
                        <th><?php echo __('Posted On') ?></th>
                        <td><?php echo $users->post_date ?></td>
                    </tr> 
                    
                    
                   
                    
                </table>
            </div>
        </div>
</div>
</div>