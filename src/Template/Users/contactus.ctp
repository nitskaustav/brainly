
<!-- 
<div class="clearfix"></div>

<section class="cus_section">
	<div class="cus-bg">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="text-center">contact us</h1>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="clearfix"></div>

<section class="cus-support">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="text-uppercase text-center h1">Customer Support</h2>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="cus-leftdiv">
					<h1>Thank you for using Carvis!</h1>
					<p class="h3">Please complete the form below, so we can provide quick and efficient service. Alternatively, feel free to drop us an email at <a href="mailto:contact@carvis.com.my"> contact@carvis.com.my</a></p>
				</div>
			</div>

			<div class="col-md-6">
				<div class="cus-formdiv">
					<h5>Fill Here</h5>

					<form action="<?php echo $this->Url->build(["controller" => "Users","action" => "contactus"]);?>" method="post">
						<div class="form-group">
                                                    <input type="text" name="name" required="" class="form-control" placeholder="Name" />
						</div>

						<div class="form-group">
                                                    <input type="email" name="email" required="" class="form-control" placeholder="Email" />
						</div>

						<div class="form-group">
                                                    <input type="text" name="phone" required="" class="form-control" placeholder="Phone" />
						</div>

						<div class="form-group">
                                                    <input type="text" name="title" required="" class="form-control" placeholder="Title" />
						</div>

						<div class="form-group">
                                                    <textarea class="form-control" required="" name="message" rows="7" placeholder="Message"></textarea>
						</div>

						<div class="form-group">
                                                    <button type="submit" class="btn btn-success text-center text-capitalize">Send</button>	
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="clearfix"></div> -->


<section class="contact-page py-5">
   <div class="container">
       <h2 class="heading mb-4">Contact Us</h2>
       <div class="row">
           <div class="col-md-7 dash_board_body_sec">
           <form action="<?php echo $this->Url->build(["controller" => "Users","action" => "contactus"]);?>" method="post" class="form-area">
                   <div class="form-group">
                       <label>Name</label>
                       <input type="text" class="form-control" name="name">
                   </div>
                   <div class="form-group">
                       <label>Email Id</label>
                       <input type="text" class="form-control" name="email">
                   </div>
                   <div class="form-group">
                       <label>Phone No</label>
                       <input type="text" class="form-control" name="phone">
                   </div>
                   <div class="form-group">
                       <label>Comment</label>
                       <textarea rows="3" class="form-control" name="message"></textarea>
                   </div>
                   <div class="form-group">
                       <button class="btn btn-primary btn-lg" type="submit">Submit</button>
                   </div>
               </form>
           </div>
           <div class="col-md-5 col-contact-details">
               <h5 class="text-dark-grey font-weight-bold">Contact Information</h5>
              <ul class="list-unstyled my-4">
                  <li>
                      <i class="ion-ios-location"></i> 513, parkstreet road
pincode 45845
                  </li>
                  <li>
                      <i class="ion-ios-telephone"></i> 8565 565 898 | 7872 415 564
                  </li>
                  <li>
                      <i class="ion-email"></i> abc@example.com
                  </li>
              </ul>
               <div>
                   <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3684.8477128822533!2d88.35895491955232!3d22.547376750186647!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a0276e7479c7cad%3A0x2ce399323c653f92!2sPark+St%2C+Mullick+Bazar%2C+Park+Street+area%2C+Kolkata%2C+West+Bengal!5e0!3m2!1sen!2sin!4v1513850351155" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen=""></iframe>
               </div>
          </div>
       </div>
   </div>
</section>

