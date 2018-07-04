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

<?php
/*echo "<pre>";
print_r($user);
print_r($sizes);
print_r($brands);
print_r($categories);
die;*/

$brand_id_array = explode(",", $user->brand_ids);
$size_id_array = explode(",", $user->size_ids);


?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Add Attribute </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Add Attribute</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group"> 

                                        <a href="<?php echo $this->Url->build(["controller" => "Attributes","action" => "listattribute"]);?>"><button class="btn btn-xs btn-success close-box">
                                                <i class="icon-list"></i>List Attribute</button></a>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-6">

                            <div class="row">
                                <?php echo $this->Form->create($user, ['class' => 'form-horizontal', 'type' => 'file', 'id' => 'user-validate']); ?>

                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Select Category  </label>
                                    <div class="col-lg-8">

                                        <select class="form-control" name="category_id" required="" style ='width:800px'>
                                            <option value="">Choose Category</option>
                                            <?php foreach ($categories as $dt) {
                                                    if($user->category_id == $dt->id)
                                                        $selected = ' selected';
                                                    else
                                                        $selected = '';
                                                ?>

                                                <option value="<?php echo $dt->id; ?>" <?php echo $selected; ?>><?php echo $dt->name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Select Brand </label>
                                    <div class="col-lg-8">
                                        <?php
                                            foreach($brands as $brand_val){ 
                                                if(in_array($brand_val->id, $brand_id_array))
                                                    $brand_checked = ' checked';
                                                else
                                                    $brand_checked = '';

                                                ?>
                                                <input type="checkbox" name="brand_ids[]" value="<?php echo $brand_val->id; ?>" <?php echo $brand_checked; ?>><?php echo $brand_val->brand_name; ?><br>
                                               
                                        <?php } ?>
                                    </div>
                                </div>

                                

                                <div class="form-group">
                                    <label class="control-label col-lg-4"> Select Size </label>
                                    <div class="col-lg-8">
                                        <?php
                                            foreach($sizes as $sizes_val){
                                                if(in_array($sizes_val->id, $size_id_array))
                                                    $size_checked = ' checked';
                                                else
                                                    $size_checked = '';
                                             ?>
                                                <input type="checkbox" name="size_ids[]" value="<?php echo $sizes_val->id; ?>" <?php echo $size_checked;  ?>><?php echo $sizes_val->size; ?><br>
                                               
                                        <?php } ?>
                                    </div>
                                </div>

                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Edit Attribute" class="btn btn-primary" />
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


