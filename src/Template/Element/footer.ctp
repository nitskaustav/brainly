<?php
    $session = $this->request->session();

?>
<footer>
        <div class="footer-top py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <b>About us</b>
                        <ul class="list-unstyled">
                            <li><a href="">About us</a></li>
                            <li><a href="">Career</a></li>
                            <li><a href="">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <b>Help</b>
                        <ul class="list-unstyled">
                            <li><a href="">FAQ</a></li>
                            <li><a href="">Terms of Use</a></li>
                            <li><a href="">How do I receive points?</a></li>
                            <li><a href="">Privacy policy</a></li>
                            <li><a href="">Scholarships</a> </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <b>Socials</b>
                        <ul class="list-unstyled social mt-4">
                            <li><a href=""><i class="ion-social-facebook"></i></a></li>
                            <li><a href=""><i class="ion-social-twitter"></i></a></li>
                            <li><a href=""><i class="ion-social-googleplus"></i></a></li>
                            <li><a href=""><i class="ion-social-linkedin"></i></a></li>
                            <li><a href=""><i class="ion-social-instagram-outline"></i></a></li>
                        </ul>
                    </div>                  
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center py-3">
            <div class="container">
                <span>© 2018 companyname. All right reserved</span>
            </div>
        </div>
    </footer>

    <?php echo $this->Html->script('ajaxupload.3.5.js') ?>
    <?php echo $this->Html->script('gallery.js') ?>  
    
    <script type="text/javascript">
        function subscribemail(){
            if(document.getElementById("email").value.search(/\S/) == -1){
                alert("Please Enter Valid Email"); return false;
            }

            var email = $("#email").val();
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (!filter.test(email)) {
                alert('Please provide a valid email address');
                email.focus;
                return false;
             }

            $.ajax({
                method: "POST",
                url: '<?php echo $this->request->webroot; ?>users/subscribe',
                data: { email: email}
              })
              .done(function( data ) {
                //alert(data); return false;
                var obj = JSON.parse(data);
                alert(obj.data);
            });
        }
    </script>