<!-- MENU SECTION -->
<?php ?>
<div id="left" >
    <div class="media user-media well-small"> <a class="user-link" href="javascript:void(0);"> 

        </a> <br />
        <div class="media-body">
            <h5 class="media-heading"> <?php echo $SiteSettings['site_title']; ?> Admin </h5>
            <ul class="list-unstyled user-info">
                <li> <!-- <a class="btn btn-success btn-xs btn-circle" style="width: 10px;height: 12px;"></a> Online --> </li>
            </ul>
        </div>
        <br />
    </div>
    <ul id="menu" class="collapse" style=" width:100%; margin-top:30px;">
        <li class="panel <?php if ($this->request->params['action'] == 'home') { ?> active <?php } else { ?><?php } ?>"> <a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "home"]); ?>" >  Dashboard </a> </li>


        <!----------------- Site Settings Start ------------------------>

        <!-- <li class="panel <?php if ($this->request->params['controller'] == 'SiteSettings') { ?> active <?php } else { ?><?php } ?>"> 
            <a href="javascript:void(0)" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed" data-target="#sitesettings"> Site Settings </a>
            <ul class="<?php echo $this->request->params['controller'] == 'SiteSettings' ? 'in' : 'collapse' ?>" id="sitesettings">
                <li class=""><a href="<?php echo $this->Url->build(["controller" => "SiteSettings", "action" => "logo"]); ?>"><i class="icon-angle-right"></i> Logo Management </a></li>

                <li class=""><a href="<?php echo $this->Url->build(["controller" => "SiteSettings", "action" => "sitedetail"]); ?>"><i class="icon-angle-right"></i> Site Settings </a></li>

                <li class=""><a href="<?php echo $this->Url->build(["controller" => "SiteSettings", "action" => "sitesociials"]); ?>"><i class="icon-angle-right"></i> Social Settings </a></li>




            </ul>
        </li>  -->

        <!----------------- Site Settings End ------------------------>



       

    





        <!----------------- User Management Start ------------------------>

        <li class="panel <?php if (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'listuser') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'add') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'edituser') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'userdelete') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'userview')) { ?> active <?php } else { ?><?php } ?>"> 
            <a href="javascript:void(0)" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed" data-target="#users"> Users Management </a>
            <ul class="<?php if (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'listuser') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'add') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'edituser') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'userdelete') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'userview')) { ?> in <?php } else { ?> collapse <?php } ?>" id="users">
                <li class=""><a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "listuser"]); ?>"><i class="icon-angle-right"></i> Users List </a></li>					
                <li class=""><a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "add"]); ?>"><i class="icon-angle-right"></i> Add Users </a></li>
            </ul>
        </li>

        <!----------------- Users Management End ------------------------>


        

        <!----------------- Subject Management Start ------------------------>

        <li class="panel <?php if (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'listsubject') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'addsubject') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'editsubject') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'subjectdelete') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'subjectview')) { ?> active <?php } else { ?><?php } ?>"> 
            <a href="javascript:void(0)" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed" data-target="#subject"> Subject Management </a>
            <ul class="<?php if (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'listsubject') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'addsubject') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'editsubject') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'subjectdelete') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'subjectview')) { ?> in <?php } else { ?> collapse <?php } ?>" id="subject">
                <li class=""><a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "listsubject"]); ?>"><i class="icon-angle-right"></i> Subject List </a></li>					
                <li class=""><a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "addsubject"]); ?>"><i class="icon-angle-right"></i> Add Subject</a></li>
            </ul>
        </li>

        <!----------------- Subject Management End ------------------------>

        <!----------------- Question Management Start ------------------------>

        <li class="panel <?php if (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'listquestion') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'addquestion') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'editquestion') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'questiondelete')) { ?> active <?php } else { ?><?php } ?>"> 
            <a href="javascript:void(0)" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed" data-target="#question"> Question Management </a>
            <ul class="<?php if (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'listquestion') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'addquestion') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'editquestion') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'questiondelete')) { ?> in <?php } else { ?> collapse <?php } ?>" id="question">
                <li class=""><a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "listquestion"]); ?>"><i class="icon-angle-right"></i> Question List </a></li>                   
                <li class=""><a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "addquestion"]); ?>"><i class="icon-angle-right"></i> Add Question</a></li>
            </ul>
        </li>

        <!----------------- Question Management End ------------------------>


        <!----------------- Question Management Start ------------------------>

        <li class="panel <?php if (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'listanswer') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'viewanswer') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'manageanswer') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'answerdelete')) { ?> active <?php } else { ?><?php } ?>"> 
            <a href="javascript:void(0)" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed" data-target="#answer"> Answer Management </a>
            <ul class="<?php if (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'listanswer') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'viewanswer') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'manageanswer') || ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'answerdelete')) { ?> in <?php } else { ?> collapse <?php } ?>" id="answer">
                <li class=""><a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "listanswer"]); ?>"><i class="icon-angle-right"></i> Answer List </a></li>                   
                <!-- <li class=""><a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "addquestion"]); ?>"><i class="icon-angle-right"></i> Add Question</a></li> -->
            </ul>
        </li>

        <!----------------- Question Management End ------------------------>

         

        <!----------------- Rating Review Start -------------------------------->

        <!-- <li class="panel <?php if (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'reviewrating')) { ?> active <?php } else { ?> '' <?php } ?>"> 
            <a href="javascript:void(0)" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed" data-target="#review"> Review Management </a>
            <ul class="<?php if ($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'reviewrating') { ?> in <?php } else { ?> collapse <?php } ?>" id="review">
                <li class=""><a href="<?php echo $this->Url->build(["controller" => "Users", "action" => "reviewrating"]); ?>"><i class="icon-angle-right"></i> Review List </a></li>                    
            </ul>
        </li> -->

        <!----------------- Rating Review End -------------------------------->



        <!----------------- Contents Management Start -------------------------------->

        <li class="panel <?php if ($this->request->params['controller'] == 'Contents') { ?> active <?php } else { ?> '' <?php } ?>"> 
            <a href="javascript:void(0)" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed" data-target="#contents"> Contents </a>
            <ul class="<?php echo $this->request->params['controller'] == 'Contents' ? 'in' : 'collapse' ?>" id="contents">
                <li class=""><a href="<?php echo $this->Url->build(["controller" => "Contents", "action" => "index"]); ?>"><i class="icon-angle-right"></i> Contents List </a></li>					
            </ul>
        </li>  

        <!----------------- Contents Management End -------------------------------->




        <!----------------- Email Templates Management  Start -------------------------------->

        <li class="panel <?php if ($this->request->params['controller'] == 'EmailTemplates') { ?> active <?php } else { ?> '' <?php } ?>"> 
            <a href="javascript:void(0)" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed" data-target="#email_tpl"> Email Templates </a>
            <ul class="<?php echo $this->request->params['controller'] == 'EmailTemplates' ? 'in' : 'collapse' ?>" id="email_tpl">
                <li class=""><a href="<?php echo $this->Url->build(["controller" => "EmailTemplates", "action" => "index"]); ?>"><i class="icon-angle-right"></i> Email Templates List </a></li>					
            </ul>
        </li>   

        <!----------------- Email Templates Management End -------------------------------->

        

        <!----------------- FAQ Management Start ------------------------>

        <li class="panel <?php if ($this->request->params['controller'] == 'Faqs') { ?> active <?php } else { ?><?php } ?>"> 
            <a href="javascript:void(0)" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed" data-target="#faq"> FAQ </a>
            <ul class="<?php echo $this->request->params['controller'] == 'Faqs' ? 'in' : 'collapse' ?>" id="faq">
                <li class=""><a href="<?php echo $this->Url->build(["controller" => "Faqs", "action" => "index"]); ?>">
                        <i class="icon-angle-right"></i> FAQ List </a></li>                 
                <li class=""><a href="<?php echo $this->Url->build(["controller" => "Faqs", "action" => "add"]); ?>">
                        <i class="icon-angle-right"></i> Add FAQ </a></li>   
            </ul>
        </li> 

        <!----------------- FAQ Management End ------------------------>

        <!----------------- Testimonial Start ------------------------>

        <li class="panel <?php if ($this->request->params['controller'] == 'Testimonials') { ?> active <?php } else { ?><?php } ?>"> 
            <a href="javascript:void(0)" data-parent="#menu" data-toggle="collapse" class="accordion-toggle collapsed" data-target="#testimoliak"> Testimonials </a>
            <ul class="<?php echo $this->request->params['controller'] == 'Testimonials' ? 'in' : 'collapse' ?>" id="testimoliak">
                <li class=""><a href="<?php echo $this->Url->build(["controller" => "Testimonials", "action" => "index"]); ?>">
                        <i class="icon-angle-right"></i> Testimonial List </a></li>                 
                <li class=""><a href="<?php echo $this->Url->build(["controller" => "Testimonials", "action" => "add"]); ?>">
                        <i class="icon-angle-right"></i> Add Testimonial </a></li>   
            </ul>
        </li> 

        <!----------------- Testimonial End ------------------------>

        
    </ul>
</div>
<!--END MENU SECTION --> 