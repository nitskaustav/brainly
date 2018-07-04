<?php 
if($user->utype == 2){
?>
<div class="collapse navbar-collapse" id="side-menu">
    <ul class="sidebar-list w-100"> 
    	<li><a href="<?php echo $this->Url->build(["controller" => "Users","action" => "sellerdashboard"]);?>" <?php echo (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'sellerdashboard')? 'class="active"' : '');?>><i class="fas fa-user"></i> <span>My Account</span></a></li>       
        <li><a href="<?php echo $this->Url->build(["controller" => "Users","action" => "editprofile"]);?>" <?php echo (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'editprofile')? 'class="active"' : '');?>><i class="ion-edit"></i> <span>Edit Profile</span></a></li>

        <li><a href="<?php echo $this->Url->build(["controller" => "Users","action" => "changepass"]);?>" <?php echo (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'changepass')? 'class="active"' : '');?>><i class="ion-edit"></i> <span>Change Password</span></a></li>

        <li><a href="<?php echo $this->Url->build(["controller" => "Products","action" => "addproduct"]);?>" <?php echo (($this->request->params['controller'] == 'Products' && $this->request->params['action'] == 'addproduct')? 'class="active"' : '');?>><i class="fas fa-edit"></i> <span>Post Ads</span></a></li>

        <li><a href="<?php echo $this->Url->build(["controller" => "Products","action" => "listproduct"]);?>" <?php echo (($this->request->params['controller'] == 'Products' && $this->request->params['action'] == 'listproduct')? 'class="active"' : '');?>><i class="fas fa-edit"></i> <span>Listing</span></a></li>

        <li><a href="<?php echo $this->Url->build(["controller" => "Gears","action" => "addgear"]);?>" <?php echo (($this->request->params['controller'] == 'Gears' && $this->request->params['action'] == 'addgear')? 'class="active"' : '');?>><i class="fas fa-edit"></i> <span>Add Gear</span></a></li>

        <li><a href="<?php echo $this->Url->build(["controller" => "Gears","action" => "listgear"]);?>" <?php echo (($this->request->params['controller'] == 'Gears' && $this->request->params['action'] == 'listgear')? 'class="active"' : '');?>><i class="fas fa-edit"></i> <span>Gear Listing</span></a></li>

        <li><a href="<?php echo $this->Url->build(["controller" => "Products","action" => "listorderseller"]);?>" <?php echo (($this->request->params['controller'] == 'Products' && $this->request->params['action'] == 'listorderseller')? 'class="active"' : '');?>><i class="fas fa-edit"></i> <span>Order Listing</span></a></li>

        <li><a href="<?php echo $this->Url->build(["controller" => "Products","action" => "sellermessage"]);?>" <?php echo (($this->request->params['controller'] == 'Products' && $this->request->params['action'] == 'sellermessage')? 'class="active"' : '');?>><i class="far fa-envelope"></i> <span>Message</span></a></li>

        <!-- <li><a href="<?php echo $this->Url->build(["controller" => "Products","action" => "wishlisting"]);?>" <?php echo (($this->request->params['controller'] == 'Products' && $this->request->params['action'] == 'wishlisting')? 'class="active"' : '');?>><i class="fas fa-edit"></i> <span>Wishlist</span></a></li> -->

        <li><a href="<?php echo $this->Url->build(["controller" => "Users","action" => "chatmessage"]);?>" <?php echo (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'chatmessage')? 'class="active"' : '');?>><i class="fas fa-user"></i><span>Chats</span><div class="relative">Message<span class="mcount"><b>0</b></span></div></a></li>

        <!-- <li><a href="#"><i class="fas fa-cog"></i> <span>Settings</span></a></li> -->
        <li><a href="<?php echo $this->Url->build(["controller" => "Users","action" => "signout"]);?>""><i class="fas fa-cog"></i> <span>Logout</span></a></li>
    </ul>
</div>
<?php
}
else{
?>
<div class="collapse navbar-collapse" id="side-menu">
    <ul class="sidebar-list w-100"> 
    	<li><a href="<?php echo $this->Url->build(["controller" => "Users","action" => "sellerdashboard"]);?>" <?php echo (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'sellerdashboard')? 'class="active"' : '');?>><i class="fas fa-user"></i> <span>My Account</span></a></li>       
        <li><a href="<?php echo $this->Url->build(["controller" => "Users","action" => "editprofile"]);?>" <?php echo (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'editprofile')? 'class="active"' : '');?>><i class="ion-edit"></i> <span>Edit Profile</span></a></li>
        <li><a href="<?php echo $this->Url->build(["controller" => "Users","action" => "changepass"]);?>" <?php echo (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'changepass')? 'class="active"' : '');?>><i class="ion-edit"></i> <span>Change Password</span></a></li>
        <li><a href="<?php echo $this->Url->build(["controller" => "Products","action" => "listorder"]);?>" <?php echo (($this->request->params['controller'] == 'Products' && $this->request->params['action'] == 'listorder')? 'class="active"' : '');?>><i class="fas fa-edit"></i> <span>Order Listing</span></a></li>
        <li><a href="<?php echo $this->Url->build(["controller" => "Products","action" => "buyermessage"]);?>" <?php echo (($this->request->params['controller'] == 'Products' && $this->request->params['action'] == 'buyermessage')? 'class="active"' : '');?>><i class="far fa-envelope"></i> <span>Message</span></a></li>
        <li><a href="<?php echo $this->Url->build(["controller" => "Products","action" => "wishlisting"]);?>" <?php echo (($this->request->params['controller'] == 'Products' && $this->request->params['action'] == 'wishlisting')? 'class="active"' : '');?>><i class="fas fa-edit"></i> <span>Wishlist</span></a></li>

        <li><a href="<?php echo $this->Url->build(["controller" => "Users","action" => "chatmessage"]);?>" <?php echo (($this->request->params['controller'] == 'Users' && $this->request->params['action'] == 'chatmessage')? 'class="active"' : '');?>><i class="fas fa-user"></i><span>Chats</span><div class="relative">Message<span class="mcount"><b>0</b></span></div></a></li>
        
        <!-- <li><a href="#"><i class="fas fa-cog"></i> <span>Settings</span></a></li> -->
        <li><a href="<?php echo $this->Url->build(["controller" => "Users","action" => "signout"]);?>""><i class="fas fa-cog"></i> <span>Logout</span></a></li>
    </ul>
</div>
<?php
	}
?>