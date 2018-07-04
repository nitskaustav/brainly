
<div class="faqpart">
	<h2>FAQ of <?php echo $data['name'] ?></h2>
    <div class="panel-group" id="accordion">
        <?php if(!empty($dataList)){ ?>
        <?php $i = 1;  foreach($dataList as $faqData){ ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i?>" >
                    <a> <?php echo $faqData['question']; ?> </a>
                </h4>
            </div>
            <?php if($i == 1){ ?>
            <div id="collapse<?php echo $i?>" class="panel-collapse collapse in">
                <div class="panel-body"><?php echo $faqData['answer']; ?></div>
            </div>
            <?php } else { ?>
            <div id="collapse<?php echo $i?>" class="panel-collapse collapse">
                <div class="panel-body"><?php echo $faqData['answer']; ?></div>
            </div>
            <?php } ?>
            
        </div>
        <?php $i++; } ?>
        <?php } else { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse">
                    <a> FAQ'S Coming Soon </a>
                </h4>
            </div>
        </div>        
        <?php } ?>
    </div>

</div>