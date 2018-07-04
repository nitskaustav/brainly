    <section class="user-dashboard">
		<div class="container">
			<div class="row">
                <?php echo ($this->element('side_menu'));?>
                <div class="col-lg-9 col-md-8">
					<div class="edit-pro p-3 p-lg-4">
						<h5 class="common-title mb-3 pb-2">Venues List</h5>
                        
                        <?php if($service!=''){foreach ($service as $dt){ ?>
                        <div class="row mt-3 pb-3 product-list-row">
                            <div class="col-lg-2 col-md-3 col-4">

                                <?php if(isset($dt->image)) { ?>
                                <img src="<?php echo $this->Url->build('/service_img/'.$dt->image); ?>" alt="" class="img-fluid">
                                <?php }else{ ?>
                                 <img src="<?php echo $this->Url->build('/image/default.png'); ?>" alt="" class="img-fluid">
                                <?php } ?>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <h5><?php echo $dt['service_name'];?></h5>
                                 <i class="fa fa-map-marker" aria-hidden="true"></i>
                                 <span><?php echo $dt['address'];?></span>
                                <p class="text-grey"><?php  echo substr($dt['description'],0,100).'...';?></p>
                                
             
                            </div>
                            <div class="col-lg-4 col-md-3 col-12 text-md-right">
                                
                                <?php if($dt['step']==1){?>

                                <a href="<?php echo $this->Url->build(["controller" => "Services","action" => "addservicestep2",$dt['id']]);?>" class="btn btn-sm btn-secondary">Edit</a>
                                
                                <?php }elseif($dt['step']==2) {?>
                                
                                <a href="<?php echo $this->Url->build(["controller" => "Services","action" => "addservicestep3",$dt['id']]);?>" class="btn btn-sm btn-secondary">Edit</a>
                                <?php }else{ ?>
                                
                                <a href="<?php echo $this->Url->build(["controller" => "Services","action" => "editservice",$dt['id']]);?>" class="btn btn-sm btn-secondary">Edit</a>
                                <?php } ?>
                                
                                
                                <a href="<?php echo $this->Url->build(["controller" => "Services","action" => "servicedelete",$dt['id']]);?>" class="btn btn-sm btn-danger">Delete</a>
                            </div>
                        </div>
                        <?php } } ?>



		<div class="paging">
		<?php
			echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
		?>
		</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
