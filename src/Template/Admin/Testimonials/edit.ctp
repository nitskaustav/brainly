<?php //pr($user); //exit;            ?>
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
    });
</script>

<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Edit Testimonial </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Edit Testimonial</h5>
                        <div class="toolbar">

                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-6">

                            <div class="row">
                                <?php echo $this->Form->create($testimonial, ['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data']); ?>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">User Name</label>
                                    <div class="col-lg-8">
                                        <select name="user_id" class="form-control">
                                            <?php
                                            foreach ($users as $user) {
                                                // echo $user->id;
                                                if ($user->id == $testimonial->user_id) {
                                                    $selected = 'selected';
                                                } else {
                                                    $selected = '';
                                                }
                                                echo '<option value="' . $user->id . ' "' . $selected . ' >' . $user->full_name . '</option>';
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>                            
                                <!--
                                                                <div class="form-group">
                                                                    <label class="control-label col-lg-4">Title</label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" id="first_name" name="event_name" class="form-control" value="<?php echo $testimonial->title ?>"/>
                                                                    </div>
                                                                </div>  
                                -->
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Description</label>
                                    <div class="col-lg-8">

                                        <?php echo $this->Form->input('description', array('class' => 'form-control', 'id' => "description", 'label' => false, 'style' => 'width:800px', 'value' => $testimonial->description)); ?>
                                    </div>
                                </div>

                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Edit Events" class="btn btn-primary" />
                                </div>
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .datepicker{
        background:white !important;
    }    
</style>    