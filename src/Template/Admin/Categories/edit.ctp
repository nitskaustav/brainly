<?php
//print_r($category->name);
//exit; 
?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Category </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Edit Category</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group"> 
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-6">

                            <div class="row">
                                <?php echo $this->Form->create($category, ['class' => 'form-horizontal', 'id' => 'cat-validate', 'enctype' => 'multipart/form-data']); ?>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">  Name </label>
                                    <?php echo '<div class="col-lg-8">' . $this->Form->input('name', array('class' => 'form-control', 'label' => false, 'style' => 'width:800px', 'value' => $category->name)) . '</div>'; ?>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-lg-4">Slider Image </label>
                                    <div class="col-lg-8">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                                <?php $filePath = WWW_ROOT . 'category_img' . DS . $category->path; ?>
                                                <?php if ($category->path != "" && file_exists($filePath)) { ?>
                                                    <img src="<?php echo $this->Url->build('/category_img/' . $category->path); ?>" width="150px" height="150px" />
                                                <?php } ?>
                                            </div>
                                            <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                                    <input type="file" id="image" name="image" />
                                                </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                        </div>
                                    </div>
                                </div> 


                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Edit Category" class="btn btn-primary" />
                                </div>
                                </form>
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
    $(document).ready(function () {
        $("#name").blur(function () {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
            $("#slug").val(Text + '-health');
        });
    });
</script>
