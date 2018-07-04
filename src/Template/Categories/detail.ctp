<div class="men_health">
    <div class="row">
        <div class="col-md-8 col-sm-8">
            <h1> <?php echo $data['name'] ?> </h1>
            <div id="sortDescDetCat" style="display: block">
                <p><?php echo nl2br(trim(substr($data['description'], 0, 150))) ?> ....</p>
                <br><button class="view-more" onclick="getDetailDescriptionCategory()">View More</button>
            </div>
            <div id="fullDescDetCat" style="display: none">
                <?php echo nl2br(trim($data['description'])) ?>
                <br><button class="hide-more" onclick="getsortDetailDescriptionCategory()">Hide</button>
            </div>
            <script>
                function getDetailDescriptionCategory(){
                    $("#sortDescDetCat").css("display", "none");
                    $("#fullDescDetCat").css("display", "block");                
                }

                function getsortDetailDescriptionCategory(){
                    $("#fullDescDetCat").css("display", "none");
                    $("#sortDescDetCat").css("display", "block");                
                }
            </script>
        </div>
        <div class="col-md-4 col-sm-4">            
            <?php $filePathlCatImg = WWW_ROOT . 'category_img' . DS . $data['image']; ?>
            <?php if ($data['image'] != "" && file_exists($filePathlCatImg)) { ?>
                <a class="navbar-brand" href="<?php echo $this->Url->build('/'); ?>"> <img src="<?php echo $this->Url->build('/category_img/' . $data['image']); ?>" /></a>
            <?php } else { ?> 
                <img src="<?php echo $this->Url->build('/'); ?>images/mens-health.jpg">
            <?php } ?>            
        </div>
    </div>
</div>
<div class="disfunctionarea">
    <div class="row">
        <?php if(!empty($data['treatment_categories'])){ ?>
        <?php foreach($data['treatment_categories'] as $treatment){?>
        <div class="col-md-6 col-sm-12">
            <div class="disfunction-part">
                <div class="right_img">
                        <?php $filePathlTrImg = $this->Url->build('/') . 'treatment_img' . DS . $treatment['Treatments']['image']; ?>
                        <?php if ($treatment['Treatments']['image'] != "" && file_exists($filePathlTrImg)) { ?>
                            <a class="navbar-brand" href="<?php echo $this->Url->build(["controller" => "Treatments", "action" => "treatmentdetail", $treatment['Treatments']['slug']]); ?>" width="96px" height="112px" /></a>
                        <?php } else { ?> 
                            <img src="<?php echo $filePathlTrImg; ?>">
                        <?php } ?> 
                        <h2> <?php echo $this->Html->link($treatment['Treatments']['name'], ['controller' => 'Treatments', 'action' => 'treatmentdetail', $treatment['Treatments']['slug']]); ?></a></h2>                   
                    </div>
                <div class="disfunction">
                    
                    <?php echo $treatment['Treatments']['sort_descriptiion']?>
                </div>
<!--                <div class="clearfix"></div>
-->            </div>
        </div>
        <?php } } else { ?>
        <div class="col-md-6 col-sm-12">
            <div class="disfunction-part">
                <div class="right_img">
                    </div>
                <div class="disfunction">
                    <h2><a href="#">No Treatment Exist</a></h2>
                    <p> Treatments Are Comming Soon </p>
                </div>
            </div>
        </div>        
        <?php } ?>       
        <div class="col-md-6 col-sm-12">
            <div class="disfunction-part">
            <div class="right_img">
                  <img src="<?php echo $this->Url->build('/'); ?>images/lowest-price.jpg">
                    <h2><a href="#">Also available</a></h2>
                </div>
                <div class="disfunction">
                    <ul>
                        <?php foreach($others as $other)
                        { ?>
                            <li>
                                <?php echo $this->Html->link($other['Treatments']['name'], ['controller' => 'Treatments', 'action' => 'treatmentdetail', $other['Treatments']['slug']]); ?></li>
                            <?php
                        } ?>
                    </ul>
                </div>
            </div>
        </div>        
    </div>
</div>
<div class="suplimentary-information">
    <h2>Supplementary information</h2>
        <ul class="bxslider">                   
        <?php foreach ($appSlider as $sliderData) { ?> 
            <li>
                <a href="<?php echo $this->Url->build(["controller" => "Treatments", "action" => "treatmentdetail", $sliderData['slug']]); ?>">
                    <img src="<?php echo $this->Url->build('/'); ?>treatment_img/<?php echo $sliderData['image'] ?>" width="169" height="130" />
                    <p style="font-size: 12px; alignment-adjust: central"><?php echo $sliderData['name'] ?></p></a>
            </li>
        <?php } ?>
        </ul>
</div>