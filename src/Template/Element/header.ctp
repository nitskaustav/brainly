<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
  <div class="container">
      <a class="navbar-brand" href="#" style="color:#fff;font-size:36px;">LogoHere</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="ion-navicon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">        
        <form class="form-inline ml-auto">
            <?php 
                // $signIn = 'signin';
                // $signUp = 'signup';
            //echo $logtype;
            ?>
          <a class="btn btn-primary mr-2" href="<?php echo $this->Url->build(["controller" => "Users","action" => "signin","logtype" => "signin"]);?>">LOGIN</a>
          <a class="btn btn-light" href="<?php echo $this->Url->build(["controller" => "Users","action" => "signup","logtype" => "signup"]);?>">JOIN NOW</a>
        </form>
      </div>
  </div>
</nav>