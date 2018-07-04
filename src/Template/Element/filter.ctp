<?php
// echo "<pre>";
// print_r($post_data);
?>

<div class="navbar-expand-lg side-bar-area">
  <button class="navbar-toggler navbar-toggler-right collapsed mb-4 btn btn-primary" type="button" data-toggle="collapse" data-target="#side-menu" aria-expanded="false" aria-label="Toggle navigation">
  <i class="ion-ios-settings"></i> Filter
</button>
  <div class="collapse navbar-collapse" id="side-menu">
      <form id="filter_form" name="filter_form" method="post" action="<?php echo $this->Url->build(["controller" => "Products","action" => "result"]);?>" >
      <div class="search-form-area">
            <h5 class="text-uppercase font-weight-bold">Filter By</h5>
            <div class="form-serch-top">
                <div class="form-group search-field">
                    <i class="ion-ios-search-strong"></i>
                    <input type="text" placeholder="Search for bike" class="form-control" value="<?php echo $post_data['keyword']; ?>" name="keyword">
                </div>
          </div>
          <div class="form-group">
              <label>Postalcode</label>
              <input type="text" placeholder="Postalcode" class="form-control" name="postal_code" value="<?php echo $post_data['postal_code']; ?>">
          </div>
          <div class="form-group">
              <label>Distance</label>
              <input name="distance" type="text" placeholder="10Km" class="form-control" value="<?php echo $post_data['distance']; ?>">
          </div>
          <div class="form-group">
              <label>Make</label>
              <select class="form-control" name="make_id">
                  <option value="">Select Make</option>
                  <?php
                        foreach ($makes as $make) {
                            if($post_data['make_id'] == $make->id)
                              $make_selected = ' selected';
                            else
                              $make_selected = '';
                            echo '<option value="'.$make->id.'"'.$make_selected.' >'.$make->make_name.'</option>';
                        }                                
                    ?>
              </select>
          </div>
          <div class="form-group">
              <label>Model</label>
              <select class="form-control" name="model_id">
                  <option value="">Select model</option>
                   <?php
                        foreach ($models as $model) {
                            if($post_data['model_id'] == $model->id)
                              $model_selected = ' selected';
                            else
                              $model_selected = '';
                            echo '<option value="'.$model->id.'"'.$model_selected.'>'.$model->model_name.'</option>';
                        }                                
                    ?>
              </select>
          </div>
          <div class="form-group">
              <label>Engine Capacity</label>
              <div class="d-flex">
                  <input type="text" placeholder="Min CC" class="form-control mr-2" name="min_cc" value="<?php echo $post_data['min_cc']; ?>">
                <input type="text" placeholder="Max CC" class="form-control" name="max_cc" value="<?php echo $post_data['max_cc']; ?>">
              </div>
          </div>
          <div class="form-group">
              <label>Price</label>
              <div class="d-flex">
                  <input type="text" placeholder="Min" class="form-control mr-2" name="min_price" value="<?php echo $post_data['min_price']; ?>">
                <input type="text" placeholder="Max" class="form-control" name="max_price" value="<?php echo $post_data['max_price']; ?>">
              </div>
          </div>
          <div class="form-group">
              <label>Make Year</label>
              <div class="d-flex">
                  <input type="text" name="year_from" placeholder="From" class="form-control mr-2" value="<?php echo $post_data['year_from']; ?>">
                  <input type="text" name="year_to" placeholder="To" class="form-control" value="<?php echo $post_data['year_to']; ?>">
              </div>
          </div>
          <div class="form-group">
              <label>Mileage </label>
              <div class="d-flex">
                  <input type="text" placeholder="From" class="form-control mr-2" name="mileage_from" value="<?php echo $post_data['mileage_from']; ?>">
                <input type="text" placeholder="To" class="form-control" name="mileage_to" value="<?php echo $post_data['mileage_to']; ?>">
              </div>
          </div>
          <!-- <div class="form-group">
              <label>Color</label>
              <select class="form-control" name="colour">
                <option value="">Select</option>
                <?php foreach($colours as $colour_val) { ?>
                  <option value="<?php echo $colour_val['id']; ?>"><?php echo $colour_val['name']; ?></option>
                <?php } ?>
              </select>
          </div> -->
          <div class="form-group">
              <label>Post By</label>
              <select class="form-control" name="licence_type">
                <?php if($post_data['licence_type'] == 'P') {?>
                  <option value="P" selected>Private</option>
                  <option value="T">Trade</option>
                <?php }elseif($post_data['licence_type'] == 'T'){ ?>
                  <option value="P">Private</option>
                  <option value="T" selected>Trade</option>
                <?php }else{ ?>
                  <option value="P">Private</option>
                  <option value="T">Trade</option>
                <?php } ?>
              </select>
          </div>
          <div class="form-group">
              <label>Fuel Type</label>
              <select class="form-control" name="fuel_type">
                <?php
                      $fuel_type_array = array("Any" => "", "Petrol" => "P", "Diesel" => "D", "Electric" => "E");
                      
                      foreach($fuel_type_array as $key => $value) {
                        
                        if($value == $post_data['fuel_type']){
                          $ftypeselected = ' selected';
                        }
                        else{
                          $ftypeselected = ''; 
                        }
                      ?>
                        <option value="<?php echo $value; ?>" <?php echo $ftypeselected; ?>><?php echo $key; ?></option>
                <?php } ?>
                  <!-- <option value="">Any</option>
                  <option value="P">Petrol</option>
                  <option value="D">Diesel</option>
                  <option value="E">Electric</option> -->
              </select>
          </div>
          <input type="hidden" name="sortbyval" id="sortbyval" value="">
          <div class="form-group">
              <input id="filter_button" type="submit" name="submit" value="Submit" class="nav-link btn btn-primary">
          </div>
        </div>
        </form>
  </div>
</div>