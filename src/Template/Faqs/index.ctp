<section class="pt-5 pb-5">
    <div class="container">
<div class="faqpart">
	<h3 class="mb-5">FAQ's</h3>
    <div class="panel-group cstm-accordion" id="accordion">
        <?php if(!empty($faqs)){ ?>
        <?php $i = 1;  foreach($faqs as $faqData){ ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i?>" >
                    <?php echo $faqData->question; ?>
                </h4>
            </div>
            <?php if($i == 1){ ?>
            <div id="collapse<?php echo $i?>" class="panel-collapse collapse in">
                <div class="panel-body"><?php echo $faqData->answer; ?></div>
            </div>
            <?php } else { ?>
            <div id="collapse<?php echo $i?>" class="panel-collapse collapse">
                <div class="panel-body"><?php echo $faqData->answer; ?></div>
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
    </div>
</section>
