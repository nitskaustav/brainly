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
                <div style="text-align: center;"> 
                    <?php if(!empty($admin_permissions) && in_array(3, $admin_permissions))
                    { ?>
                    <a class="quick-btn" href="<?php echo $this->Url->build(["controller" => "Users", "action" => "listdoctor"]); ?>"> <i class="icon-plus-sign icon-2x"></i> <span> Doctors </span> 
                        <!--<span class="label label-success">456</span> --> </a>
                    <?php
                    } ?>
                    <?php if(!empty($admin_permissions) && in_array(5, $admin_permissions))
                    { ?>
                    <a class="quick-btn" href="<?php echo $this->Url->build(["controller" => "Users", "action" => "listuser"]); ?>"> <i class="icon-user icon-2x"></i> <span> Users </span> 
                        <!--<span class="label label-success">456</span>--> </a> 
                    <?php
                    } ?>
                    <?php if(!empty($admin_permissions) && in_array(15, $admin_permissions))
                    { ?>
                    <!---<a class="quick-btn" href="<?php echo $this->Url->build(["controller" => "Treatments", "action" => "index"]); ?>"> <i class="fa fa-stethoscope" style="font-size:30px;"></i> <span> Treatments </span> -->
                        <!--<span class="label label-success">456</span>--> </a> 
                    <?php
                    } ?>
                    <?php if(!empty($admin_permissions) && in_array(18, $admin_permissions))
                    { ?>
                    <!---<a class="quick-btn" href="<?php echo $this->Url->build(["controller" => "Medicines", "action" => "index"]); ?>"> <i class="fa fa-medkit" style="font-size:30px;"></i> <span> Medicine </span>  -->
                        <!--<span class="label label-success">456</span>--> </a> 
                    <?php
                    } ?>

                        
            </div>
        </div>
        <!--END BLOCK SECTION -->        
        
        <hr />
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

