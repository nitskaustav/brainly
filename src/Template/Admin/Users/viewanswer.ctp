<?php
// echo "<pre>";
// print_r($questions);
// print_r($answers);

// // echo $questions->id;

// exit;
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
                <h1 > Answer List </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5> Answer List</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <!-- <div class="btn-group" style=" margin-top: 8px">
                                        <a href="<?php echo $this->Url->build(["action" => "addquestion"]); ?>"> <button class="btn btn-info btn-xs"><i class="icon-cogs icon-white"></i>Add Question</button></a>
                                    </div> -->
                                </li>
                            </ul>
                        </div>
                    </header>
                    <div class="accordion-body collapse in body">
                       <div>
                       		<h4><b>Posted by: <?php echo $questions->user->username; ?></b></h4>
                       </div>
                       <div>
                       		<h4><b>Subject: <?php echo $questions->subject->name; ?></b></h4>
                       </div>
                       <div>
                       		<h4><b>Question: <?php echo $questions->question; ?></b></h4>
                       </div>
                       <div>
                       		<h4><b>Level: <?php echo $questions->level; ?></b></h4>
                       </div>
                       <div>
                       		<h4><b>Point: <?php echo $questions->point; ?></b></h4>
                       </div>
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
           <th><?php echo $this->Paginator->sort('Answer') ?></th>
           
           <th><?php echo $this->Paginator->sort('Username') ?></th>
           
           
           
           
           <th class="actions"><?php echo __('View Answer') ?></th>
       </tr>
   </thead>
   <tbody>
<?php $i = 1; foreach ($answers as $doct): 
                // if($doct->answer_status == 0)
                //   $answer_status = 'Unanswered';
                // elseif($doct->answer_status == 1)
                //   $answer_status = 'Being answered';
                // elseif($doct->answer_status == 2)
                //   $answer_status = 'Answered';
?>
       <tr>
           <td><?php echo $this->Number->format($i) ?></td>
           <td><?php echo $doct->answer; ?></td>
           <td><?php echo $doct->user->username; ?></td>
           <td class="actions">
      
               <a href="<?php echo $this->Url->build(["action" => "viewanswer", $doct->id]); ?>"> <button class="btn-btn-info btn-xs"><i class="icon-eye-open"></i> View</button> </a>

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