<?php
    if (isset($_COOKIE['email']) && isset($_COOKIE['passwordone'])) {
        $checked = ' checked';
    }
    else{
        $checked = '';
    }
?>
<section class="content-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-6 signup-image align-self-center">
                    <h1>Let's start sharing knowledge </h1>
                    <img src="<?php echo $this->Url->build('/images/login.png'); ?>" alt="" class="img-fluid"/>
                    
                </div>
                <div class="col-lg-4 col-md-6">
                    <form method="post" action="<?php echo $this->Url->build(["controller" => "Users","action" => "signin"]);?>" class="signin-form" onsubmit="return validate();">
                      <div class="form-group">
                         <label for="exampleInputEmail1"><b>Log in</b></label>
                         <button class="btn facebook">
                            <i class="ion-social-facebook"></i> <span>login Using Facebook</span>
                         </button>                       
                      </div>
                      <label for="exampleInputEmail1"><b>Or</b></label>
                      <div id="msgsuc" style="color:#008000;"></div>
                        <div id="msgerr" style="color:#ff0000;"></div>
                      <div class="form-group">
                        <input type="text" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Email" value="<?php echo $_COOKIE['email']; ?>">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $_COOKIE['passwordone'] ?>">
                      </div>
                      <div class="form-group form-check">
                        <span>
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" value="rememberme" <?php echo $checked; ?>>
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </span>
                        <?php
                            $forget_link = $this->Url->build(["controller" => "Users","action" => "forgotpassword"]);
                        ?>
                        <span style="margin-left: 20%;">
                        <a href="<?php echo $forget_link; ?>" style="text-decoration: none;">Forgot Password?</a>
                        </span>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                       <div class="text-center footer-login">
                        <p>I don't have an account,<a href="<?php echo $this->Url->build(["controller" => "Users","action" => "signup","logtype" => "signup"]);?>"> join now</a>. </p>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        function validate(){
            var email = $("#email").val();
            var email = email.trim();
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (!filter.test(email)) {
                
                document.getElementById("email").focus();
                $('#msgerr').html('');
                $('#msgerr').html('Please provide a valid email address');
                return false;
            }

            if($("#password").val().search(/\S/) == -1){
                document.getElementById("password").focus();
                $('#msgerr').html('');
                $('#msgerr').html('Password cannot be empty');
                return false;
            }

            return true;
        }
    </script>