<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Routing\Router;
use Cake\I18n\FrozenDate;
use Cake\Database\Type;
use Cake\Network\Session\DatabaseSession;

class GearsController extends AppController{

	public function initialize() {
        parent::initialize();
        $this->Auth->allow(['result', 'details']);
     }

	public function addgear(){
		$this->viewBuilder()->layout('default');
		$this->loadModel('Users');
		$this->loadModel('Gears');
		$this->loadModel('Categories');
		$this->loadModel('Colours');
		$this->loadModel('Gearsimages');
		$this->loadModel('SiteSettings');
		

		$categories = $this->Categories->find()->toArray();
		$colours = $this->Colours->find()->toArray();

		$users = $this->Users->get($this->Auth->user('id'));
		$id=$this->Auth->user('id');
        $uid = $this->request->session()->read('Auth.User.id');
        $utype = $this->request->session()->read('Auth.User.utype');
        $uverify = $user->check_verified;

		$this->set(compact('categories','colours','users'));

		$user = $this->Gears->newEntity();
		

		if ($this->request->is('post')) {
			// echo "<pre>";
			// print_r($this->request->data);
			
			$flag = true;
			if ($this->request->data['category_id'] == "") {
                $this->Flash->error(__('Category can not be null. Please, try again.'));
                $flag = false;
            }
            if ($this->request->data['product_name'] == "") {
                $this->Flash->error(__('Product name can not be null. Please, try again.'));
                $flag = false;
            }
            if ($this->request->data['brand_id'] == "") {
                $this->Flash->error(__('Brand name can not be null. Please, try again.'));
                $flag = false;
            }
            if ($this->request->data['size_id'] == "") {
                $this->Flash->error(__('Size can not be null. Please, try again.'));
                $flag = false;
            }
            if ($this->request->data['price'] == "") {
                $this->Flash->error(__('Price can not be null. Please, try again.'));
                $flag = false;
            }
            if ($this->request->data['item_location'] == "") {
                $this->Flash->error(__('Item location can not be null. Please, try again.'));
                $flag = false;
            }

            $gear_name = trim($this->request->data['product_name']);
            $cat_id = $this->request->data['category_id'];

            $cat_details = $this->Categories->find()->where(['id' => $cat_id])->first();
            $cat_name = $cat_details->name;

            $colour_array = array();
            $colour_array = $this->request->data('colour_id');
            if(sizeof($colour_array)){
            	
				
				foreach($colour_array as $colour_val){
					$colour_value .= $colour_val.",";
				}
				$colour_value = rtrim($colour_value,",");
				$this->request->data['colour_id'] = $colour_value;
            }
            

            if(empty($colour_array)){
            	$this->Flash->error(__('Please select colour. Please, try again.'));
                $flag = false;
            }
			
			

			if($this->request->data['upload'] == ''){
				$this->Flash->error(__('Please upload pictures.'));
                $flag = false;
			}
			else{
				$this->request->data['upload'] = rtrim($this->request->data['upload'],",");
				$gear_images_val = $this->request->data['upload'];
				$this->request->data['upload'] = '';
				$gear_image_array = explode(",", $gear_images_val);
				foreach($gear_image_array as $gearimage){
					$this->request->data['upload'] = $gearimage; break;
				}
			}

			if($flag == true){
				$user = $this->Gears->patchEntity($user, $this->request->data);
				if ($rs = $this->Gears->save($user)) {

					$gear_id = $rs->id;

					foreach($gear_image_array as $gearimage){
						if($gearimage == '') continue;
						$gears_images = $this->Gearsimages->newEntity();

						$this->request->data['gear_id'] = $gear_id;
						$this->request->data['name'] = $gearimage;

						$gears_images = $this->Gearsimages->patchEntity($gears_images, $this->request->data);
						$this->Gearsimages->save($gears_images);
					}

						//Seller Details
	                  $seller_details_data = $this->Users->find()->where(['id' => $id])->first();
	                  $full_name = $seller_details_data->first_name." ".$seller_details_data->last_name;
	                  $seller_email = $seller_details_data->email;
	                  $seller_phone = $seller_details_data->phone;

	                  $mailusername = "Biketory";
		              $mail_subject = "New Gear Upload";
		              $admin_mail_data = $this->SiteSettings->find()->first();
		              $admin_mail = $admin_mail_data->contact_email;
		              $mail_To = $admin_mail;
		              $emailfrom = $admin_mail;

		              $etRegObj = TableRegistry::get('EmailTemplates');
		              $emailTemp = $etRegObj->find()->where(['id' => 7])->first()->toArray();

		              $mail_body = str_replace(array('[GEAR]', '[CATEGORY]', '[NAME]', '[EMAIL]', '[CONTACT]'), array($gear_name, $cat_name, $full_name, $seller_email, $seller_phone), $emailTemp['content']);

		              //Send Mail To Admin
	                  $email_admin = new Email('default');
	                  $email_admin->emailFormat('html')->from([$emailfrom => $mailusername])
	                    ->to($mail_To)
	                    ->subject($mail_subject)
	                    ->send($mail_body);

                  	
                  	$etRegObj = TableRegistry::get('EmailTemplates');
              		$emailTemp = $etRegObj->find()->where(['id' => 8])->first()->toArray();

                  	$mail_body = str_replace(array('[NAME]', '[GEAR]', '[CATEGORY]'), array($full_name, $gear_name, $cat_name), $emailTemp['content']);

	                  //Send Mail To Seller
	                  $mail_To = $seller_email;
	                  //$mail_To = 'kaustav@natitsolved.com';
	                  $email_seller = new Email('default');
	                  $email_seller->emailFormat('html')->from([$emailfrom => $mailusername])
	                    ->to($mail_To)
	                    ->subject($mail_subject)
	                    ->send($mail_body);


	                $this->Flash->success('Wait for Admin Approval. Gear will be added very soon.', ['key' => 'success']);
	                $this->redirect(['action' => 'listgear']);
	            }
	            else{
	            	$this->Flash->error(__('Gears could not be added. Please, try again.'));
	                return $this->redirect(['action' => 'listgear']);
	            }
			}
			else{
				$this->Flash->error(__('Gears could not be added. Please, try again.'));
	            return $this->redirect(['action' => 'listgear']);
			}
		}
	}

	function listgear(){
		$this->viewBuilder()->layout('default');
		$this->loadModel('Users');
        $this->loadModel('Categories');
        $this->loadModel('Gears');
        $this->loadModel('Gearsimages');

        /*echo "<pre>";
        print_r($gears);die;*/
        $user = $this->Users->get($this->Auth->user('id'));
        $uid = $this->request->session()->read('Auth.User.id');
        $utype = $this->request->session()->read('Auth.User.utype');
        $uverify = $user->check_verified;
        //$conditions = ['Products.seller_id'=>$uid];
           
        /*$this->paginate = [
            'conditions' => $conditions,
            'contain' => ['Productsimages', 'Bikemodels', 'Makes', 'Categories'],
            'order' => [ 'id' => 'DESC']
        ];
        $products = $this->paginate($this->Products);*/
       /* pr($products);
        die;  */
        $conditions = ['Gears.is_active' => 'Y'];
        $this->paginate = [
        	'conditions' => $conditions,
            'contain' => ['Categories','Gearsimages'],
            'order' => [ 'id' => 'DESC']
        ];
        $gears = $this->paginate($this->Gears);

        // echo "<pre>";
        // print_r($gears);
        // exit;

        $this->set(compact('gears','user'));
        $this->set('_serialize', ['gears']);
	}

	function geardelete($id = null){
		$this->loadModel('Gears');
        $users = $this->Gears->get($id);
        if ($this->Gears->delete($users)) {
            $this->Flash->success(__('Gear deleted.'));
        } else {
            $this->Flash->error(__('Gear could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'listgear']);
	}

	public function editgear($id = null) {
		$this->viewBuilder()->layout('default');
		$this->loadModel('Gears');
		$this->loadModel('Categories');
		$this->loadModel('Colours');
		$this->loadModel('Attributes');
		$this->loadModel('Brands');
		$this->loadModel('Sizes');
		$this->loadModel('Gearsimages');

		$user = $this->Gears->get($id);
		$categories = $this->Categories->find()->toArray();
		$colours = $this->Colours->find()->toArray();
		$gears_images = $this->Gearsimages->find()->where(['gear_id' => $id])->toArray();

		foreach ($gears_images as $gearimage) {
			$upload .= $gearimage->name.",";
		}
		$upload = rtrim($upload,",");

		$category_id = $user->category_id;
		$brand_id = $user->brand_id;
		$size_id = $user->size_id;
		$colour_id = $user->colour_id;
		$colour_id_array = explode(',', $colour_id);
		$price = $user->price;
		$description = $user->description;
		$item_location = $user->item_location;
		//$upload = $user->upload;
		$product_name = $user->product_name;

		$colour_html = '';
		foreach ($colours as $colour_key) {
			if(in_array($colour_key->id, $colour_id_array))
				$colour_checked = ' checked';
			else
				$colour_checked = '';

			$colour_html .=  "<p class=\"text-center d-inline-block\"><input type=\"checkbox\" id=\"$colour_key->id\" name=\"colour_id[]\" value=\"$colour_key->id\" $colour_checked />
								      <label for=\"$colour_key->id\" style=\"background:$colour_key->hexcode\"></label></p>";
		}
		
		$category_html = "<select class=\"form-control\" id=\"category_idselect\" name=\"category_id\"><option value=\"\" >Select</option>";
		foreach ($categories as $cat_val) {
			if($cat_val->id == $category_id)
				$cat_selected = ' selected';
			else
				$cat_selected = '';
			$category_html .= "<option value=\"$cat_val->id\" $cat_selected>$cat_val->name</option>";
		}
		$category_html .= "</select>";

		$category_data = $this->Attributes->find()->where(['category_id' => $category_id])->toArray();

        $brand_ids = $category_data[0]['brand_ids'];
        $brand_id_array = explode(',', $brand_ids);
        
        $size_ids = $category_data[0]['size_ids'];
        $size_id_array = explode(',', $size_ids);

        $brand = $this->Brands->find()->where(['id IN' => $brand_id_array]);

		$brand_html = "<select class=\"form-control\" id=\"brand_idselect\" name=\"brand_id\"><option value=\"\" >Select</option>";
		foreach ($brand as $key) {
			//$brand_result_array[$key->id] = $key->brand_name;
			if($key->id == $brand_id)
				$brand_selected = ' selected';
			else
				$brand_selected = '';

			$brand_html .= "<option value=\"$key->id\" $brand_selected>$key->brand_name</option>";
		}
		$brand_html .= "</select>";
		
		$size = $this->Sizes->find()->where(['id IN' => $size_id_array]);
		$size_html = "<select class=\"form-control\" id=\"size_id_select\" name=\"size_id\"><option value=\"\" >Select</option>";
		foreach ($size as $key) {
			//$size_result_array[$key->id] = $key->size;
			if($key->id == $size_id)
				$size_selected = ' selected';
			else
				$size_selected = '';

			$size_html .= "<option value=\"$key->id\" $size_selected>$key->size</option>";
		}
		$size_html .= "</select>";

		$upload_hidden = $upload;
		$upload_html = '';
		$upload = explode(",", $upload);
		$total_image = '';
		if(sizeof($upload)){
			foreach ($upload as $uploadval) {
				if($uploadval == '')
					break;

				$image_explode = explode(".", $uploadval);
				$list_id = "image_".$image_explode[0];
				$set_imageid = str_replace(".", "#", $uploadval);
				$image_path = $this->request->webroot."gear_img/".$uploadval;
				$upload_html .= "<li id=\"$list_id\"><img src=\"$image_path\" alt=\"\"><a onclick=\"javascript: delete_image('".$set_imageid."')\"><i class=\"ion-close\"></i></a>";
				$total_image++;
			}
		}


		$return_data = $category_html."|".$product_name."|".$brand_html."|".$size_html."|".$colour_html."|".$price."|".$item_location."|".$description."|".$upload_html."|".$upload_hidden."|".$total_image;

  		$this->set(compact('user','return_data'));
        $this->set('_serialize', ['user','return_data']);

        if ($this->request->is(['post', 'put'])) {

        	// echo "<pre>";
        	// print_r($this->request->data);
        	// die;

        	$flag = true;

        	if ($this->request->data['category_id'] == "") {
                $this->Flash->error(__('Category can not be null. Please, try again.'));
                $flag = false;
            }
            if ($this->request->data['product_name'] == "") {
                $this->Flash->error(__('Product name can not be null. Please, try again.'));
                $flag = false;
            }
            if ($this->request->data['brand_id'] == "") {
                $this->Flash->error(__('Brand name can not be null. Please, try again.'));
                $flag = false;
            }
            if ($this->request->data['size_id'] == "") {
                $this->Flash->error(__('Size can not be null. Please, try again.'));
                $flag = false;
            }
            if ($this->request->data['price'] == "") {
                $this->Flash->error(__('Price can not be null. Please, try again.'));
                $flag = false;
            }
            if ($this->request->data['item_location'] == "") {
                $this->Flash->error(__('Item location can not be null. Please, try again.'));
                $flag = false;
            }

            $colour_array = array();
        	$colour_array = $this->request->data('colour_id');

        	if(sizeof($colour_array)){
        		$colour_value = '';
				foreach($colour_array as $colour_val){
					$colour_value .= $colour_val.",";
				}
				
				$colour_value = rtrim($colour_value,",");
				$this->request->data['colour_id'] = $colour_value;
        	}
			
			if(empty($colour_array)){
				$this->Flash->error(__('Please provide colour.'));
                $flag = false;
			}
			 
			if($this->request->data['upload'] == ''){
				$this->Flash->error(__('Please upload pictures.'));
                $flag = false;
			}
			else{
				$this->request->data['upload'] = rtrim($this->request->data['upload'],",");
				$gear_images_val = $this->request->data['upload'];
				$this->request->data['upload'] = '';
				$gear_image_array = explode(",", $gear_images_val);
				foreach($gear_image_array as $gearimage){
					$this->request->data['upload'] = $gearimage; break;
				}
				// echo "<br>";
				// echo $this->request->data['upload'];exit;

			}


			if($flag == true){
				$user = $this->Gears->patchEntity($user, $this->request->data);
			
				if ($this->Gears->save($user)) {

					foreach ($gear_image_array as $gearimage) {
						if($gearimage == '') continue;
						$image_exist = $this->Gearsimages->find()->where(['gear_id' => $id, 'name' => $gearimage])->first();
						if(count($image_exist)<1){

							$gears_images = $this->Gearsimages->newEntity();

							$this->request->data['gear_id'] = $id;
							$this->request->data['name'] = $gearimage;

							$gears_images = $this->Gearsimages->patchEntity($gears_images, $this->request->data);
							$this->Gearsimages->save($gears_images);

						}
					}

	                $this->Flash->success('Gears edited successfully.', ['key' => 'success']);
	                //pr($this->request->data); pr($user); exit;
	                $this->redirect(['action' => 'listgear']);
	            }
	            else{
	            	$this->Flash->error(__('Gears could not be edited. Please, try again.'));
	                return $this->redirect(['action' => 'listgear']);
	            }
			}
			else{
				$this->Flash->error(__('Gears could not be edited. Please, try again.'));
	            return $this->redirect(['action' => 'listgear']);
			}
			
        }

	}

	public function gearajaxdata(){
		$this->loadModel('Attributes');
		$this->loadModel('Brands');
		$this->loadModel('Sizes');
        $category_id = $_REQUEST['category_id'];
        //$category_id = 25;
        $category_data = $this->Attributes->find()->where(['category_id' => $category_id])->toArray();

        $brand_ids = $category_data[0]['brand_ids'];
        $brand_id_array = explode(',', $brand_ids);
        
        $size_ids = $category_data[0]['size_ids'];
        $size_id_array = explode(',', $size_ids);
        

        //$brand = $this->Brands->find('all',array('conditions' => array('Brands.status' => 1 ,'FIND_IN_SET(\''. $brand_ids .'\',Brands.brand_name)')));

  //       echo $brand = $this->Brands->find('all', array(
		//     'conditions' => array('Brands.id' => $brand_ids)
		// ));

		$brand = $this->Brands->find()->where(['id IN' => $brand_id_array]);
		$brand_select = "<option value=\"\">Select</option>";
		foreach ($brand as $key) {
			//$brand_result_array[$key->id] = $key->brand_name;
			$brand_select .= "<option value=\"$key->id\">$key->brand_name</option>";
		}

		$size = $this->Sizes->find()->where(['id IN' => $size_id_array]);
		$size_select = "<option value=\"\">Select</option>";
		foreach ($size as $key) {
			//$size_result_array[$key->id] = $key->size;
			$size_select .= "<option value=\"$key->id\">$key->size</option>";
		}

  		// $return_data['brand'] = $brand_result_array;
  		// $return_data['size'] = $size_result_array;

  		$return_data = $brand_select."|".$size_select;

		echo json_encode($return_data);
		
		exit();

	}

	public function uploadPhoto() {


        //$this->viewBuilder()->autoRender(false);
        $this->viewBuilder()->layout(false);
        $filen = '';
        //print_r($_FILES);
        if (!empty($_FILES['files']['name'])) {

            $no_files = count($_FILES["files"]['name']);

            //echo $no_files;exit;
            for ($i = 0; $i < $no_files; $i++) {
                if ($_FILES["files"]["error"][$i] > 0) {
                    echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
                    //echo 'a';exit;
                } else {

                    $pathpart = pathinfo($_FILES["files"]["name"][$i]);
                    //echo $pathpart;exit;
                    $ext = $pathpart['extension'];
                    $uploadFolder = "gear_img";
                    $uploadPath = WWW_ROOT . $uploadFolder;
                    $filename = uniqid() . '.' . $ext;
                    $full_flg_path = $uploadPath . '/' . $filename;
                    if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $full_flg_path)) {
                        //echo $product_id;exit;
                        // $this->request->data['ProductImage']['product_id'] = $product_id;
                        //$this->request->data['ProductImage']['name'] = $filename;
                        //echo $filename,exit;
                        //$this->admin_resize($full_flg_path, $filename,$ext);

                        $file = array('filename' => $filename, 'last_id' => $i + 1);

                        if ($filen == '') {
                            $filen = $filename;
                        } else {
                            $filen = $filen . ',' . $filename;
                        }
                    }
                    $file_details[] = $file;
                }
            }
            $data = array('Ack' => 1, 'data' => $file_details, 'image_name' => $filen);
        } else {

            $data = array('Ack' => 0);
        }
        echo json_encode($data);
        exit();
    }

    public function deleteImage() {

        // $this->loadModel('Gears');
        // $imageid = $this->Productsimages->get($_REQUEST['id']);
        // print_r($imageid);
        // if ($this->Productsimages->delete($imageid)) {
        //     if ($imageid->path != "") {
        //         $filePathDel = WWW_ROOT . 'product_img' . DS . $imageid->path;exit();
        //         if (file_exists($filePathDel)) {
        //             unlink($filePathDel);
        //         }
        //     }
        //     $data = array('Ack' => 1);
        // } else {
        //     $data = array('Ack' => 0);
        // }
        // // echo json_encode($data);
        // exit();

        $this->viewBuilder()->layout(false);
        $this->loadModel('Gearsimages');
        $image_name = str_replace("#", ".", $_REQUEST['id']);

        $get_image_id = $this->Gearsimages->find()->where(['name' => $image_name])->first();

        if(count($get_image_id) == 1){
        	$image_id = $get_image_id['id'];
	        $gearimages = $this->Gearsimages->get($image_id);
	        $this->Gearsimages->delete($gearimages);
        }
        

	    $filePathDel = WWW_ROOT . 'gear_img' . DS . $image_name;
	    if (file_exists($filePathDel)) {
	        unlink($filePathDel);
	        $data = array('Ack' => 1);
	    }
	    else{
	    	$data = array('Ack' => 0);
	    }
	    //$data = array('Ack' => 1);
	    echo json_encode($data);
	    exit();
	}
    
    
}

?>