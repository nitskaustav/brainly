<?php
  $userid = $this->request->session()->read('Auth.User.id');
  $admin_checkid = $this->request->session()->read('Auth.User.is_admin');
  $base_url= "http://localhost/5star/";

  echo $this->element('head');
  echo $this->element('header');
?> 
  <?php echo $this->Flash->render() ?>
  <?php echo $this->Flash->render('success') ?>
  <?php echo $this->Flash->render('error') ?>
  <?php echo $this->fetch('content');?>
  <?php echo $this->element('footer');?>    
    <!-- Bootstrap core JavaScript -->
    
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  
    <?php echo $this->Html->script('ie10-viewport-bug-workaround.js') ?>
    <?php echo $this->Html->script('jquery.bxslider.js') ?>
    <script>
      $(document).ready(function(){
      $('.bxslider').bxSlider({
          mode: 'horizontal',
          controls: false
        });
      });
    </script>
  </body>
</html>
