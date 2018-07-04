<section class="login-page inner-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center inner-heading">
                <!-- <h2>Forget Password</h2> -->
                <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p> -->
            </div>
            <div class="col-lg-10">
                <div class="login-area">
                    <div class="row">
                        <div class="col-lg-7 pr-lg-5">
                            <!-- <h5 class="font-weight-bold mb-4">Set Password</h5> -->
                            <form id="frmLogin" accept-charset="utf-8" method="post" action="<?php echo $this->Url->build(["controller" => "Users","action" => "forgotpassword"]);?>" class="form-area" onsubmit="return validate();">
                            	<p><b>Email</b></p>
                                <div class="form-group">
                                    <img src="<?php echo $this->Url->build('/img/user-icon.png'); ?>" alt="">
                                    <input type="text" name="email" id="email" placeholder="Email" class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <button class="btn btn-primary btn-lg text-capitalize">Set Password</button>
                                </div>
                            </form>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
  $(function(){
    $( "#frmLogin" ).validate({
        rules: {
          'email': {
            required: true
          }
        },
        messages: {

          'email': "Please enter a valid email address",
        },
      });
  })

  // function validate(){
  //   //alert("Hello");return false;
  //   if($("#email").val().search(/\S/) == -1){
  //     alert("Please enter a valid email.");return false;
  //   }
  // }
</script>

<script type="text/javascript">
  function validate(){
    var email = $("#email").val();
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(email)) {
        alert('Please provide a valid email address');
        email.focus;
        return false;
    }
  }
</script>