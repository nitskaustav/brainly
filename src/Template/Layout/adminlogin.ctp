<?php //pr($SiteSettings); //exit;       ?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="UTF-8" />
        <?php $filePathf = WWW_ROOT . 'logo' . DS . $SiteSettings['site_favicon']; ?>
        <?php if ($SiteSettings['site_favicon'] != "" && file_exists($filePathf)) { ?>
            <?php //echo $this->Html->meta('favicon.ico', 'logo/' . $SiteSettings['site_favicon'], array('type' => 'icon')); ?>
        <?php } else { ?>
            <?php //echo $this->Html->meta('favicon.ico', 'img/unnamed.png', array('type' => 'icon')); ?>
        <?php } ?>
        <title><?php //echo $SiteSettings['site_title'];   ?>Brainly | Login Page</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!--[if IE]>
           <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
           <![endif]-->
        <!-- GLOBAL STYLES -->
        <!-- PAGE LEVEL STYLES -->
        <?php echo $this->Html->css('admin/login.css') ?>
        <?php echo $this->Html->css('/plugins/bootstrap/css/bootstrap.css') ?>
        <?php echo $this->Html->css('/plugins/magic/magic.css') ?>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- END PAGE LEVEL STYLES -->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <style>
            .message.success{
                background: #5cb85c none repeat scroll 0 0;
                color: #fff;
                font-weight: bold;
                padding: 12px 10px;
                text-align: center;
                font-size : 18px;
            }
            .message.error{
                background: #fa693c none repeat scroll 0 0;
                color: #fff;
                font-weight: bold;
                padding: 12px 10px;
                text-align: center;
                font-size : 18px;
            }
        </style>    
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="cus-background">
        <!-- PAGE CONTENT --> 
        <div class="container">
            <?php echo $this->Flash->render('success') ?>
            <?php echo $this->Flash->render('error') ?>
            <?php echo $this->fetch('content'); ?>		
        </div>
        <!--END PAGE CONTENT -->     
        <!-- PAGE LEVEL SCRIPTS -->
        <?php echo$this->Html->script('/plugins/jquery-2.0.3.min.js') ?>
        <?php echo$this->Html->script('/plugins/bootstrap/js/bootstrap.js') ?>
        <?php echo$this->Html->script('admin/login.js') ?>

        <?php echo $this->Html->script('/plugins/validationengine/js/jquery.validationEngine.js') ?>
        <?php echo $this->Html->script('/plugins/validationengine/js/languages/jquery.validationEngine-en.js') ?>
        <?php echo $this->Html->script('/plugins/jquery-validation-1.11.1/dist/jquery.validate.min.js') ?>

        <?php echo $this->Html->script('validationInit.js') ?>
        <script>
            $(function () {
                formValidation();
            });
        </script>      




        <!--END PAGE LEVEL SCRIPTS -->
    </body>
    <!-- END BODY -->
</html>