<section class="left-side-pannel-page py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-left-bar">
          <div class="navbar-expand-lg side-bar-area">
              <div class="nav-side-menu-toggle">
                  <button class="navbar-toggler navbar-toggler-right collapsed btn btn-primary mb-3" type="button" data-toggle="collapse" data-target="#side-menu" aria-expanded="false" aria-label="Toggle navigation">
                      <i class="ion-android-more-vertical"></i>
                    </button>
              </div>
              <?php echo $this->element('side_menu');?>                
          </div>
      </div>
      <div class="col-lg-9">
        <div class="right-side p-4">
          <form method="post" action="<?php echo $this->Url->build(["controller" => "Users","action" => "changepass"]);?>" onsubmit = "return validate();">
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-4 col-form-label">Old Password:</label>
              <div class="col-sm-8">                      
                 <input type="password" class="form-control" id="old_pass" placeholder="Old password..." name="old_password" >
              </div>
            </div>
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-4 col-form-label">New Password:</label>
              <div class="col-sm-8">                      
                 <input type="password" class="form-control" id="new_pass" placeholder="New password..." name="new_password" >
              </div>
            </div>
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-4 col-form-label">Confirm Password:</label>
              <div class="col-sm-8">
                <input type="password" class="form-control" id="con_pass" name="confirm_password"  placeholder="Confirm password...">                  
              </div>
            </div>
            <div class="row">
              <div class="col-sm-8 ml-auto">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  function validate(){
    //alert("hi");return false;
    if($("#old_pass").val().search(/\S/) == -1){
      alert("Please provide old password");return false;
    }
    if($("#new_pass").val().search(/\S/) == -1){
      alert("Please provide new password");return false;
    }
    if($("#con_pass").val().search(/\S/) == -1){
      alert("Please provide confirm password");return false;
    }
    
    var password = $("#new_pass").val();
    //var pass_filter = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
    var pass_filter = /(?=.*\d)(?=.*[A-Z]).{6,}/;
    if(!pass_filter.test(password)){
        alert("Password should contain 1 capital letter and one number and contain atleast 6 characters");return false;
    }

    if($("#new_pass").val() != $("#con_pass").val()){
        alert("Password and confirm password should be same");
        return false;
    }

    return true;
  }
</script>