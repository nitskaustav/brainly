<section class="content-section py-4 profile-page">
            <div class="container">                
                    <div class="well profile shadow mx-auto">
                           <div class="row">
                               <div class="col-12 col-sm-8">
                                   <h2><?php echo $current_user['username']; ?> <a href="" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a></h2>
                                   <?php 
                                   $date=$current_user['day'];
                                   $month = $current_user['month'];
                                   $year = $current_user['birth_year'];
                                   $dateOfBirth = $current_user['day']."-".$month."-".$year;
                                   $today = date("Y-m-d");
                                   $diff = date_diff(date_create($dateOfBirth), date_create($today));
                                   ?>
                                   
                                   <p><strong>Age: </strong> <?php //echo $diff->format('%y'); ?> </p>
                                   <p><strong>Level: </strong> <?php if(!empty($current_user['level'])){echo $current_user['level'];}else{ echo 'No Level Added'; } ?> </p>
                                   
                                   <!--<p><strong>Hobbies: </strong> Read, out with friends, listen to music, draw and learn new things. </p>-->
<!--                                   <p><strong>Skills: </strong>
                                       <span class="tags">html5</span> 
                                       <span class="tags">css3</span>
                                       <span class="tags">jquery</span>
                                       <span class="tags">bootstrap3</span>
                                   </p>-->
                               </div>             
                               <div class="col-12 col-sm-4 text-center">
                                   <figure>
                                       <img src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" alt="" class="img-circle img-fluid">
<!--                                       <figcaption class="ratings">
                                           <p>Ratings
                                           <a href="#">
                                               <span class="fa fa-star"></span>
                                           </a>
                                           <a href="#">
                                               <span class="fa fa-star"></span>
                                           </a>
                                           <a href="#">
                                               <span class="fa fa-star"></span>
                                           </a>
                                           <a href="#">
                                               <span class="fa fa-star"></span>
                                           </a>
                                           <a href="#">
                                                <span class="fa fa-star-o"></span>
                                           </a> 
                                           </p>
                                       </figcaption>-->
                                   </figure>
                               </div>
                           </div>            
                           <div class="d-sm-flex divider text-center">
                               <div class="col-12 col-sm-4 emphasis">
                                   <h2 class="text-info"><strong> <?php echo $points ?> </strong></h2>                    
                                   <p><small>points</small></p>
                               </div>
                               <div class="col-12 col-sm-4 emphasis">
                                   <h2 class="text-success"><strong><?php echo $anscount ?></strong></h2>                    ;
                                   <p><small>Questions answered</small></p>                                  
                               </div>
                               <div class="col-12 col-sm-4 emphasis">
                                   <h2 class="text-danger"><strong>0</strong></h2>                    
                                   <p><small>Warnings</small></p>
                               </div>
                           </div>
                </div>
            </div>
	</section>