<?php echo $this->Html->script('/plugins/dataTables/jquery.dataTables.js')?>
<?php echo $this->Html->script('/plugins/dataTables/dataTables.bootstrap.js')?>

<script type="text/javascript">
  window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      title:{
        text: "Statistics (<?php echo $timeperiod;?>)"
      },
      data: [

      {
        dataPoints: [
        { x: 1, y: <?php echo $countuser ?>, label: "User"},
        { x: 2, y: <?php echo $countservice ?>,  label: "Services" },
        { x: 3, y: <?php echo $countserviceverified ?>,  label: "Verified service providers"},
        { x: 4, y: <?php echo $countreview ?>,  label: "reviews"},
        { x: 5, y: <?php echo $countallvisitor ?>,  label: "Visitors"}
        
        ]
      }
      ]
    });

    chart.render();
  }
  </script>
  <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
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
                <h1 > Statistics </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5> Statistics</h5>
                        <div class="toolbar">
                            
                        </div>
                    </header>
                    <div class="accordion-body collapse in body">
                        <div class="col-sm-12">
                            <div class="row">  
                                <?php echo $this->Form->create('Filter', array('class'=>'form-inline','type'=>'get','id'=>'search_form'));?>
                                <div class="form-group">
                                    <select class="form-control" name='day' onclick="search()">
                                        <option value=''>All</option>
                                        <option value='1' <?php if($_REQUEST['day']==1){echo 'selected';} ?>> Today</option>
                                        <option value='7' <?php if($_REQUEST['day']==7){echo 'selected';} ?>>Past 7 days</option>
                                        <option value='30' <?php if($_REQUEST['day']==30){echo 'selected';} ?>>Past 30 days</option>
                                        <option value='365' <?php if($_REQUEST['day']==365){echo 'selected';} ?>>1 Year</option>
<!--                                        <option value='90'>Past 90 days</option>-->
                                    </select>
                                  
                                </div>
                                <!--<button type="submit" class="btn btn-success" style='margin-top:7px;margin-bottom:6px;'>Search</button>-->
<!--                                <button type="button" class="btn btn-success" style="margin-top:7px;margin-bottom:6px;" onclick="resetForm()">Clear Search</button>-->

                                <?php echo $this->Form->end();?>
                            </div>
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
<!--                                                       <th><?php echo $this->Paginator->sort('slno') ?></th>-->
                                                       <th><?php echo $this->Paginator->sort('total user') ?></th>
                                                       
                                                       <th><?php echo $this->Paginator->sort('total services') ?></th>
                                                       <th><?php echo $this->Paginator->sort('total verified service providers') ?></th>
                                                       <th><?php echo $this->Paginator->sort('total reviews') ?></th>
                                                       <th><?php echo $this->Paginator->sort('total visitor') ?></th>
                                                       
                                                       
                                                   </tr>
                                               </thead>
                                               <tbody>
                                           <?php $i = 1;  ?>
                                                   <tr>
<!--                                                       <td><?php echo $this->Number->format($i) ?></td>-->
                                                       <td><?php echo $countuser ?></td>
                                                       <td><?php echo $countservice ?></td>
                                                       <td><?php echo $countserviceverified ?></td>
                                                       <td><?php echo $countreview ?></td>
                                                       <td><?php echo $countallvisitor ?></td>
                                                         
                                                                      
                                                   </tr>
                                           <?php $i++;  ?>
                                               </tbody>
                                           </table>
                                            
                                            <div id="chartContainer" style="height: 300px; width: 100%;">
   </div>
<!--                                            <div class="paginator">
                                                <ul class="pagination">
                                            <?php echo $this->Paginator->prev('< ' . __('previous')) ?>
                                            <?php echo $this->Paginator->numbers() ?>
                                            <?php echo $this->Paginator->next(__('next') . ' >') ?>
                                                </ul>
                                                <p><?php //echo $this->Paginator->counter() ?></p>
                                            </div>-->
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
 
 function search(){
     
   $('#search_form').submit();  
     
    
 }



</script> 



<!--END PAGE CONTENT -->