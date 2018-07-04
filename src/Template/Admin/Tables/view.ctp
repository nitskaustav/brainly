 <?php ?> 

<div id="content">
    <div class="inner">
      <div class="row">
        <div class="col-lg-12">
        </div>
      </div>
      <hr />
       <div class="table-responsive">
            <div class="runs view large-9 medium-8 columns content">
                <h3>Category Detail</h3>
                <table class="vertical-table table table-striped table-bordered table-hover">
                    <tr>
                        <th style="width:20%"><?php echo __('Name') ?></th>
                        <td style="width:80%"><?php echo h($category->name) ?></td>
                    </tr>

                    <tr>
                        <th><?php echo __('Slug') ?></th>
                        <td><?php echo h($category->slug) ?></td>
                    </tr>
                    <!--
                    <tr>
                        <th><?php echo __('Description') ?></th>
                        <td><?php echo $category->description ?></td>
                    </tr>
                    -->
                    <!---
                    <tr>
                        <th><?php echo __('Image') ?></th>
                        <td>                        
                            <?php $filePath = WWW_ROOT . 'category_img' . DS . $category->image; ?>
                            <?php if ($category->image != "" && file_exists($filePath)) { ?>
                                <img src="<?php echo $this->Url->build('/category_img/' . $category->image); ?>" width="100px" height="100px" />
                            <?php } ?>                        
                        </td>
                    </tr>-->
                    <!---
                    <tr>
                        <th><?php echo __('Meta Title') ?></th>
                        <td><?php echo $category->meta_title ?></td>
                    </tr>-->
                    <!--
                    <tr>
                        <th><?php echo __('Meta Keywords') ?></th>
                        <td><?php echo $category->meta_key ?></td>
                    </tr>
                    -->
                    <!---
                    <tr>
                        <th><?php echo __('Meta Description') ?></th>
                        <td><?php echo $category->meta_descriptiion ?></td>
                    </tr>   
                    -->
                    <tr>
                        <th><?php echo __('Status') ?></th>
                        <td><?php echo $category->is_active == 1 ? 'Active' : 'Suspended' ?></td>
                    </tr>    
                    <!--
                    <tr>
                        <th><?php echo __('Is Display Home Page') ?></th>
                        <td><?php echo $category->is_displayhome == 1 ? 'Yes' : 'No' ?></td>
                    </tr>
                    -->
                </table>
            </div>
        </div>
</div>
</div>