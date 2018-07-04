<?php
	// echo "<pre>";
	// print_r($review_data);exit;
?>

<?php

echo $this->Html->script('/plugins/dataTables/jquery.dataTables.js')?>
<?php echo $this->Html->script('/plugins/dataTables/dataTables.bootstrap.js')?>
<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script language="javascript" type="text/javascript">

    function deleteConfirm()
    {
        var x = window.confirm("Are you sure you want to delete this?")
        if (x)
        {
            return true;
        }
        else
        {
            return false;
        }
        return false;
    }
</script>


<!--PAGE CONTENT -->
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1> Review &amp; Rating List </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Review &amp; Rating List</h5>
                        <div class="toolbar">
                            
                        </div>
                    </header>
                    <div class="accordion-body collapse in body">
                       
                    </div>
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-12">
                            <div class="row">                               
                                <div class="form-group"> 
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover">
   <thead>
       <tr>
           <th><?php echo $this->Paginator->sort('id') ?></th>
           <th><?php echo $this->Paginator->sort('Image') ?></th>
           <th><?php echo $this->Paginator->sort('Product Name') ?></th>
           <th><?php echo $this->Paginator->sort('User Name') ?></th>
           <th><?php echo $this->Paginator->sort('Review Date') ?></th>
           <th><?php echo $this->Paginator->sort('Rating') ?></th>
           <th><?php echo $this->Paginator->sort('Review') ?></th>
           <th><?php echo $this->Paginator->sort('Status ') ?></th>
       </tr>
   </thead>
   <tbody>
<?php $i = 1; foreach ($review_data as $review):
              $upload = $review->gear->upload;
              //$upload_array = explode(",", $upload);
              $filename = WWW_ROOT.'gear_img/'.$upload;

              if(!file_exists($filename) || $upload == ''){
                 $upload = 'no-image.png';
              }

?>
       <tr>
           <td><?php echo $this->Number->format($i) ?></td>
           <td><img src="<?php echo $this->Url->build('/gear_img/'.$upload); ?>" width="140px" height="80px" /></td>
           <td><?php echo $review->gear->product_name; ?></td>
           <td><?php echo $review->user->first_name." ".$review->user->last_name ?></td>
           <td><?php echo $review->review_date; ?></td>
           <td><?php echo $review->rating; ?></td>
           <td><?php echo $review->review; ?></td>
           <td>
            <?php 
              //echo $review->status;
              if($review->status == 0){
                ?>
                <span><a href="<?php echo $this->Url->build(["controller" => "Users","action" => "changereviewstatus", $review->id]);?>" style="text-decoration: none;">Enable</a></span>
              <?php }elseif($review->status == 1){ ?>
                <span><a href="<?php echo $this->Url->build(["controller" => "Users","action" => "changereviewstatus", $review->id]);?>" style="text-decoration: none;">Disable</a></span>
              <?php }
            ?>
            </td>
       </tr>
<?php $i++; endforeach; ?>
   </tbody>
</table>
                                            <div class="paginator">
                                                <ul class="pagination">
                                            <?php echo $this->Paginator->prev('< ' . __('previous')) ?>
                                            <?php echo $this->Paginator->numbers() ?>
                                            <?php echo $this->Paginator->next(__('next') . ' >') ?>
                                                </ul>
                                                <p><?php //echo $this->Paginator->counter() ?></p>
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
<script>
function resetForm()
{
    window.location.href="<?php echo $this->Url->build(["action" => "index"]); ?>";

  
}
</script> 
<!--END PAGE CONTENT -->