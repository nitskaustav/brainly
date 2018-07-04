<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */?>
<!--
<div id="content">
<div class="inner" style="min-height: 700px;">
  <div class="row">
	<div class="col-lg-12">
	  <h1> Pharma Dashboard </h1>
	</div>
  </div>
  <hr />
  <div class="row">
	<div class="col-lg-12">	
	</div>
  </div>
    
  <hr />
</div>
</div>
-->
<!--PAGE CONTENT -->
<div id="content">
    <div class="inner" style="min-height: 700px;">
        <div class="row">
            <div class="col-lg-12">
                <h1> Admin Dashboard </h1>
            </div>
        </div>
        <hr />

        
        <!--BLOCK SECTION -->
        <div class="row">
            <div class="col-lg-12">
<!--                <div style="text-align: center;"> 
                   
                    <?php if(!empty($admin_permissions) && in_array(3, $admin_permissions))
                    { ?>
                    <a class="quick-btn" href="<?php echo $this->Url->build(["controller" => "Users", "action" => "listuser"]); ?>"> <i class="fa fa-user" aria-hidden="true"></i> <span> User </span> 
                        <span class="label label-success"><?php echo $total_user; ?></span> </a> 
                    <?php
                    } ?>
                    <?php if(!empty($admin_permissions) && in_array(19, $admin_permissions))
                    { ?>
                    <a class="quick-btn"  href="<?php echo $this->Url->build(["controller" => "Events", "action" => "index"]); ?>"> <i class="fa fa-th-list" aria-hidden="true"></i> <span> Events </span>
                        <span class="label label-success"><?php echo $total_property; ?></span> </a> 
                    <?php
                    } ?>
                    
            </div>-->


    <div class="row"> 
        <div class="col-sm-3">         
            <a class="quick-btn" href="<?php echo $this->Url->build(["controller" => "Users", "action" => "listuser"]); ?>">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span> User </span> 
                <span class="label label-success"><?php echo $total_user; ?></span>
            </a>
        </div>
        
        <div class="col-sm-3"> 
            <a class="quick-btn" href="<?php echo $this->Url->build(["controller" => "Users", "action" => "listquestion"]); ?>">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span> Questions Asked </span> 
                <span class="label label-success"><?php echo $total_questions_asked; ?></span>
            </a> 
        </div>

        <!-- <div class="col-sm-3"> 
            <a class="quick-btn" href="<?php echo $this->Url->build(["controller" => "Products", "action" => "index"]); ?>">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span> Bikes </span> 
                <span class="label label-success"><?php echo $total_bikes; ?></span>
            </a> 
        </div>

        <div class="col-sm-3"> 
            <a class="quick-btn" href="<?php echo $this->Url->build(["controller" => "Products", "action" => "listgear"]); ?>">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span> Gears </span> 
                <span class="label label-success"><?php echo $total_gears; ?></span>
            </a> 
        </div> -->

    </div>
</div>
        <!--END BLOCK SECTION -->        
        
       
        

        <!---
        <div class="row">
            <form id='ChartForm'>
                <input type='hidden' name="type" value="daily">
                <input type='hidden' name="start_date" value="<?php echo date('01/m/Y'); ?>">
                <input type='hidden' name="end_date" value="<?php echo date('30/m/Y'); ?>">
            </form>
            <div class="col-lg-6">
                <div id="myDiv" style=" height:100%; width:100%; margin-left:4px;">
                        
                </div>
            </div>
            <div class="col-lg-6">
                <div id="myDiv1" style=" height:100%; width:100%; margin-left:4px;">
                        
                </div>
            </div>
        </div>
        -->
        <?php ?>
    </div>
       
</div>
<!--END PAGE CONTENT -->

