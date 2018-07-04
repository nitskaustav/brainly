

<div class="navbar-expand-lg side-bar-area">
  <button class="navbar-toggler navbar-toggler-right collapsed mb-4 btn btn-primary" type="button" data-toggle="collapse" data-target="#side-menu" aria-expanded="false" aria-label="Toggle navigation">
  <i class="ion-ios-settings"></i> Filter
</button>
  <div class="collapse navbar-collapse" id="side-menu">
      <form id="filter_form" name="filter_form" method="post" action="<?php echo $this->Url->build(["controller" => "Products","action" => "searchcategory",'0']);?>" >
      <div class="search-form-area">
            <h5 class="text-uppercase font-weight-bold">Search Keyword</h5>
            <div class="form-serch-top">
                <div class="form-group search-field">
                    <i class="ion-ios-search-strong"></i>
                    <input type="text" placeholder="Search for gear" class="form-control" value="<?php echo $post_data['searchgear']; ?>" name="searchgear" id="searchgear">
                </div>
            </div>
          
            
            <div class="form-group">
                <label>Category</label>
                <select class="form-control" name="category_select" id="category_select">
                    <option value="">Select Category</option>
                     <?php                                                
                        foreach($categories as $cat_val){
                          $cat_id = $cat_val->id;
                          $cat_name = $cat_val->name;

                          if($post_data['category_select'] == $cat_id){
                            $cat_selected = ' selected';
                          }
                          else{
                            $cat_selected = '';
                          }
                        ?>
                        <option value="<?php echo $cat_id; ?>"<?php echo $cat_selected; ?>><?php echo $cat_name; ?></option>
                        <?php
                        }
                     ?>
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