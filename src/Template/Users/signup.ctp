<section class="content-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-6 signup-image align-self-center">
                    <h1>Let's start sharing knowledge </h1>
                    <img src="<?php echo $this->Url->build('/images/signup.png'); ?>" alt="" class="img-fluid"/>
                    
                </div>
                <div class="col-lg-4 col-md-6">
                    <form method="post" action="<?php echo $this->Url->build(["controller" => "Users","action" => "signup"]);?>" class="signin-form" onsubmit="return validate();">
                      <div class="form-group">
                         <label for="exampleInputEmail1"><b>Sign up with your email address</b></label>
                         <!--<button class="btn facebook">
                            <i class="ion-social-facebook"></i> <span>login Using Facebook</span>
                         </button>  -->
                        <div id="msgsuc" style="color:#008000;"></div>
                        <div id="msgerr" style="color:#ff0000;"></div>

                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Username" name="username" id="username">
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Email">
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control" name="con_password" id="con_password" placeholder="Confirm Password">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Birthday</label>
                        <div class="row">
                            <div class="col-4"><input type="text" name="day" id="day" class="form-control" placeholder="DD"></div>
                            <div class="col-4"><input type="text" name="month" id="month" class="form-control" placeholder="MM"></div>
                            <div class="col-4"><input type="text" name="birth_year" id="birth_year" class="form-control" placeholder="YYYY"></div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                       <!-- <div class="text-center footer-login">
                        <p>I don't have an account,<a href=""> join now</a>. </p>
                       </div> -->
                    </form>
                </div>
            </div>
        </div>
    </section>
<script type="text/javascript">
    // $(function(){
    //     $( "#frmRegister" ).validate({
    //     rules: {
    //       'first_name': "required",
    //       'last_name': "required",          
    //       'utype': "required",
    //       'email': {
    //         required: true
    //       },

    //       'password': {
    //         required: true,
    //         minlength: 6
    //       },
    //       'con_password': {
    //         required: true,
    //         minlength: 6
    //       }

    //     },
    //     messages: {
    //       'utype': "Please choose user type",
    //       'first_name': "Please enter your first name.",
    //       'last_name': "Please enter your last name.",
    //       'email': "Please enter a valid email address",          

    //       'password': {
    //         required: "Please provide a password",
    //         minlength: "Your password must be at least 6 characters long"
    //       },
    //       'con_password': {
    //         required: "Please re-type  password",
    //         minlength: "Your password must be same as above password"
    //       }
    //     },


    //   });
    // })
    /**/
</script>

<script type="text/javascript">
    function validate(){
        //alert("Hi");return false;

        if($("#username").val().search(/\S/) == -1){
            document.getElementById("username").focus();
            $('#msgerr').html('');
            $('#msgerr').html('Username field can not be blank!');
            return false;
        }

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

        if($("#con_password").val().search(/\S/) == -1){
            document.getElementById("con_password").focus();
            $('#msgerr').html('');
            $('#msgerr').html('Confirm password cannot be empty');
            return false;
        }

        if($("#password").val() != $("#con_password").val()){
            $('#msgerr').html('');
            $('#msgerr').html('Password and confirm password should be same');
            return false;
        }

        if($("#day").val().search(/\S/) == -1){
            document.getElementById("day").focus();
            $('#msgerr').html('');
            $('#msgerr').html('Day cannot be empty');
            return false;
        }

        var birth_day = $("#day").val();
        if(birth_day != ''){
            if(isNaN(birth_day)){
                document.getElementById("day").focus();
                $('#msgerr').html('');
                $('#msgerr').html('Day should be numeric');
                return false;
            }
        }

        if($("#month").val().search(/\S/) == -1){
            document.getElementById("month").focus();
            $('#msgerr').html('');
            $('#msgerr').html('Month cannot be empty');
            return false;
        }

        var birth_month = $("#month").val();
        if(birth_month != ''){
            if(isNaN(birth_month)){
                document.getElementById("month").focus();
                $('#msgerr').html('');
                $('#msgerr').html('Month should be numeric'); 
                return false;
            }
        }

        if($("#birth_year").val().search(/\S/) == -1){
            document.getElementById("birth_year").focus();
            $('#msgerr').html('');
            $('#msgerr').html('Birth year cannot be empty');
            return false;
        }

        var birth_year = $("#birth_year").val();
        if(birth_year != ''){
            if(isNaN(birth_year)){
                document.getElementById("birth_year").focus();
                $('#msgerr').html('');
                $('#msgerr').html('Year should be numeric');
                return false;
            }
        }

        return true;
        
    }

</script>
<script type="text/javascript">
    function showpass(){
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
            document.getElementById("showpasslink").innerHTML = 'Hide Password';
        } else {
            x.type = "password";
            document.getElementById("showpasslink").innerHTML = 'Show Password';
        }
    }
</script>