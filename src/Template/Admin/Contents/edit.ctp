<?php echo $this->Html->script('ckeditor/ckeditor.js') ?>


  <!-- <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
  <script>
    $(document).ready(function() {
        var markupStr = $('#summernote').summernote('code');
        var markupStr = $('.summernote').eq(1).summernote('code');
        $('#summernote').summernote('code', markupStr);
        //$('#summernote').summernote('fontSize', 20);

        $('#editor1').summernote({
            defaultFontName: 'Lato',
            height: 300,                 // set editor height
            width: 950,
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: true,                  // set focus to editable area after initializing summernote
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
                          ['para', [ 'paragraph']],
                          ['height', ['height']],
                          ['font', ['Lato','Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather']],
                        ]
                      },
            onblur: function() {
                var text = $('#editor').code();
                text = text.replace("<br>", " ");
                $('#description').val(text);
            }
          
        });
    });
  </script> -->


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
                <div class="col-sm-8>
                    <div class="row">
                        <?php //echo $this->Form->create($content) ?>
                        <?php echo $this->Form->create($content,['class' => 'form-horizontal', 'id' => 'admin-validate']);?>
                        <fieldset>
                            <legend><?php echo __('Edit Content') ?></legend>
                            <?php
                                echo '<div class="form-group">'.$this->Form->input('page_slug', array('class'=>'form-control','readonly')).'</div>';
                                echo '<div class="form-group">'.$this->Form->input('page_title', array('class'=>'form-control')).'</div>';
                                echo '<div class="form-group">'.$this->Form->input('meta_title', array('class'=>'form-control')).'</div>';
                                echo '<div class="form-group">'.$this->Form->input('meta_key', array('class'=>'form-control')).'</div>';
                                echo '<div class="form-group">'.$this->Form->input('meta_description', array('class'=>'form-control')).'</div>';
                            ?>
                        </fieldset>

                        <fieldset>
                            <legend><?php echo __('Content') ?></legend>
                            <textarea class="form-control ckeditor" id="editor1" rows="6" name="content"><?php echo $content->content ;?></textarea>
                        </fieldset>

                        <fieldset>
                            <button type="submit" class="btn btn-primary" style="margin-top: 15px">Edit CMS</button>
                        </fieldset>

                        <?php //echo $this->Form->button(__('Submit')) ?>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
