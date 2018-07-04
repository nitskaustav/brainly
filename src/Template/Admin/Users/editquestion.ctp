<?php 
    //echo $questions->user_id;exit;
?>
<div id="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <h1 >Add Question</h1>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-th-large"></i></div>
                        <h5>Add Question</h5>
                        <div class="toolbar">
                            <ul class="nav">
                                <li style="margin-right:15px">
                                    <div class="btn-group"> 

                                        <a href="<?php echo $this->Url->build(["controller" => "Users","action" => "listquestion"]);?>"><button class="btn btn-xs btn-success close-box">
                                                <i class="icon-list"></i>List Question</button></a>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </header>
                    <div id="collapseOne" class="accordion-body collapse in body"> 
                        <div class="col-sm-6">
                            <div class="row">
				<?php echo $this->Form->create($user,['class' => 'form-horizontal', 'id' => 'user-validate', 'onsubmit' => "return validate();"]);?>
                                                                
                                <div class="form-block">

                                <div><h3><b>Question Information</b></h3></div>
                                <br>
                                <div><h4><b>Posted by: <?php echo $questions->user->username; ?></b></h4></div>
                                <br>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Question</label>
                                    <div class="col-lg-8">
                                        <textarea name="question" id="question_id" rows="10" cols="38"><?php echo $questions->question; ?></textarea>
                                        <!-- <?php echo $this->Form->input('question', array('class'=>'form-control','label' => false, 'id' => 'question')); ?> -->
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Assign Points</label>
                                    <div class="col-lg-8">
                                        <select class="form-control" name="point" id="point">
                                            <?php 
                                                for($i=10;$i<=100;$i+=5){
                                                    if($i == $questions->point){
                                                        $pointselect = ' selected';
                                                    }
                                                    else{
                                                        $pointselect = '';   
                                                    }
                                            ?>
                                            <option <?php echo $pointselect; ?>><?php echo $i; ?></option>                                 
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Select Subject</label>
                                    <div class="col-lg-8">
                                    <select class="form-control" name="subject_id" id="subject_id">
                                        <option value="">Select Subject</option>
                                        <?php foreach($subjects as $subject){ 
                                                if($subject->id == $questions->subject_id){
                                                    $quesselect = ' selected';
                                                }
                                                else{
                                                    $quesselect = '';
                                                }

                                            ?>
                                            <option value="<?php echo $subject->id; ?>" <?php echo $quesselect; ?>><?php echo $subject->name; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Choose Level</label>
                                    <div class="col-lg-8">
                                        <select class="form-control" name="level" id="level">
                                            <option value=''>Choose Level</option>
                                            <option <?php if($questions->level == 'Primary School') echo " selected"; ?>>Primary School</option>
                                            <option <?php if($questions->level == 'Secondary School') echo " selected"; ?>>Secondary School</option>
                                        </select>
                                    </div>
                                </div>                              
                              
                                <label class="control-label col-lg-4"></label>
                                <div class="col-lg-8" style="text-align:left;"> 
                                    <input type="submit" name="submit" value="Edit Question" class="btn btn-primary" />
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
</div>

<script type="text/javascript">
    function validate(){

        if($("#question_id").val().search(/\S/) == -1){
            alert("Please add question"); return false;
        }

        if($("#subject_id").val().search(/\S/) == -1){
            alert("Please choose subject"); return false;
        }

        if($("#level").val().search(/\S/) == -1){
            alert("Please choose level"); return false;
        }

        return true;
    }
</script>