<?php //pr($user); //exit; ?>
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
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
  </script>

<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 > Add Club </h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Add Club</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group"> 
                                        <a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "add"]); ?>">
                                            <button class="btn btn-xs btn-success close-box"> <i class="icon-plus"></i> Add Club</button></a>
                                        <a href="<?php echo $this->Url->build(["controller" => "Users","action" => "listclub"]);?>"><button class="btn btn-xs btn-success close-box">
                                                <i class="icon-list"></i>List Club</button></a>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body">
                        <div class="col-sm-6">

                            <div class="row">
                                <?php echo $this->Form->create($user, ['class' => 'form-horizontal', 'id' => 'user-validate', 'enctype' => 'multipart/form-data']); ?>
                                <input type="hidden" id="utype" name="utype" class="form-control" value="2"/>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Gender</label>
                                    <div class="col-lg-8">
                                        <?php 
                                        $options = ['Male' => 'Male', 'Female' => 'Female'];
                                        $attributes = ['legend' => true, 'value' => $user->gender];
                                        echo $this->Form->radio('gender', $options, $attributes);
                                        ?>
                                    </div>
                                </div>                                

                                <div class="form-group">
                                    <label class="control-label col-lg-4">First Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo $user->first_name ?>"/>
                                    </div>
                                </div>  

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Last Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo $user->last_name ?>"/>
                                    </div>
                                </div>  

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Club Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="club_name" name="club_name" class="form-control" value="<?php echo $user->club_name ?>"/>
                                    </div>
                                </div>                                

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Phone</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $user->name ?><?php echo $user->phone ?>"/>
                                    </div>
                                </div>                                

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Email</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="email" name="email" class="form-control" value="<?php echo $user->email ?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Password</label>
                                    <div class="col-lg-8">
                                        <input type="password" id="password" name="password" class="form-control" value=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Details</label>
                                    <div class="col-lg-8">
                                        <textarea class="form-control ckeditor" id="editor1" style="width: 400px; height: 200px;" name="details"><?php echo $user->details ?></textarea>
                                       
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Address</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="address" name="address" class="form-control" value="<?php echo $user->address ?>"/>
                                    </div>
                                </div>                                
                                <!--
                                <div class="form-group">
                                    <label class="control-label col-lg-4">City</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="first_name" name="city" class="form-control" value="<?php echo $user->city ?>"/>
                                    </div>
                                </div>                                
                                
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Country</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="first_name" name="country" class="form-control" value="<?php echo $user->country ?>"/>
                                    </div>
                                </div>
                                -->
                                <div class="form-group">
                                  <label class="control-label col-lg-4">User Image </label>
                                  <div class="col-lg-8">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
                                            <?php $filePath = WWW_ROOT . 'user_img' .DS. $user->pimg; ?>
                                            <?php if ($user->pimg != "" && file_exists($filePath)) { ?>
                                                <img src="<?php echo $this->Url->build('/user_img/'.$user->pimg); ?>" width="150px" height="150px" />
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
                                    <input type="submit" name="submit" value="Edit Tenant" class="btn btn-primary" />
                                </div>
                                <?php echo $this->Form->end();?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $this->request->webroot;?>js/bootstrap-datepicker.js"></script>
<script>
$(document).ready(function(){
    $('.subdate').datepicker({
    format:"yyyy-mm-dd",
    startDate:"today"
    });
});
</script>
<style>
    .datepicker{
        background:white !important;
    }    
</style>    