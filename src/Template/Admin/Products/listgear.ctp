<?php
 // echo "<pre>";
 // print_r($gears); exit();
 // foreach ($gears as $gear) {
 //    $product_pic_array = explode(",", $gear->upload);
 //    echo $upload_pic = $product_pic_array[0];echo "<br>";
 //     # code...
 // }
 // exit();
echo $this->Html->script('/plugins/dataTables/jquery.dataTables.js');?>
<?php echo $this->Html->script('/plugins/dataTables/dataTables.bootstrap.js'); ?>
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
                <h1 > Gear List </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5> Gear List</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group" style=" margin-top: 8px">
                                        <a href="<?php echo $this->Url->build(["action" => "addgear"]); ?>"> <button class="btn btn-info btn-xs"><i class="icon-cogs icon-white"></i> Add Gear </button>  </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </header>
                    <div class="accordion-body collapse in body"><div>
                    <div id="collapseOne" class="accordion-body collapse in body">
                    </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Image</th>
            <th>Category</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php $i = 1; foreach ($gears as $gear):
        // $product_pic_array = explode(",", $gear->upload);
        // $upload_pic = $product_pic_array[0];
        $filename = WWW_ROOT.'gear_img/'.$gear->upload;

        if(!file_exists($filename) || $gear->upload == ''){
         $gear->upload = 'no-image.png';
        }
    ?>
    <tr>
        <td><img src="<?php echo $this->Url->build('/gear_img/'.$gear->upload); ?>" alt="" class="img-fluid" width="140px" height="80px"></td>
        <td><?php echo $gear->category->name;?></td>
        <td><?php echo $gear->product_name;?></td>
        <td>$<?php echo $gear->price;?></td>
        <td class="actions">
            <a href="<?php echo $this->Url->build(["action" => "editgear", $gear->id]); ?>"> <button class="btn btn-primary btn-xs"><i class="icon-pencil icon-white"></i> Edit</button>  </a>
               <a href="<?php echo $this->Url->build(["action" => "geardelete", $gear->id]); ?>" onclick="return confirm('Are you sure you want to delete?');"> <button class="btn btn-danger btn-xs"><i class="icon-remove icon-white"></i> Delete</button> </a>
            <?php if ($gear->is_active == 'Y') { ?><a href="<?php echo $this->Url->build(["action" => "chstatusgear", $gear->id, 'N']); ?>"> <button class="btn btn-success btn-xs"><i class="icon-thumbs-down"></i> Active</button> </a>
            <?php } else if ($gear->is_active == 'N') { ?><a href="<?php echo $this->Url->build(["action" => "chstatusgear", $gear->id, 'Y']); ?>"> <button class="btn btn-info btn-xs"><i class="icon-thumbs-up"></i> InActive</button> </a>
            <?php } ?>
        </td>
    </tr>
    <?php $i++; endforeach; ?>
</table>
                                            <div class="paginator">
                                                <ul class="pagination">
                                                <?php echo $this->Paginator->prev('< ' . __('previous')) ?>
                                                <?php echo $this->Paginator->numbers() ?>
                                                <?php echo $this->Paginator->next(__('next') . ' >') ?>
                                                </ul>
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