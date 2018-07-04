<?php
    if($logtype == 'index'){ ?>

<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#" style="color:#fff;font-size:36px;">LogoHere</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="ion-navicon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">        
        <form class="form-inline ml-auto">
          <a class="btn btn-primary mr-2" href="<?php echo $this->Url->build(["controller" => "Users","action" => "signin"]);?>">LOGIN</a>
          <a class="btn btn-light" href="<?php echo $this->Url->build(["controller" => "Users","action" => "signup"]);?>">JOIN NOW</a>
        </form>
      </div>
  </div>
</nav>

<?php } elseif ($logtype == 'signin' || $logtype == 'signup') { ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light inner-header">
        <div class="container">
      <a class="navbar-brand" href="#" style="color:#fff;font-size:36px;">LogoHere</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="ion-navicon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">        
        <form class="form-inline ml-auto">
          <a class="btn btn-primary mr-2" href="<?php echo $this->Url->build(["controller" => "Users","action" => "signin"]);?>">LOGIN</a>
          <a class="btn btn-light" href="<?php echo $this->Url->build(["controller" => "Users","action" => "signup"]);?>">JOIN NOW</a>
        </form>
      </div>
  </div>
</nav>
<?php } else {?>
<nav class="navbar navbar-expand-lg navbar-light bg-light inner-header">
  <div class="container">
      <a class="navbar-brand" href="#" style="color:#fff;font-size:36px;">LogoHere</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="ion-navicon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">        
        <form class="mr-auto w-75">
                    <div class="d-flex search-bar ">
                    <input type="text" class="form-control" placeholder="Search">                         
                         <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
                      </div>
        </form>
                  <div class="ml-auto login-div-li">
                      <ul class="list-inline mb-0">
                          <li><a href=""><i class="fa fa-comment"></i></a></li>
                          <li><a href=""><i class="fa fa-bell"></i></a></li>
                          <li><a href=""><i class="fa fa-users"></i></a></li>
                           <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span><img src="<?php echo $this->Url->build('/images/user-image.jpg'); ?>" class="img-fluid" alt=""></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                  <a class="dropdown-item" href="#"><i class="fa fa-user"></i> View Profile</a>
                                  <a class="dropdown-item" href="#"><i class="fa fa-edit"></i> Edit Profile</a>                                      
                                  <a class="dropdown-item" href="<?php echo $this->Url->build(["controller" => "Users","action" => "signout"]);?>"><i class="fa fa-power-off"></i> Logout</a>
                                </div>
                              </li>
                      </ul>
                  </div>
      </div>
  </div>
</nav>
<?php } ?>

  