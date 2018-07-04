<?php ?> 

<!--PAGE CONTENT -->
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Product </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Product List</h5>
                        <div class="toolbar">

                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group" style=" margin-top: 8px">
                                        <a href="<?php echo $this->Url->build(["action" => "addproduct"]); ?>"> <button class="btn btn-info btn-xs"><i class="icon-cogs icon-white"></i> Add Products</button>  </a>
                                    </div>
                                </li>
                            </ul>

                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-12">
                            <div class="row">                               
                                <div class="form-group"> 
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%;"><?php echo $this->Paginator->sort('sl') ?></th>
                                                        <th style="width:25%;"><?php echo $this->Paginator->sort('Seller Name') ?></th>
                                                        <!-- <th style="width:25%;"><?php echo $this->Paginator->sort('Product Name') ?></th> -->
                                                        
                                                        <th style="width:25%;"><?php echo $this->Paginator->sort('Model') ?></th>
                                                        <th style="width:25%;"><?php echo $this->Paginator->sort('CC') ?></th>
                                                        <th style="width:25%;"><?php echo $this->Paginator->sort('Price') ?></th>
                                                        <th style="width:25%;"><?php echo $this->Paginator->sort('Mileage') ?></th>
                                                        <th style="width:25%;"><?php echo $this->Paginator->sort('Color') ?></th>
                                                        <th style="width:25%;"><?php echo $this->Paginator->sort('Electric Bike ?') ?></th>
                                                        <th style="width:25%;"><?php echo $this->Paginator->sort('description') ?></th>
                                                      <!---<th style="width:15%;text-align: center"><?php echo $this->Paginator->sort('image') ?></th>-->
                                                        <th style="width:30%;" class="actions"><?php echo __('Actions') ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    if (!empty($result)) {
                                                        foreach ($result as $dt):
                                                            
                                                                $full_name = $dt->Users->first_name." ".$dt->Users->last_name;
                                                            
                                                            ?>
<tr>
<?php //echo $dt . '<br>'; ?>
<td><?php echo $i; ?></td>
<td><?php echo $full_name; ?></td>
<!-- <td><?php echo $dt->product_name ?></td> -->
<td><?php echo $dt->Bikemodels->model_name ?></td>
<td><?php echo $dt->cc ?></td>
<td><?php echo h($dt->price) ?></td>
<td><?php echo($dt->mileage); ?></td>
<td><?php echo h($dt->color) ?></td>
<td><?php echo h($dt->fuel_type) ?></td>
<td><?php echo $dt->description ?></td>
<td class="actions">
    <a href="<?php echo $this->Url->build(["action" => "editproduct", base64_encode(urlencode($dt->id))]); ?>"> <button class="btn btn-primary btn-xs"><i class="icon-pencil icon-white"></i> Edit</button>  </a>

    <a href="<?php echo $this->Url->build(["action" => "deleteproduct", $dt->id]); ?>" onclick="return confirm('Are you sure you want to delete?');"> <button class="btn btn-danger btn-xs"><i class="icon-remove icon-white"></i> Delete</button> </a>


    <?php if ($dt->is_active == 'Y') { ?><a href="<?php echo $this->Url->build(["action" => "chstatus", $dt->id, 'N']); ?>"> <button class="btn btn-success btn-xs"><i class="icon-thumbs-down"></i> Active</button> </a>
    <?php } else if ($dt->is_active == 'N') { ?><a href="<?php echo $this->Url->build(["action" => "chstatus", $dt->id, 'Y']); ?>"> <button class="btn btn-info btn-xs"><i class="icon-thumbs-up"></i> InActive</button> </a>
<?php } ?>
</td>                
</tr>
<?php
    $i++;
    endforeach;
    }
?>
</tbody>
</table>
<div class="paginator">
<ul class="pagination">
    <?php echo $this->Paginator->prev('< ' . __('previous')) ?>
    <?php echo $this->Paginator->numbers() ?>
    <?php echo $this->Paginator->next(__('next') . ' >') ?>
</ul>
<p><?php //echo $this->Paginator->counter()                                                   ?></p>
                                            </div>
                                        </div>  
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
<!--END PAGE CONTENT --> 