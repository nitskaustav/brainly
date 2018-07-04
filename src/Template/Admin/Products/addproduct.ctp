<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
<script>
    $(document).ready(function () {
        var markupStr = $('#summernote').summernote('code');
        var markupStr = $('.summernote').eq(1).summernote('code');
        $('#summernote').summernote('code', markupStr);
        //$('#summernote').summernote('fontSize', 20);

        $('#description').summernote({
            defaultFontName: 'Lato',
            height: 300, // set editor height
            width: 950,
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: true, // set focus to editable area after initializing summernote
            popover: {
                image: [
                    ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                    ['float', ['floatLeft', 'floatRight', 'floatNone']],
                    ['remove', ['removeMedia']]
                ],
                link: [
                    ['link', ['linkDialogShow', 'unlink']]
                ],
                air: [
                    ['color', ['color']],
                    ['font', ['bold', 'underline']],
                    ['fontsize', ['8', '9', '10', '11', '12', '14', '18', '24', '36']],
                    ['para', ['ul', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']]
                            ['style', ['style']],
                    ['text', ['bold', 'italic', 'underline', 'color', 'clear']],
                    ['para', ['paragraph']],
                    ['height', ['height']],
                    ['font', ['Lato', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather']],
                ]
            },
            onblur: function () {
                var text = $('#editor').code();
                text = text.replace("<br>", " ");
                $('#description').val(text);
            }

        });
        //alert();

    });

</script>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Add Product </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Add Product</h5>
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
                                <?php echo $this->Form->create('products', ['class' => 'form-horizontal', 'type' => 'file', 'id' => 'user-validate', 'enctype' => "multipart/form-data",'onsubmit' => "return validate();"]); ?>

                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Select Seller  </label>
                                    <div class="col-lg-8">
                                        <select class="form-control" name="seller_id" id="seller_id"  style ='width:800px'>
                                            <option value="">Choose Seller</option>
                                            <?php foreach ($seller as $dt) {
                                                ?>

                                                <option value="<?php echo $dt->id; ?>"><?php echo $dt->first_name." ".$dt->last_name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label class="control-label col-lg-4"> Select Category  </label>
                                    <div class="col-lg-8">

                                        <select class="form-control" name="category_id"  style ='width:800px'>
                                            <option value="">Choose Category</option>
                                            <?php foreach ($categories as $dt) {
                                                ?>

                                                <option value="<?php echo $dt->id; ?>"><?php echo $dt->name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Product Name </label>
                                    <?php echo '<div class="col-lg-8">' . $this->Form->input('product_name', array('class' => 'form-control', 'label' => false, 'style' => 'width:800px')) . '</div>'; ?>
                                </div>

                                <!--<div class="form-group">
                                    <label class="control-label col-lg-4"> Description </label>
                                <?php echo '<div class="col-lg-8">' . $this->Form->input('description', array('class' => 'form-control', 'id' => "description", 'label' => false, 'style' => 'width:800px')) . '</div>'; ?>
                                </div>-->

                                <div class="form-group">
                                    <label class="control-label col-lg-4">  Description </label>
                                    <div class="col-lg-8">

                                        <?php //echo $this->Form->input('description', array('class' => 'form-control', 'id' => "description", 'label' => false, 'style' => 'width:800px')); ?> 
                                        <textarea class="form-control" name="description" id="description"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Model  </label>
                                    <div class="col-lg-8"><select class="form-control" name="model_id"  style ='width:800px'>
                                            <option value="">Choose Model</option>
                                            <?php foreach ($models as $dt) {
                                                ?>

                                                <option value="<?php echo $dt->id; ?>"><?php echo $dt->model_name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4"> CC </label>
                                    <?php echo '<div class="col-lg-8">' . $this->Form->input('cc', array('class' => 'form-control', 'label' => false, 'style' => 'width:800px')) . '</div>'; ?>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Price</label>
                                    <?php echo '<div class="col-lg-8">' . $this->Form->input('price', array('class' => 'form-control', 'label' => false, 'style' => 'width:800px')) . '</div>'; ?>
                                </div>



                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Mileage </label>
                                    <?php echo '<div class="col-lg-8">' . $this->Form->input('mileage', array('class' => 'form-control', 'label' => false, 'style' => 'width:800px')) . '</div>'; ?>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Color </label>
                                    <?php echo '<div class="col-lg-8">' . $this->Form->input('color', array('class' => 'form-control', 'label' => false, 'style' => 'width:800px')) . '</div>'; ?>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Electric Bike ? </label>
                                    <?php
                                    echo $this->Form->radio(
                                            'fuel_type', [
                                        ['value' => 'yes', 'text' => 'Yes'],
                                        ['value' => 'no', 'text' => 'No'],
                                            ]
                                    );
                                    ?>
                                </div>

                                <!--<div class="form-group">
                                    <label class="control-label col-lg-4"> Select Category</label>
                                <?php echo '<div class="col-lg-8">' . $this->Form->input('category_id', array('class' => 'form-control', 'label' => false, 'style' => 'width:800px', 'type' => 'select', 'options' => $categories)) . '</div>'; ?>
                                </div>-->


                                <!--<div class="form-group">
                                    <label class="control-label col-lg-4"> Upload image</label>
                                    <!-- <?php echo '<div class="col-lg-8">' . $this->Form->input('files', array('class' => 'form-control', 'label' => false, 'style' => 'width:800px', 'type' => 'file', 'multiple')) . '</div>'; ?>                                     <input type="file" name="file[]" multiple> 
                                </div> -->
                                <div class="form-group">

                                    <label class="control-label col-lg-4">Upload Photos</label>  
                                    <div class="company-images col-lg-8">

                                        <input type="hidden" name="image" id="image">
                                        <div class="fileUpload btn btn-primary">

                                            <input type="file"  id="multiFiles" name="files[]" multiple="multiple" class="upload"/>
                                        </div>

                                        <span id="status" ></span> 
                                    </div>
                                    <div class="form-group">

                                        <label class="control-label col-lg-4"></label>  
                                        <div class="company-images col-lg-8">

                                            <div class="manage-photo col-lg-8" id="product_images" style="overflow:scroll; height:350px;width:800px;">


                                                <ul id="sortable" class="uisortable">
                                                </ul>


                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Add Product" class="btn btn-primary" />
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

        $('#multiFiles').on('change', function () {

            var image_url = '<?php echo $this->Url->build('/product_img/'); ?>';

            var form_data = new FormData();
            var ins = document.getElementById('multiFiles').files.length;
            // alert(ins);
            //alert(JSON.stringify(document.getElementById('multiFiles')));
            for (var x = 0; x < ins; x++) {
                form_data.append("files[]", document.getElementById('multiFiles').files[x]);
                //alert('ok');
                // alert(JSON.stringify(document.getElementById('multiFiles').files[x]));
            }
            //console.log(form_data);
            $.ajax({
                url: 'upload_photo_add', // point to server-side PHP script 
                dataType: 'text', // what to expect back from the PHP script
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (response) {
                    console.log(response);
                    var obj = jQuery.parseJSON(response);

                    if (obj.Ack == 1) {

                        //alert('ok');
                        $('#product_image_id').val(obj.image_name);
                        for (var i = 0; i < obj.data.length; i++) {
                            file_path = image_url + obj.data[i].filename;
                            $('<li id="' + obj.data[i].last_id + '"></li>').appendTo('#sortable').html('<div class="media" id="image_' + obj.data[i].last_id + '"><div class="media-left"><a href="#"><img style="width: 100px; height: 100px" src="' + file_path + '" alt="" /></a></div><div class="media-body media-middle"><h4>' + obj.data[i].filename + '</h4></div><div class="media-body media-middle"></div></div></div></li>');
                        }
                    }
                },
                error: function (response) {
                    $('#msg').html(response); // display error response from the PHP script
                }
            });
        });

    });

</script>  
<script type="text/javascript">
    function validate(){
        //alert("H");return false;

        if($('#seller_id').val().search(/\S/) == -1){
            alert("Select seller"); return false;
        }
    }
</script>

