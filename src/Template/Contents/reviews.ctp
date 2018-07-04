<div class="review-area">
    <h1>Customer reviews</h1>
    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.  </p>

    <p>Nemo enim ipsam voluptatem quia voluptas sit.</p>				
    <a href="javascript:void(0)" class="button-purple"> Read external reviews </a>
</div>

<p><b>Money back guarantee:</b>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae.</p>
<p>Latest selected top reviews.</p>
<?php if(!empty($review)){ ?>
    <?php foreach($review as $k => $rev){ ?>
        <div class="top-reviews">
            <!-- <div class="review-avatar"><img src="<?php echo $this->Url->build('/', true); ?>images/reviewimage.png"></div> -->
            <div class="review-text">
                <span class="date"> <h3><b> Review From : </b> <?php echo $rev->user->first_name." ".$rev->user->last_name ?> </h3> </span>
                <p> <?php echo $rev->review;?>
                    <span class="date"> <?php echo date('d F Y', strtotime( $rev->date )); ?> </span>
                    <span id="<?php echo $k;?>" style="color:#ff6624; font-size: 25px;"></span>
                </p>
            </div>
            <div class="clearfix"></div>
        </div>

        <script>
            $(document).ready(function(){
            $("#<?php echo $k; ?>").raty({score:'<?php echo $rev->rate ?>',readOnly:true, halfShow : true});   
        }); 
        </script>
    <?php } ?>

<?php } ?>

<!--
<div class="top-reviews">
    <div class="review-avatar"><img src="<?php echo $this->Url->build('/', true); ?>images/reviewimage.png"></div>
    <div class="review-text"><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
            <span class="date">24/10/2016</span>
            <span class="review-star"><img src="<?php echo $this->Url->build('/', true); ?>images/fivestar-rating.png"></span>
        </p></div>
    <div class="clearfix"></div>
</div>
<div class="top-reviews">
    <div class="review-avatar"><img src="<?php echo $this->Url->build('/', true); ?>images/reviewimage.png"></div>
    <div class="review-text"><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
            <span class="date">24/10/2016</span>
            <span class="review-star"><img src="<?php echo $this->Url->build('/', true); ?>images/fivestar-rating.png"></span>
        </p></div>
    <div class="clearfix"></div>
</div>
<div class="top-reviews">
    <div class="review-avatar"><img src="<?php echo $this->Url->build('/', true); ?>images/reviewimage.png"></div>
    <div class="review-text"><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
            <span class="date">24/10/2016</span>
            <span class="review-star"><img src="<?php echo $this->Url->build('/', true); ?>images/fivestar-rating.png"></span>
        </p></div>
    <div class="clearfix"></div>
</div>
-->
<div class="reviewservices">
    <div class="pagination-area">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php echo $this->Paginator->first(__('<< First', true), array('class' => 'number-first')); ?>
                <?php echo $this->Paginator->numbers(array('class' => 'numbers', 'first' => false, 'last' => false)); ?>
                <?php echo $this->Paginator->last(__('Last >>', true), array('class' => 'number-end')); ?> 
            </ul>
        </nav>
    </div>
</div>
<!--
<div class="cust-feed">
    <h3>Feedback from customers</h3>
    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</p>
    <div class="cust-feed1">
        <h3>Service is second to none</h3>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
        <p> -Dr K W via Trustedshops (August 2015)</p>
    </div>
    <div class="cust-feed1">
        <h3>Service is second to none</h3>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
        <p> -Dr K W via Trustedshops (August 2015)</p>
    </div>
    <div class="cust-feed1">
        <h3>Service is second to none</h3>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
        <p> -Dr K W via Trustedshops (August 2015)</p>
    </div>
    <div class="cust-feed1">
        <h3>Service is second to none</h3>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
        <p> -Dr K W via Trustedshops (August 2015)</p>
    </div>
    <div class="cust-feed1">
        <h3>Service is second to none</h3>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
        <p> -Dr K W via Trustedshops (August 2015)</p>
    </div>
    <div class="cust-feed1">
        <h3>Service is second to none</h3>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
        <p> -Dr K W via Trustedshops (August 2015)</p>
    </div>
</div>
-->