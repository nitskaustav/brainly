<?php ?> 


<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Add Category </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Add Category</h5>
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
                                <?php echo $this->Form->create('category', ['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data']); ?>

                                <input type="hidden" name="parent_id" id="parent_id" value="0" />

                                <div class="form-group">
                                    <label class="control-label col-lg-4">  Name </label>
                                    <?php echo '<div class = "col-lg-8">' . $this->Form->input('name', array('class' => 'form-control', 'label' => false, 'style' => 'width:800px')) . '</div>'; ?>
                                </div>

                                <div class="form-group"> 
                                    <label class="control-label col-lg-4">User Image </label>
                                    <div class="col-lg-8">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-preview thumbnail" style="width: 150px; height: 150px;">
                                            </div>
                                            <div> <span class="btn btn-file btn-success"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                                                    <input type="file" id="image" name="image" />
                                                </span> <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a> </div>
                                        </div>
                                    </div>
                                </div>


                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Add Category" class="btn btn-primary" />
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
        /*
         $("#name").keyup(function(){
         var Text = $(this).val();
         Text = Text.toLowerCase();
         var regExp = /\s+/g;
         Text = Text.replace(regExp,'-');
         $("#slug").val(Text);        
         }); 
         */

        $("#name").keyup(function () {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
            $("#slug").val(Text);
        });
    });
</script>


<!--
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">

            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                  <div class="box">
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-6">
                            <div class="row">
<?php //echo $this->Form->create($doctor)  ?>
<?php echo $this->Form->create($doctor, ['class' => 'form-horizontal', 'id' => 'admin-validate']); ?>
                                <fieldset>
                                    <legend><?php echo __('Add Doctor') ?></legend>
<?php
echo '<div class = "form-group">' . $this->Form->input('first_name', array('class' => 'form-control')) . '</div>';
echo '<div class = "form-group">' . $this->Form->input('last_name', array('class' => 'form-control')) . '</div>';
echo '<div class = "form-group">' . $this->Form->input('username', array('class' => 'form-control')) . '</div>';
echo '<div class = "form-group">' . $this->Form->input('password', array('class' => 'form-control')) . '</div>';
echo '<div class = "form-group">' . $this->Form->input('phone', array('class' => 'form-control')) . '</div>';
echo '<div class = "form-group">' . $this->Form->input('email', array('class' => 'form-control')) . '</div>';
?>
                                </fieldset>


                                <fieldset>
                                    <button type="submit" class="btn btn-primary" style="margin-top: 15px">Add Doctor</button>
                                </fieldset> 



<?php //echo $this->Form->button(__('Add Doctor           '))   ?>
<?php echo $this->Form->end() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->