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
                <h3> Seller Detail</h3>
                <table class="vertical-table table table-striped table-bordered table-hover">
                    <tr>
                        <th style="width:20%"><?php echo __('Full Name') ?></th>
                        <td style="width:80%"><?php echo h($users->full_name) ?></td>
                    </tr>



                    <tr>
                        <th><?php echo __('Email') ?></th>
                        <td><?php echo $users->email ?></td>
                    </tr>                    



                    <tr>
                        <th><?php echo __('Address') ?></th>
                        <td><?php echo $users->address ?></td>
                    </tr> 

<!--                    <tr>
    <th><?php echo __('Website') ?></th>
    <td><?php echo $users->website ?></td>
</tr>
 
<tr>
    <th><?php echo __('Working Days') ?></th>
    <td><?php echo $users->working_days ?></td>
</tr>

 <tr>
    <th><?php echo __('Working Hours') ?></th>
    <td><?php echo $users->working_hours_from . ' To ' . $users->working_hours_to; ?></td>
</tr>


 <tr>
    <th><?php echo __('Service Type') ?></th><td>
                    <?php foreach ($stname as $dt) { ?>
                        <?php echo $dt->type_name . ',' ?>
                    <?php } ?>
</td></tr>

<tr>
    <th><?php echo __('Car Maker') ?></th><td>
                    <?php foreach ($stagname as $dt) { ?>
                        <?php echo $dt->make_name . ',' ?>
                    <?php } ?>
</td></tr>
 
 <tr>
    <th><?php echo __('Features') ?></th><td>
                    <?php foreach ($sfname as $dt) { ?>
                        <?php echo $dt->feature_name . ',' ?>
                    <?php } ?>
</td></tr>-->

                    <tr>
                        <th><?php echo __('Description') ?></th>
                        <td><?php echo $users->description; ?></td>
                    </tr>

<!--                     <tr>
    <th><?php echo __('Pricing') ?></th>
    <td><?php echo $users->pricing ?></td>
</tr>-->


                    <tr>
                        <th><?php echo __('Photos') ?></th>
                        <td>
                            <?php foreach ($spimages as $i) { ?>
                                <img src="<?php echo $this->Url->build('/user_img/' . $i->image_name); ?>" width="240px" height="160px" /> 

                            <?php } ?>
                        </td>
                    </tr>                    


<!--                     <tr>
    <th><?php echo __('Documents') ?></th>
    <td>
                    <?php foreach ($spdocs as $i) { ?>
                        <?php if (strstr($i->doc_name, '.') == '.docx' || strstr($i->doc_name, '.') == '.doc') { ?>
                              <img src="<?php echo $this->Url->build('/img/doc.png'); ?>" width="100px" height="100px" /> 
                            <?php
                            echo $this->Html->link('Download File', array('controller' => 'Reviews', 'action' => 'downloadfile', $i->doc_name,));
                        } else {
                            ?>
                              
                              <img src="<?php echo $this->Url->build('/img/pdf.png'); ?>" width="100px" height="100px" /> 
                            <?php
                            echo $this->Html->link('Download File', array('controller' => 'Reviews', 'action' => 'downloadfile', $i->doc_name,));
                        }
                        ?>
                  
                    
<?php } ?>
    </td>
</tr>-->


                    <tr>
                        <th><?php echo __('Created On') ?></th>
                        <td><?php echo $users->created ?></td>
                    </tr>

                    <tr>
                        <th><?php echo __('Modified On') ?></th>
                        <td><?php echo $users->modified ?></td>
                    </tr>

                </table>

                <div>
                    <table class="vertical-table table table-striped table-bordered table-hover">
                        <tr>
                            <th style="width:20%">Verified?</th>
                            <td style="width:40%"><a href="<?php echo $this->Url->build(["action" => "serviceproviderverified", $users->id, 'Y']); ?>"><button>Yes</button></a></td>
                            <td style="width:40%"><a href="<?php echo $this->Url->build(["action" => "serviceproviderverified", $users->id, 'N']); ?>"><button>No</button></a></td>
                        </tr>  

                    </table>


                </div>

            </div>
        </div>
    </div>
</div>