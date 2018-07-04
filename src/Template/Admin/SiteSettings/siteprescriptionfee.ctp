<?php //pr($sitesettings); exit; ?>

  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
  <script>
    $(document).ready(function() {
        var markupStr = $('#summernote').summernote('code');
        var markupStr = $('.summernote').eq(1).summernote('code');
        $('#summernote').summernote('code', markupStr);
        //$('#summernote').summernote('fontSize', 20);

        $('#prescription_fee').summernote({
            defaultFontName: 'Lato',
            height: 300,                 // set editor height
            width: 780,
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
  </script>

<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Edit Site Prescription Fees </h1>
            </div>
        </div>
        <hr />
	  <?php //echo $this->Flash->render('success') ?>
	  <?php //echo $this->Flash->render('error') ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5> Edit Site Prescription Fees </h5>
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
                        <div class="col-sm-12">
                            <div class="row">
				  <?php echo $this->Form->create($sitesettings,['class' => 'form-horizontal', 'id' => 'presc-validate', 'type' => 'post', 'enctype' => 'multipart/form-data']);?>
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Prescription Fee</label>
                                    <div class="col-lg-9">
                                        <input type="text" id="prescfee" name="prescfee" class="form-control" value="<?php echo $sitesettings->prescfee;?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3" for="autosize">Prescription Fee Description</label>
                                    <div class="col-lg-9">
                                        <textarea id="prescription_fee" name="prescription_fee" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 200px;"><?php echo $sitesettings->prescription_fee;?></textarea>
                                    </div>
                                </div>                                
                                <label class="control-label col-lg-3"></label>
                                <div class="col-lg-9" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Update Prescribtion Fees" class="btn btn-primary" />
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