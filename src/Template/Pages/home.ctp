<section class="iconholder">
                
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="border-title why-choose">Why Choose This System</h1>
				</div>
			</div>
			<div class="flex-container">
                            <?php foreach($easydownloads as $easydownload)
                            { ?>
                                <div class="flex-item">
                                      <div class="icon-wrap">
                                            <?php
                                                if(!empty($easydownload->image))
                                                {
                                                    echo($this->Html->image('/easydownload/'.$easydownload->image, array('alt' => $easydownload->title)));
                                                }
                                                else { ?>
                                                    <img src="images/how-1.png" alt="">
                                                    <?php
                                                }?>
                                            <h3><?php echo $easydownload->title; ?></h3>
                                            <p><?php echo $easydownload->text; ?></p>
                                      </div>
                                </div>
                            <?php
                            } ?>
			</div>			
		</div>
	</section>

<section class="close-feature">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="border-title why-choose"><?php echo(!empty($homecontent->goal_title)?$homecontent->goal_title:''); ?></h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-7 col-sm-8 center-div">
					<p class="feature-text"><?php echo(!empty($homecontent->goal_description)?$homecontent->goal_description:''); ?></p>
				</div>
			</div>
			<div class="row mobile-part">
				<div class="col-lg-4 col-md-4 col-sm-4">
					<ul class="mobile-left-wrap">
                                            <?php foreach($goals as $goal)
                                                { 
                                                    if($goal->side=='L')
                                                    {
                                                        ?>
                                                    <li>
                                                            <div class="media">
                                                                    <div class="media-body">
                                                                            <!--<h4 class="media-heading">Post Task</h4>-->
                                                                            <p><?php echo $goal->title; ?></p>
                                                                    </div>
                                                                    <div class="media-left">
                                                                        <?php if(!empty($goal->image))
                                                                        {
                                                                            echo($this->Html->image('/easydownload/'.$goal->image, array('alt' => $goal->title,'width'=>'70' )));
                                                                        } ?>
                                                                        
                                                                           
                                                                    </div>

                                                            </div>
                                                    </li>
                                                    <?php
                                                    }
                                                } ?>
						
					</ul>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4">
					<div class="mobile-phone">
                                            <?php
										
                                                $uploadFolder = "easydownload";
                                                $uploadPath = WWW_ROOT . $uploadFolder;
                                                $invoiceImageName = $homecontent->goal_image;
                                                if(file_exists($uploadPath . '/' . $invoiceImageName) && $invoiceImageName!=''){
                                                    echo($this->Html->image('/easydownload/'.$invoiceImageName, array('alt' => $homecontent->goal_title )));
                                                } else {
                                                    echo($this->Html->image('/easydownload/default.png', array('alt' => $homecontent->goal_title)));
                                                }

                                              ?>          
                                            
                                        </div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4">
					<ul class="mobile-right-wrap">
                                            <?php foreach($goals as $goal)
                                                { 
                                                    if($goal->side=='R')
                                                    {
                                                        ?>
						<li>
							<div class="media">
								<div class="media-left">
									<?php if(!empty($goal->image))
                                                                        {
                                                                            echo($this->Html->image('/easydownload/'.$goal->image, array('alt' => $goal->title,'width'=>'70' )));
                                                                        } ?>
								</div>
								<div class="media-body">
									<!--<h4 class="media-heading">Browse</h4>-->
									<p><?php echo $goal->title; ?></p>
								</div>
							</div>
						</li>
                                                    <?php
                                                    }
                                                }
                                            ?>
					</ul>
				</div>
			</div>
		</div>
	</section>


<section class="screenshots">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="border-title">Screenshots</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-7 col-sm-8 center-div">
					<p class="feature-text">Lorem Ipsum is text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<ul>
                                            <?php foreach($screenshots as $screen)
                                                    { ?>
						<li>
							<?php if(!empty($screen->image))
                                                                        {
                                                                            echo($this->Html->image('/easydownload/'.$screen->image, array('alt' => $screen->title )));
                                                                        } ?>
						</li>
                                                    <?php
                                                    }
                                                ?>
					</ul>
				</div>
			</div>
		</div>
	</section>


<section class="pricing-area">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="border-title why-choose">Pricing</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-7 col-sm-8 center-div">
					<p class="pricing-text">Lorem Ipsum is text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-4 col-md-offset-2">
					<div class="dentist-area">
						<h3>Dentists</h3>
						<div class="dentist-text-area">
							<p class="dentist-text dentist-text-no-mrgn">1 Year Subscription $99</p>
						<p class="dentist-text">+ 1 light ring $50</p>
						<p class="dentist-text">Annual renewal $99 </p>
						</div>
						
					</div>
				</div>
				<div class="col-md-4">
					<div class="dentist-area">
						<h3>Dental Labs</h3>
						<div class="dentist-text-area">
							<p class="dentist-text">Annual subscription $99</p>
						<p class="dentist-area-text">This will allow you to receive and communicate
with unlimited number of dentists.
We will list you on our website by geographical
locations so that other dentists can find you. 
</p>
						</div>
						
						
					</div>
				</div>
			</div>
			
		</div>
	</section>

