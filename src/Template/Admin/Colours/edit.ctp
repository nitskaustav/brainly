<?php
//print_r($category->name);
//exit; 
?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Colour </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Edit Colour</h5>
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
                                <?php echo $this->Form->create($colour, ['class' => 'form-horizontal', 'id' => 'cat-validate', 'enctype' => 'multipart/form-data', 'onsubmit' => "return validate();"]); ?>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">  Name </label>
                                    <?php echo '<div class="col-lg-8">' . $this->Form->input('name', array('class' => 'form-control', 'label' => false, 'style' => 'width:800px', 'value' => $colour->name, 'id' => 'name')) . '</div>'; ?>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">  Hexcode </label>
                                    <?php echo '<div class="col-lg-8">' . $this->Form->input('hexcode', array('class' => 'form-control', 'label' => false, 'style' => 'width:800px', 'value' => $colour->hexcode, 'id' => 'hexcode')) . '</div>'; ?>
                                </div>

                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Edit" class="btn btn-primary" />
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

<script type="text/javascript">
    function validate(){
        //alert("H"); return false;

        if($("#name").val().search(/\S/) == -1){
            alert("Please provide colour name"); return false;
        }

        if($("#hexcode").val().search(/\S/) == -1){
            alert("Please provide hexcode"); return false;
        }

        return true;
    }
</script>