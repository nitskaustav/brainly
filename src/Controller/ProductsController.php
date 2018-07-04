<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */  

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Routing\Router;

//use Cake\I18n\FrozenDate; 
use Cake\Database\Type; 
//use Cake\I18n\Time;
//use Cake\I18n\Date;
//Type::build('date')->setLocaleFormat('yyyy-MM-dd');

// Admin Users Management
class ProductsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['result', 'details','searchcategory','categorydetails','categorylisting','addtocart','removefromcart','updatecart','cart','bikelisting','proceedtocheckout','request','addtowishlist','addratingreview','buyermessage']);
     }   
    
    public $uses = array('User','Product');
    
   
     public function addproduct() {
        $this->viewBuilder()->layout('default');
        $this->loadModel('Users');
        $this->loadModel('Bikemodels');
        $this->loadModel('Makes');
        $this->loadModel('Colours');

        $user = $this->Users->get($this->Auth->user('id'));
        $id=$this->Auth->user('id');
        $uid = $this->request->session()->read('Auth.User.id');
        $utype = $this->request->session()->read('Auth.User.utype');
        $uverify = $user->check_verified;
        
        if($uid!='' && isset($uid) && $utype==2){
        $this->loadModel('Products');
        
        $product = $this->Products->newEntity();
        
        if ($this->request->is('post')) {

            $flag = true;
           
            $tableRegObj = TableRegistry::get('Products');

            $reg_number = trim($this->request->data['reg_number']);
            $mileage = trim($this->request->data['mileage']);

            $this->request->data['reg_number'] = $reg_number;
            $this->request->data['mileage'] = $mileage;

            //Registration Number Check

            $reg_exist = $this->Products->find()->where(['reg_number LIKE' => $reg_number])->first();

            if(count($reg_exist) == 1){
              $this->Flash->error(__('Registration number exists. Please try again.'));
              $this->redirect($this->referer());
            }
            else{
              // Validating Form

              if($this->request->data['reg_number'] == ""){
                  $this->Flash->error(__('Reg number can not be null. Please, try again.')); $flag = false;
              }

              if($flag){

                $this->request->data['seller_id']=$id;
                $curl = curl_init();
                // Set API Key
                //$ApiKey = "ED11FB54-17E4-4AF3-98DF-D2BA1CE99037";
                $ApiKey = "6B7E144A-B71C-483F-BD0F-6A4A29F7A32A";

                // Construct URL String
                $url = "https://uk1.ukvehicledata.co.uk/api/datapackage/%s?v=2&api_nullitems=1&key_vrm=%s&auth_apikey=%s";
                $url = sprintf($url, "VehicleData", $_POST['reg_number'], $ApiKey); // Syntax: sprintf($url, "PackageName", "VRM", ApiKey);
                // Note your package name here. There are 5 standard packagenames. Please see your control panel > weblookup or contact your account manager

                // Create array of options for the cURL session
                curl_setopt_array($curl, array(
                  CURLOPT_URL => $url,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_SSL_VERIFYPEER => false,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET"
                ));

                // Execute cURL session and store the response in $response
                $response = curl_exec($curl);

                // If the operation failed, store the error message in $error
                $error = curl_error($curl);

                // Close cURL session
                curl_close($curl);

                $value = json_decode($response, true);
                $reg_data = ($value['Response']['DataItems']);

                if(count($reg_data) > 0){
                // echo "<pre>";
                // print_r($reg_data);

                  foreach($reg_data as $reg_data_val=>$val){
                    if($reg_data_val == 'VehicleRegistration'){
                      //$vehicle_reg = $val;
                      $fuelType = $reg_data[$reg_data_val]['FuelType'];
                      $model = $reg_data[$reg_data_val]['Model'];
                      $colour = $reg_data[$reg_data_val]['Colour'];
                      $yearManufacture = $reg_data[$reg_data_val]['YearOfManufacture'];
                      $engineCapacity = $reg_data[$reg_data_val]['EngineCapacity'];
                      $make = $reg_data[$reg_data_val]['Make'];
                    }
                  }

                  if(isset($fuelType)){
                    if(strtolower($fuelType == 'petrol')){
                      $this->request->data['fuel_type'] = 'P';
                    }
                    elseif(strtolower($fuelType == 'diesel')){
                      $this->request->data['fuel_type'] = 'D';
                    }
                  }

                  if(isset($colour)){
                    if($this->Colours->find()->where(['name LIKE' => '%'.$colour.'%'])->first()){
                      $colourExistCheck = $this->Colours->find()->select('id')->where(['name LIKE' => '%'.$colour.'%'])->first();
                      $colour_id = $colourExistCheck->id;
                      $this->request->data['color'] = $colour_id;
                    }
                    else{
                      $colour_value['name'] = $colour;
                      $colour_value['status'] = 1;
                      $colourEntity = $this->Colours->newEntity();
                      $colourData = $this->Colours->patchEntity($colourEntity, $colour_value);
                      if ($rs = $this->Colours->save($colourData)){
                        $colour_id = $rs->id;
                        $this->request->data['color'] = $colour_id;
                      }
                    }
                  }

                  if(isset($yearManufacture)){
                    if($yearManufacture == 0)
                      $this->request->data['year'] = '';
                    else
                      $this->request->data['year'] = $yearManufacture;
                  }

                  if(isset($engineCapacity)){
                    $this->request->data['cc'] = $engineCapacity;
                  }

                  if(isset($model)){
                    if($this->Bikemodels->find()->where(['model_name LIKE' => '%'.$model.'%'])->first()){
                      $modelExistCheck = $this->Bikemodels->find()->select('id')->where(['model_name LIKE' => '%'.$model.'%'])->first();
                      $model_id = $modelExistCheck->id;
                      $this->request->data['model_id'] = $model_id;
                    }
                    else{
                      $model_name['model_name'] = $model;
                      $modelEntity = $this->Bikemodels->newEntity();
                      $modelData = $this->Bikemodels->patchEntity($modelEntity, $model_name);
                      if ($rs = $this->Bikemodels->save($modelData)){
                        $model_id = $rs->id;
                        $this->request->data['model_id'] = $model_id;
                      }

                    }

                  }

                  if(isset($make)){
                    if($this->Makes->find()->where(['make_name LIKE' => '%'.$make.'%'])->first()){
                      $makeExistCheck = $this->Makes->find()->select('id')->where(['make_name LIKE' => '%'.$make.'%'])->first();
                      $make_id = $makeExistCheck->id;
                      $this->request->data['make_id'] = $make_id;
                    }
                    else{
                      $make_name['make_name'] = $make;
                      $makeEntity = $this->Makes->newEntity();
                      $makeData = $this->Makes->patchEntity($makeEntity, $make_name);
                      if($rs = $this->Makes->save($makeData)){
                        $make_id = $rs->id;
                        $this->request->data['make_id'] = $make_id;
                      }
                    }

                  }
               
                }

                $product = $this->Products->patchEntity($product, $this->request->data);
                if ($rs=$this->Products->save($product)) {                 
                    $this->redirect(['action' => 'addproduct2/'.$rs->id]);
                }

              }

            }
        }       
        }else{
             $this->Flash->error('You have no permission to access this.');
            return $this->redirect(['controller'=>'Users','action'=>'signin']);
        }
    }

    public function editproduct($eid=null) {
        $this->viewBuilder()->layout('default');
        $this->loadModel('Users');
        $user = $this->Users->get($this->Auth->user('id'));
        $id=$this->Auth->user('id');
        $uid = $this->request->session()->read('Auth.User.id');
        $utype = $this->request->session()->read('Auth.User.utype');
        $uverify = $user->check_verified;
        
        if($uid!='' && isset($uid) && $utype==2){
        $this->loadModel('Products');
        
        
        $product = $this->Products->get($eid);
        if ($this->request->is('post')) {
            $flag = true;
           
            $tableRegObj = TableRegistry::get('Products');
           
            // Validating Form

            if($this->request->data['reg_number'] == ""){
                $this->Flash->error(__('Reg number can not be null. Please, try again.')); $flag = false;
            }
                      
            if($flag){
                
                if ($this->request->is('post')) {
                    $flag = true;           
                    $tableRegObj = TableRegistry::get('Products');                   
                    if($flag){           
                        $product = $this->Products->patchEntity($product, $this->request->data);
                        if ($this->Products->save($product)) {
                            $this->redirect(['action' => 'addproduct2/'.$eid]);
                        }
                    }
                }


            }
        }
        else{
            $this->set(compact('product'));
            $this->set('_serialize', ['product']);
        }       
        }else{
             $this->Flash->error('You have no permission to access this.');
            return $this->redirect(['controller'=>'Users','action'=>'signin']);
        }
    }
    
    
    
    public function addproduct2($eid=null) {
        $this->viewBuilder()->layout('default');
        $this->loadModel('Users');
        $this->loadModel('Categories');
        $this->loadModel('Bikemodels');
        $this->loadModel('Makes');
        $this->loadModel('Colours');
        $this->loadModel('EngineSizes');
        
      
        $user = $this->Users->get($this->Auth->user('id'));
        $id=$this->Auth->user('id');
        $uid = $this->request->session()->read('Auth.User.id');
        $utype = $this->request->session()->read('Auth.User.utype');
        $uverify = $user->check_verified;
        //echo $uverify;exit;
        if($uid!='' && isset($uid) && $utype==2){
        $this->loadModel('Products');
        
        $product = $this->Products->get($eid);
        if ($this->request->is('post')) {

            $flag = true;
           
            $tableRegObj = TableRegistry::get('Products');

            $price = trim($this->request->data['price']);
            $cc = trim($this->request->data['cc']);
            $no_of_owner = trim($this->request->data['no_of_owner']);
            $contact_email = trim($this->request->data['contact_email']);
            $contact_number = trim($this->request->data['contact_number']);

            $this->request->data['price'] = $price;
            $this->request->data['cc'] = $cc;
            $this->request->data['no_of_owner'] = $no_of_owner;
            $this->request->data['contact_email'] = $contact_email;
            $this->request->data['contact_number'] = $contact_number;


            if($flag){           
                $product = $this->Products->patchEntity($product, $this->request->data);
                if ($this->Products->save($product)) {
                    $this->redirect(['action' => 'addproduct3/'.$eid]);
                }
            }
        }
       
        $categorys=$this->Categories->find()->where(['Categories.status'=>1])->toArray();
        $models=$this->Bikemodels->find()->where(['Bikemodels.status'=>1])->toArray();
        $makes=$this->Makes->find()->where(['Makes.status'=>1])->toArray();
        $colours=$this->Colours->find()->where(['Colours.status'=>1])->toArray();
        $engins=$this->EngineSizes->find()->where(['EngineSizes.status'=>1])->toArray();
        //pr($stname);exit;
        $this->set(compact('categorys','models', 'product', 'makes', 'colours', 'engins'));
        $this->set('_serialize', ['categorys']);
        }else{
             $this->Flash->error('You have no permission to access this.');
            return $this->redirect(['controller'=>'Users','action'=>'signin']);
        }
    }
    
    
    
     public function addproduct3($eid=null) {
        $this->viewBuilder()->layout('default');
        $this->loadModel('Users');
        $this->loadModel('Categories');
        $this->loadModel('Productsimages');

        if($_REQUEST['back'] == 'back'){
          $this->redirect(['action' => 'addproduct2/'.$eid]);
        }
      
        $user = $this->Users->get($this->Auth->user('id'));
        $id=$this->Auth->user('id');
        $uid = $this->request->session()->read('Auth.User.id');
        $utype = $this->request->session()->read('Auth.User.utype');
        $uverify = $user->check_verified;
        //echo $uverify;exit;
        if($uid!='' && isset($uid) && $utype==2){
        $this->loadModel('Products');
        $images = $this->Productsimages->find()->where(['product_id' => $eid])->toArray();        
        $product = $this->Products->get($eid);
        if ($this->request->is('post')) {
            $flag = true;           
            $tableRegObj = TableRegistry::get('Products');                   
            if($flag){           
                $product = $this->Products->patchEntity($product, $this->request->data);
                if ($this->Products->save($product)) {
                    $this->redirect(['action' => 'addproduct4/'.$eid]);
                }
            }
        }
       
        
        $this->set(compact('product', 'images'));
        $this->set('_serialize', ['product']);
        }else{
             $this->Flash->error('You have no permission to access this.');
            return $this->redirect(['controller'=>'Users','action'=>'signin']);
        }
    }


    public function addproduct4($eid=null) {
        $this->viewBuilder()->layout('default');
        $this->loadModel('Users');
        $this->loadModel('Categories');
        $this->loadModel('Models');
        $this->loadModel('SiteSettings');
        $this->loadModel('Products');

        if($_REQUEST['back'] == 'back'){
          $this->redirect(['action' => 'addproduct3/'.$eid]);
        }
      
        $user = $this->Users->get($this->Auth->user('id'));
        $id=$this->Auth->user('id');
        $uid = $this->request->session()->read('Auth.User.id');
        $utype = $this->request->session()->read('Auth.User.utype');
        $uverify = $user->check_verified;
        //echo $uverify;exit;
        if($uid!='' && isset($uid) && $utype==2){
        $this->loadModel('Products');
        
        $product = $this->Products->get($eid);
        if ($this->request->is('post')) {

            $flag = true;
           
            $tableRegObj = TableRegistry::get('Products');

            $postal_code = trim($this->request->data['postal_code']);
            $this->request->data['postal_code'] = $postal_code;

            if($flag){           
                $product = $this->Products->patchEntity($product, $this->request->data);
                if ($this->Products->save($product)) {

                  //Seller Details
                  $seller_details_data = $this->Users->find()->where(['id' => $id])->first();
                  $full_name = $seller_details_data->first_name." ".$seller_details_data->last_name;
                  $seller_email = $seller_details_data->email;
                  $seller_phone = $seller_details_data->phone;

                  //Bike Details
                  $bike_details_data = $this->Products->find()->where(['id' => $eid])->first();
                  $bike_reg_no = $bike_details_data->reg_number;
                  

                  $mailusername = "Biketory";
                  $mail_subject = "New Product Upload";
                  $admin_mail_data = $this->SiteSettings->find()->first();
                  $admin_mail = $admin_mail_data->contact_email;
                  $mail_To = $admin_mail;
                  $emailfrom = $admin_mail;

                  $etRegObj = TableRegistry::get('EmailTemplates');
                  $emailTemp = $etRegObj->find()->where(['id' => 5])->first()->toArray();

                  $mail_body = str_replace(array('[REGNO]', '[NAME]', '[EMAIL]', '[CONTACT]'), array($bike_reg_no, $full_name, $seller_email, $seller_phone), $emailTemp['content']);

                  //die;

                  //Send Mail To Admin
                  $email_admin = new Email('default');
                  $email_admin->emailFormat('html')->from([$emailfrom => $mailusername])
                    ->to($mail_To)
                    ->subject($mail_subject)
                    ->send($mail_body);
                  


                  $etRegObj = TableRegistry::get('EmailTemplates');
                  $emailTemp = $etRegObj->find()->where(['id' => 6])->first()->toArray();

                  $mail_body = str_replace(array('[NAME]', '[REGNO]'), array($full_name, $bike_reg_no), $emailTemp['content']);

                  //Send Mail To Seller
                  $mail_To = $seller_email;
                  //$mail_To = 'kaustav@natitsolved.com';
                  $email_seller = new Email('default');
                  $email_seller->emailFormat('html')->from([$emailfrom => $mailusername])
                    ->to($mail_To)
                    ->subject($mail_subject)
                    ->send($mail_body);

                  $this->redirect(['action' => 'success']);
                }
            }
        }
       
        $categorys=$this->Categories->find()->where(['Categories.status'=>1])->toArray();
        $models=$this->Models->find()->where(['Models.status'=>1])->toArray();
        //pr($stname);exit;
        $this->set(compact('categorys','models', 'product'));
        $this->set('_serialize', ['categorys']);
        }else{
             $this->Flash->error('You have no permission to access this.');
            return $this->redirect(['controller'=>'Users','action'=>'signin']);
        }
    }

     public function success() {
        $this->viewBuilder()->layout('default');
       
    }
    
    
    public function uploadPhoto($id = null){
           $this->viewBuilder()->layout('false');
           $this->loadModel('Productsimages');
            if(!empty($_FILES['files']['name'])){
                $no_files = count($_FILES["files"]['name']);
                for ($i = 0; $i < $no_files; $i++) {
                  if ($_FILES["files"]["error"][$i] > 0) {
                      echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
                  } else {
                     $pathpart=pathinfo($_FILES["files"]["name"][$i]);                    
                      $ext=$pathpart['extension'];          
                      $uploadFolder = "product_img";
                      $uploadPath = WWW_ROOT . $uploadFolder;
                      $filename =uniqid().'.'.$ext;
                      $full_flg_path = $uploadPath . '/' . $filename;
                      if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $full_flg_path)) {
                        $data['product_id'] = $id;
                        $data['name'] = $filename;                           
                        $con = $this->Productsimages->newEntity();
                        $images = $this->Productsimages->patchEntity($con, $data);
                        if ($rs = $this->Productsimages->save($images)) {
                           $file = array('filename' => $filename, 'last_id' => $rs->id);
                                                                  
                        }                     
                        
                      } 
                      $file_details[] = $file;

                  }
                  
                  
              }
                $data = array('Ack'=>1, 'data'=>$file_details);
                    
               }
               else {

                 $data = array('Ack'=> 0);
               }
               echo json_encode($data);
              exit();
       }

        public function orderImage(){
           $this->viewBuilder()->layout('false');
           $this->loadModel('Productsimages');
           $i=1;         
            foreach ($_REQUEST['ids'] as $id) {
               $data['is_order'] = $i;
               $service = $this->Productsimages->get($id);
               $service = $this->Productsimages->patchEntity($service, $data);
               $this->Productsimages->save($service);
               $i++;
            }
             echo json_encode(array('Ack' => 1));
          die;
        }

        
       public function deleteImage(){          
             $this->viewBuilder()->layout('false');
             $this->loadModel('Productsimages');
             $image = $this->Productsimages->get($_REQUEST['id']);
            if ($this->Productsimages->delete($image)){ 
             $data = array('Ack'=> 1);
            }
              else{
                 $data = array('Ack'=> 0);
              }
              echo json_encode($data);
              exit();
       }
    
    
    public function listproduct() {
        $this->viewBuilder()->layout('default');
        $this->loadModel('Products');
        $this->loadModel('Users');
        $this->loadModel('Productsimages');
        $this->loadModel('Bikemodels');
        $this->loadModel('Makes');
        $this->loadModel('Categories');
        $user = $this->Users->get($this->Auth->user('id'));
        $uid = $this->request->session()->read('Auth.User.id');
        $utype = $this->request->session()->read('Auth.User.utype');
        $uverify = $user->check_verified;
        $conditions = ['Products.seller_id'=>$uid];
           
        $this->paginate = [
            'conditions' => $conditions,
            'contain' => ['Productsimages', 'Bikemodels', 'Makes', 'Categories'],
            'order' => [ 'id' => 'DESC']
        ];
        $products = $this->paginate($this->Products); 
       /* pr($products);
        die;  */    
        $this->set(compact('products','user'));
        $this->set('_serialize', ['products']);
 
    }
    
    
   public function productdelete($eid = null) {
        $this->loadModel('Products');
        $product = $this->Products->get($eid);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('Product has been deleted.'));
        } else {
            $this->Flash->error(__('Product could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'listproduct']);
    } 

    public function result(){

       $this->loadModel('Products');
       $this->loadModel('Productsimages');
       $this->loadModel('Bikemodels'); 
       $this->loadModel('Makes');
       $this->loadModel('Colours');

       $post_data = $this->request->data;
             
       $keyword = $this->request->data['keyword'];
       $postal_code = $this->request->data['postal_code'];
       $mileage = $this->request->data['mileage'];
       $make_id = $this->request->data['make_id'];
       $model_id = $this->request->data['model_id'];
       $min_cc = $this->request->data['min_cc'];
       $max_cc = $this->request->data['max_cc'];

       $min_price = $this->request->data['min_price'];
       $max_price = $this->request->data['max_price'];
       $mileage_from = $this->request->data['mileage_from'];
       $mileage_to = $this->request->data['mileage_to'];

       $sortby = $this->request->data['sortbyval'];

       $makes = $this->Makes->find()->where(['status' => 1])->toArray();
       $models = $this->Bikemodels->find()->where(['status' => 1])->toArray();

        $uid = $this->request->session()->read('Auth.User.id');
       $condition = array('is_active' => 'Y');

       if(isset($keyword) and $keyword != ""){
        $condition[] = array('Products.reg_number LIKE'=>'%'.$keyword.'%');
       }

        if(isset($postal_code) and $postal_code != ""){
            $condition[] = array('Products.postal_code'=> $postal_code);
        }

        if(isset($mileage) and $mileage != ""){
            $condition[] = array('Products.mileage'=> $mileage);
        }

        if(isset($make_id) and $make_id != ""){
            $condition[] = array('Makes.id'=> $make_id);
        }

        if(isset($model_id) and $model_id != ""){
            $condition[] = array('Bikemodels.id'=> $model_id);
        }

       if((isset($min_cc) and $min_cc != "") and (isset($max_cc) and $max_cc != "")){
          $condition[] = array('Products.cc >='.$min_cc.' and Products.cc <='.$max_cc);
         }

       if((isset($min_price) and $min_price != "") and (isset($max_price) and $max_price != "")){
        $condition[] = array('Products.price >='.$min_price.' and Products.price <='.$max_price);
       }

       if(isset($sortby) && $sortby != ""){
        if($sortby == 'h'){
          $order_by = "DESC";
        }
        elseif($sortby == 'l'){
          $order_by = "ASC";
        }
       }
       else{
        $order_by = "";
       }
       
       $colours = $this->Colours->find()->toArray();
       $products = $this->Products->find()                        
                        ->where($condition)                        
                        ->order(['Products.price' => $order_by])
                        ->contain(['Productsimages', 'Makes', 'Bikemodels']);

       $this->set(compact('products', 'makes', 'models','post_data','colours'));
    }

    public function details($id=null){
        
        $this->viewBuilder()->layout('default');
        $this->loadModel('Products');
        $this->loadModel('Users');
        $this->loadModel('Productsimages');
        $this->loadModel('Bikemodels');
        $this->loadModel('Makes');
        $this->loadModel('Categories');
        $this->loadModel('EmailTemplates');
        $this->loadModel('Messages');
        $this->loadModel('Wishlists');
        $this->loadModel('Recentviews');

        if($this->Auth->user('id')){
          $user_id = $this->Auth->user('id');
          $user = $this->Users->get($this->Auth->user('id'));
          $uid = $this->request->session()->read('Auth.User.id');
          $utype = $this->request->session()->read('Auth.User.utype');
          $uverify = $user->check_verified;
        }

        $product = $this->Products->find()->contain(['Productsimages','Users','Bikemodels', 'Makes', 'Categories'])->where(['Products.id' => $id])->first();

        $seller_id = $product->seller_id;

        $wishlist_data = $this->Wishlists->find()->where(['prod_id' => $id, 'user_id' => $user_id, 'status' => 'bikes'])->first();

        $recent_view['prd_id'] = $id;
        $recent_view['type'] = 'bike';
        $recent_view['ip_address'] = $this->request->clientIp();
        $recent_view['date_time'] = date('Y-m-d');

        $recentviewexists = $this->Recentviews->find()->where(['prd_id' => $id, 'type' => 'bike', 'date_time' => date('Y-m-d'), 'ip_address' => $this->request->clientIp()])->first();

        if(count($recentviewexists) == 0){
          $recentviews = $this->Recentviews->newEntity();
          $recentviews = $this->Recentviews->patchEntity($recentviews, $recent_view);
          $this->Recentviews->save($recentviews);
        }


          if ($this->request->is('post')) {
            if($this->Auth->user('id')){

            if ($this->request->data['name'] == "") {
                $this->Flash->error(__('Name can not be null. Please, try again.'));
                $flag = false;
            }

            
            $etRegObj = TableRegistry::get('EmailTemplates');
            $emailTemp = $etRegObj->find()->where(['id' => 4])->first()->toArray();            
            $name = $this->request->data['name'];
            $emailfrom = $this->request->data['email'];
            $phone = $this->request->data['phone'];            
            $message = $this->request->data['message'];
            $mail_To = $product['contact_email'];
            //$mail_To = 'kaustav@natitsolved.com';
            $mailusername = 'Biketory';
            //$mail_CC = '';
            $mail_subject = $emailTemp['subject'];
            $url = Router::url('/', true);


            $mail_body = str_replace(array('[NAME]', '[EMAIL]', '[PHONE]', '[MESSAGE]'), array($name, $emailfrom, $phone, $message), $emailTemp['content']);
            //echo $mail_body; exit;


            $email = new Email('default');
            $email->emailFormat('html')->from([$emailfrom => $mailusername])
                    ->to($mail_To)
                    ->subject($mail_subject)
                    ->send($mail_body);

            if($this->Auth->user('id')){
              $user_id = $this->Auth->user('id');

              $messageinstance = $this->Messages->newEntity();

              $message_data['user_id'] = $user_id;
              $message_data['seller_id'] = $seller_id;
              $message_data['prd_id'] = $id;
              $message_data['name'] = $name;
              $message_data['email'] = $emailfrom;
              $message_data['phone'] = $phone;
              $message_data['message'] = $message;

              $message_data = $this->Messages->patchEntity($messageinstance, $message_data);
              $rs=$this->Messages->save($message_data);

            }

            $this->Flash->success(__('Message delivered successfully.'));
          }
          else{
            $this->Flash->error(__('Please login to send message'));
            $this->redirect($this->referer());
          }
        }
        $this->set(compact('product','wishlist_data'));
        $this->set('_serialize', ['product']);
    }

    public function searchcategory($cat_id){
      
      $this->viewBuilder()->layout('default');
      //$this->loadModel('Users');
      $this->loadModel('Categories');
      $this->loadModel('Gears');
      $this->loadModel('Brands');

      $post_data = $this->request->data;

      $searchgear = $this->request->data['searchgear'];
      $category_select = $this->request->data['category_select'];
      $sortby = $this->request->data['sortbyval'];

      if(isset($searchgear) && $searchgear != ''){
        $condition[] = array('Gears.product_name LIKE' => '%'.$searchgear.'%');
      }

      if(isset($category_select) && $category_select != ''){
        $condition[] = array('Gears.category_id' => $category_select);
      }

      if($cat_id != 0){
        $condition[] = array('Gears.category_id' => $cat_id);
        $post_data['category_select'] = $cat_id;
      }

      if(isset($sortby) && $sortby != ""){
        if($sortby == 'h'){
          $order_by = "DESC";
        }
        elseif($sortby == 'l'){
          $order_by = "ASC";
        }
       }
       else{
        $order_by = "";
       }

       $condition[] = array('Gears.is_active' => 'Y');
      
      //$conditions = ['Gears.category_id' => $cat_id];

      $categories = $this->Categories->find()->toArray();
      /*$this->paginate = [
          'conditions' => $conditions,
          'contain' => ['Productsimages', 'Bikemodels', 'Makes', 'Categories'],
          'order' => [ 'id' => 'DESC']
      ];
      $products = $this->paginate($this->Products);*/
      /* pr($products);
      die;  */
      // $this->paginate = [
      //     'conditions' => $conditions,
      //     'contain' => ['Categories','Brands'],
      //     'order' => [ 'id' => 'DESC']
      // ];

      $gears = $this->Gears->find()                        
                        ->where($condition)                        
                        ->order(['Gears.price' => $order_by])
                        ->contain(['Categories', 'Brands']);

      //$gears = $this->paginate($this->Gears);

      
      $this->set(compact('gears','user','categories','post_data'));
      $this->set('_serialize', ['gears']);
    }

    public function categorydetails($product_id){

      $this->viewBuilder()->layout('default');
      //$this->loadModel('Users');
      $this->loadModel('Users');
      $this->loadModel('Categories');
      $this->loadModel('Gears');
      $this->loadModel('Brands');
      $this->loadModel('Wishlists');
      $this->loadModel('ReviewRatings');
      $this->loadModel('Gearsimages');
      $this->loadModel('Colours');
      $this->loadModel('Recentviews');


      if($this->Auth->user('id')){
        $user_id = $this->Auth->user('id');
        $user = $this->Users->get($this->Auth->user('id'));
        $uid = $this->request->session()->read('Auth.User.id');
        $utype = $this->request->session()->read('Auth.User.utype');
        $uverify = $user->check_verified;
      }

      // $recent_view['prd_id'] = $product_id;
      // $recent_view['type'] = 'gear';
      // $recent_view['ip_address'] = $this->request->clientIp();
      // $recent_view['date_time'] = date('Y-m-d');

      // $recentviewexists = $this->Recentviews->find()->where(['prd_id' => $product_id, 'type' => 'gear', 'date_time' => date('Y-m-d'), 'ip_address' => $this->request->clientIp()])->first();

      // if(count($recentviewexists) == 0){
      //   $recentviews = $this->Recentviews->newEntity();
      //   $recentviews = $this->Recentviews->patchEntity($recentviews, $recent_view);
      //   $this->Recentviews->save($recentviews);

      // }
      
      $conditions = ['Gears.id'=>$product_id];

      $this->paginate = [
          'conditions' => $conditions,
          'contain' => ['Categories','Brands'],
          'order' => [ 'id' => 'DESC']
      ];

      $gears = $this->paginate($this->Gears);

      $category_id = $this->Gears->find()->select('category_id')->where(['id' => $product_id])->toArray();

      foreach($category_id as $cat_id){
        $cat_id = $cat_id->category_id;
      }

      $gear_related_data = $this->Gears->find()->where(['category_id' => $cat_id])->toArray();

      $wishlist_data = $this->Wishlists->find()->where(['prod_id' => $product_id, 'user_id' => $user_id, 'status' => 'gears'])->first();

      $review_data = $this->ReviewRatings->find()->where(['prod_id' => $product_id, 'status' => 1])->contain(['Users'])->toArray();

      $gears_images = $this->Gearsimages->find()->where(['gear_id' => $product_id])->toArray();

      foreach ($gears as $gear_val) {
        $color_ids = $gear_val->colour_id;
      }
      $color_id_array = explode(",", $color_ids);

      $color_hexcode = $this->Colours->find()->where(["id IN" => $color_id_array])->toArray();


      $this->set(compact('gears','user','gear_related_data','wishlist_data','review_data','gears_images','color_hexcode'));
      $this->set('_serialize', ['gears']);

    }

    public function categorylisting(){
        $this->loadModel('Users');
        $this->loadModel('Makes');
        $this->loadModel('Bikemodels');
        $this->loadModel('Categories');

        $makes = $this->Makes->find()->where(['status' => 1])->toArray();
        $models = $this->Bikemodels->find()->where(['status' => 1])->toArray();
        $categories = $this->Categories->find()->toArray();

        $this->set(compact('makes', 'models', 'categories'));
    }

    public function addtocart($product_id){
      //echo $product_id;

      $this->viewBuilder()->layout('default');
      $this->loadModel('Users');
      $this->loadModel('Categories');
      $this->loadModel('Gears');
      $this->loadModel('Brands');
      $this->loadModel('Tempcarts');


      if($this->Auth->user('id')){
        //$temp_cart = $this->Tempcarts->newEntity();
        
        $user = $this->Users->get($this->Auth->user('id'));
        $uid = $this->request->session()->read('Auth.User.id');
        $utype = $this->request->session()->read('Auth.User.utype');
        $uverify = $user->check_verified;



        $conditions = ['Gears.id'=>$product_id];
        $this->paginate = [
            'conditions' => $conditions,
            'contain' => ['Categories','Brands'],
            'order' => [ 'id' => 'DESC']
        ];
        $gears = $this->paginate($this->Gears);

        //echo "<pre>";print_r($gears);exit;

        foreach ($gears as $gear_val) {
          $seller_id = $gear_val['user_id'];
          $category_name = $gear_val->category->name;
          $brand_name = $gear_val->brand->brand_name;
          $size = $gear_val->size_id;
          $price = $gear_val->price;
          $description = $gear_val->description;
          $item_location = $gear_val->item_location;
          $product_name = $gear_val->product_name;
          $upload = $gear_val->upload;
        }
        $upload_array = explode(",", $upload);


        

        $product_exist = $this->Tempcarts->find()->where(['user_id' => $user->id,'prd_id' => $product_id])->toArray();
        // echo "<pre>";
        // print_r($product_exist);die;



        if(!empty($product_exist)){

          foreach ($product_exist as $prod_val) {
            $id = $prod_val->id;
            $product_prev_quantity = $prod_val->quantity;
            $productbase_price = $prod_val->price;
          }
          $new_prd_qty = $product_prev_quantity+1;
          $new_product_price = $productbase_price*$new_prd_qty;

          $temp_cart_data['user_id'] = $user->id;
          $temp_cart_data['seller_id'] = $seller_id;
          $temp_cart_data['prd_id'] = $product_id;
          $temp_cart_data['name'] = $product_name;
          $temp_cart_data['image'] = $upload_array[0];
          $temp_cart_data['price'] = $new_product_price;
          $temp_cart_data['quantity'] = $new_prd_qty;
          // echo "<pre>";
          // print_r($temp_cart_data);die;
          $product_exist = $this->Tempcarts->get($id);
        }
        else{
          $product_exist = $this->Tempcarts->newEntity();
          $temp_cart_data['user_id'] = $user->id;
          $temp_cart_data['seller_id'] = $seller_id;
          $temp_cart_data['prd_id'] = $product_id;
          $temp_cart_data['name'] = $product_name;
          $temp_cart_data['image'] = $upload_array[0];
          $temp_cart_data['price'] = $price;
          $temp_cart_data['quantity'] = 1;
        }

        // echo "<pre>";
        // print_r($temp_cart_data);die;

        $temp_data = $this->Tempcarts->patchEntity($product_exist, $temp_cart_data);



        if ($rs=$this->Tempcarts->save($temp_data)) {
          $this->Flash->success(__('Product added to cart.'));
        }


        return $this->redirect(['action' => 'cart']);
        /*$all_temp_cart_data = $this->Tempcarts->find()->where(['user_id' => $user->id])->toArray();

        //echo "<pre>";print_r($all_temp_cart_data);die;


        $this->set(compact('gears','user','all_temp_cart_data'));
        $this->set('_serialize', ['gears']);*/
      }
      else{
        $this->Flash->error(__('Please login to add to cart'));
        return $this->redirect(['action' => 'categorylisting']);
      }

    }

    public function cart(){
      $this->loadModel('Users');
      $this->loadModel('Tempcarts');
      $this->loadModel('Gears');

      $user = $this->Users->get($this->Auth->user('id'));
      $uid = $this->request->session()->read('Auth.User.id');
      $utype = $this->request->session()->read('Auth.User.utype');
      $uverify = $user->check_verified;

      $all_temp_cart_data = $this->Tempcarts->find()->where(['Tempcarts.user_id' => $user->id])->contain(['Gears'])->toArray();

      $this->set(compact('user','all_temp_cart_data'));
    }

    public function updatecart(){
      
      $this->loadModel('Users');
      $this->loadModel('Tempcarts');
      $this->loadModel('Gears');

      $user = $this->Users->get($this->Auth->user('id'));
      $uid = $this->request->session()->read('Auth.User.id');
      $utype = $this->request->session()->read('Auth.User.utype');
      $uverify = $user->check_verified;

      if($this->request->is('post')){

        $qty = $this->request->data['qty'];
        $id = $this->request->data['id'];
        $user_id = $this->request->data['user_id'];
        $prd_id = $this->request->data['prd_id'];

        if($qty<1){
          $this->Flash->error(__('Quantity cannot be less than one. Please remove the product'));
          return $this->redirect(['action' => 'cart']);
        }

        $get_price = $this->Gears->find()->select('price')->where(['id' => $prd_id])->toArray();
        foreach ($get_price as $price) {
          $prd_price = $price->price;
        }

        $product_exist = $this->Tempcarts->get($id);

        foreach ($product_exist as $prod_details) {
          $qty = $prod_details->quantity;
        }

        $new_price = $qty*$prd_price;

        $update_array['quantity'] = $qty;
        $update_array['price'] = $new_price;

        $update_data = $this->Tempcarts->patchEntity($product_exist, $update_array);

        if ($rs=$this->Tempcarts->save($update_data)) {
          $this->Flash->success(__('Product quantity updated.'));
          return $this->redirect(['action' => 'cart']);
        }
      }

    }

    function removefromcart(){
      $this->loadModel('Users');
      $this->loadModel('Tempcarts');

      $user = $this->Users->get($this->Auth->user('id'));
      $uid = $this->request->session()->read('Auth.User.id');
      $utype = $this->request->session()->read('Auth.User.utype');
      $uverify = $user->check_verified;

      $id = $_REQUEST['id'];
      $temp_data = $this->Tempcarts->get($id);
      
      $this->Tempcarts->delete($temp_data);
      exit();
      
    }

    public function bikelisting(){
      $this->viewBuilder()->layout('default');
      $this->loadModel('Makes');

      $makes = $this->paginate($this->Makes);
      $this->set(compact('makes'));
    }

    public function proceedtocheckout($user_id){

      $this->viewBuilder()->layout('default');
      $this->loadModel('Users');
      $this->loadModel('Tempcarts');
      $this->loadModel('Gears');

      $user = $this->Users->get($this->Auth->user('id'));
      $uid = $this->request->session()->read('Auth.User.id');
      $utype = $this->request->session()->read('Auth.User.utype');
      $uverify = $user->check_verified;

      //$user_id = $this->request->data['user_id'];

      $all_temp_cart_data = $this->Tempcarts->find()->where(['Tempcarts.user_id' => $user_id])->contain(['Gears'])->toArray();

      $this->set(compact('user','all_temp_cart_data'));
    }

    public function payment(){

      $this->viewBuilder()->layout('default');
      $this->loadModel('Users');
      $this->loadModel('Tempcarts');
      $this->loadModel('Orders');
      $this->loadModel('Order_details');
      $this->loadModel('SiteSettings');

      $adminemail = $this->SiteSettings->find()->where(['id' => 1])->first();
      $admin_mail = $adminemail->contact_email;
      $admin_mail_title = 'Biketory';

      $user_id = $this->Auth->user('id');
      $orders = $this->Orders->newEntity();

      $user = $this->Users->get($this->Auth->user('id'));
      $uid = $this->request->session()->read('Auth.User.id');
      $utype = $this->request->session()->read('Auth.User.utype');
      $uverify = $user->check_verified;

      $buyer_name = $user->first_name." ".$user->last_name;
      $buyer_mail = $user->email;
      $buyer_phone = $user->phone;

      $buyer_html = '<div>
                      <span><b>Customer Details:</b></span><br>
                      <span><b>Name: </b>'.$buyer_name.'</span><br>
                      <span><b>Mail: </b>'.$buyer_mail.'</span><br>
                      <span><b>Phone: </b>'.$buyer_phone.'</span><br>
                    </div><br>';

      if($this->request->is('post')){

        // echo "<pre>";
        // print_r($this->request->data);die;

        $all_temp_cart_data = $this->Tempcarts->find()->where(['user_id' => $user_id])->toArray();

        $total_price = '';
        foreach($all_temp_cart_data as $cart_data){
          $total_price += $cart_data->price;
        }
        //echo $total_price;


        $ship_fname = trim($this->request->data['ship_fname']);
        $ship_lname = trim($this->request->data['ship_lname']);
        $ship_mob = trim($this->request->data['ship_mob']);
        $ship_pin = trim($this->request->data['ship_pin']);
        $ship_flat = trim($this->request->data['ship_flat']);
        $ship_area = trim($this->request->data['ship_area']);
        $ship_city = trim($this->request->data['ship_city']);
        $ship_state = trim($this->request->data['ship_state']);
        $ship_landmark = trim($this->request->data['ship_landmark']);
        $ship_country = trim($this->request->data['ship_country']);
        

        $bill_fname = trim($this->request->data['bill_fname']);
        $bill_lname = trim($this->request->data['bill_lname']);
        $bill_mob = trim($this->request->data['bill_mob']);
        $bill_pin = trim($this->request->data['bill_pin']);
        $bill_flat = trim($this->request->data['bill_flat']);
        $bill_area = trim($this->request->data['bill_area']);
        $bill_city = trim($this->request->data['bill_city']);
        $bill_state = trim($this->request->data['bill_state']);
        $bill_landmark = trim($this->request->data['bill_landmark']);
        $bill_country = trim($this->request->data['bill_country']);

        $paymethod = $this->request->data['paymethod'];

        $shipping_address = $ship_fname." ".$ship_lname.",".$ship_flat." ".$ship_area.",".$ship_landmark.",".$ship_mob.",".$ship_city.",".$ship_pin.",".$ship_state.",".$ship_country;

        $billing_address = $bill_fname." ".$bill_lname.",".$bill_flat." ".$bill_area.",".$bill_landmark.",".$bill_mob.",".$bill_city.",".$bill_pin.",".$bill_state.",".$bill_country;

        $ship_add_template = str_replace(",", "<br>", $shipping_address);
        $bill_add_template = str_replace(",", "<br>", $billing_address);

        $order_date = date('Y-m-d H:i:s');

        $address_template = '<div><span><b>Order Date:</b>'.$order_date.'</span></div>
        <table width="100%" border="1" style="border-collapse:collapse;">
                      <tr>
                        <th>Shipping Address</th>
                        <th>Billing Address</th>
                      </tr>
                      <tr>
                        <td>'.$ship_add_template.'</td>
                        <td>'.$bill_add_template.'</td>
                      </tr>
                      </table><br>';

        $orders_data['user_id'] = $user_id;
        $orders_data['order_date'] = $order_date;
        $orders_data['total_price'] = $total_price;
        $orders_data['payment_mode'] = $paymethod;
        $orders_data['shipping_address'] = $shipping_address;
        $orders_data['billing_address'] = $billing_address;

        $orderdata = $this->Orders->patchEntity($orders, $orders_data);
        $rs = $this->Orders->save($orderdata);

        $get_order_id = $this->Orders->find()->select('id')->where(['user_id' => $user_id])->order(['id' => 'DESC'])->limit(1)->toArray();

        foreach($get_order_id as $orderid){
          $order_id = $orderid->id;
        }
        

        foreach($all_temp_cart_data as $tempcartdata){
          $order_details = $this->Order_details->newEntity();

          $prd_id = $tempcartdata->prd_id;
          $price = $tempcartdata->price;
          $quantity = $tempcartdata->quantity;
          $single_unit_price = $price/$quantity;

          $order_details_data['seller_id'] = $tempcartdata->seller_id;
          $order_details_data['order_id'] = $order_id;
          $order_details_data['product_id'] = $prd_id;
          $order_details_data['price'] = $single_unit_price;
          $order_details_data['quantity'] = $quantity;

          $sellerid = $order_details_data['seller_id'];
          $name = $order_details_data['name'];
          $image = $order_details_data['image'];

          $prdname = $tempcartdata->name;
          $prdimage = $tempcartdata->image;
          $prdprice = $order_details_data['price'];
          $prdqty = $order_details_data['quantity'];

          $prddetailsarray = array();

          $prddetailsarray = array('name' => $prdname, 'image' => $prdimage, 'price' => $prdprice, 'qty' => $prdqty);

          $productarray[$sellerid][$prd_id] = $prddetailsarray;

          $orderdetails_patch = $this->Order_details->patchEntity($order_details, $order_details_data);
          $rs = $this->Order_details->save($orderdetails_patch);

        }

        $table_head = '<table width="60%" border="1" style="border-collapse:collapse;">
                      <tr>
                        <th colspan="3" align="center">Product Details</th>
                      </tr>
                      <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                      </tr>';
        $allprodprice = '';
        $table_buyer = '';

        foreach($productarray as $seller_id=>$prod_details){
          if($seller_id == 0){
            $contactemail = $this->SiteSettings->find()->where(['id' => 1])->first();
            $seller_mail = $contactemail->contact_email;
          }
          else{
            $contactemail = $this->Users->find()->select('email')->where(['id' => $seller_id])->first();
            $seller_mail = $contactemail->email;
          }


          $total_price = '';
          $table = '';

          foreach($prod_details as $prd_key=>$prd_value){
            $prdname = $prd_value['name'];
            $prdprice = $prd_value['price'];
            $prdqty = $prd_value['qty'];
            $total_price += $prdprice;
            $allprodprice += $prdprice;

            $table .= '<tr>
                        <td>'.$prdname.'</td>
                        <td align="right">'.$prdqty.'</td>
                        <td align="right">$'.$prdprice.'</td>
                      </tr>';

            $table_buyer .= '<tr>
                              <td>'.$prdname.'</td>
                              <td align="right">'.$prdqty.'</td>
                              <td align="right">$'.$prdprice.'</td>
                            </tr>';
          }
          $table_foot = '<tr>
                          <th colspan="2">Total Price</th>
                          <td align="right">$'.$total_price.'</td>
                        </tr>
                      </table><br>
                      <div><b>Thanks<br>Team Biketory</b></div>';
          
          $table_seller_template = $buyer_html.$address_template.$table_head.$table.$table_foot;

          $mail_body = $table_seller_template;
          $mail_To = $seller_mail;
          $mail_subject = "New Gear Order";
          
          $email = new Email('default');
          $email->emailFormat('html')->from([$admin_mail => $admin_mail_title])
                  ->to($mail_To)
                  ->subject($mail_subject)
                  ->send($mail_body);
        }

        $table_buyer_template = '<div><b>Your order has been placed successfully. You will receive a confirmation mail once your order is dispatched.</b></div><br>'.$table_head.$table_buyer;
        $table_buyer_template .= '<tr>
                        <th colspan="2">Total Price</th>
                        <td align="right">$'.$allprodprice.'</td>
                      </tr>
                      </table><br>
                      <div><b>Thanks<br>Team Biketory</b></div>';

        $buyermailbody = $table_buyer_template;
        $buyermailsubject = "Order Placed Successfully";

        $email = new Email('default');
        $email->emailFormat('html')->from([$admin_mail => $admin_mail_title])
                  ->to($buyer_mail)
                  ->subject($buyermailsubject)
                  ->send($buyermailbody);


        
        foreach($all_temp_cart_data as $tempcartdata){
          $get_id = $tempcartdata['id'];

          $empty_temp_data = $this->Tempcarts->get($get_id);
          $this->Tempcarts->delete($empty_temp_data);
        }
       
        
        //print_r($this->request->data);
        //print_r($all_temp_cart_data);die;
        $this->redirect(['action' => 'orderplaced']);
      }

      

    }

    public function orderplaced(){
      $this->viewBuilder()->layout('default');
      $this->loadModel('Users');

      $user = $this->Users->get($this->Auth->user('id'));
      $uid = $this->request->session()->read('Auth.User.id');
      $utype = $this->request->session()->read('Auth.User.utype');
      $uverify = $user->check_verified;

      //$this->Flash->success(__('Order successfully placed.'));

    }

    public function listorder(){
      $this->viewBuilder()->layout('default');
      $this->loadModel('Users');
      $this->loadModel('Orders');

      $user_id = $this->Auth->user('id');
      $user = $this->Users->get($this->Auth->user('id'));
      $uid = $this->request->session()->read('Auth.User.id');
      $utype = $this->request->session()->read('Auth.User.utype');
      $uverify = $user->check_verified;
      $orders = $this->Orders->find()->where(['user_id' => $user_id])->order(['id' => 'DESC'])->toArray();

      $this->set(compact('orders','user'));

      // echo "<pre>";
      // print_r($orders);
      // die;
    }

    public function listorderseller(){
      $this->viewBuilder()->layout('default');
      $this->loadModel('Users');
      $this->loadModel('Orders');
      $this->loadModel('OrderDetails');
      $this->loadModel('Gears');

      $user_id = $this->Auth->user('id');
      $user = $this->Users->get($this->Auth->user('id'));
      $uid = $this->request->session()->read('Auth.User.id');
      $utype = $this->request->session()->read('Auth.User.utype');
      $uverify = $user->check_verified;

      $seller_order = $this->OrderDetails->find()->where(['seller_id' => $user_id])->contain(['Orders'])->group('order_id')->toArray();
      
      //echo "<pre>";print_r($seller_order);exit;

      $this->set(compact('seller_order','user'));

    }

    public function listorderdetails($order_id){
      //echo $order_id; die;
      $this->viewBuilder()->layout('default');
      $this->loadModel('Users');
      $this->loadModel('Orders');
      $this->loadModel('OrderDetails');
      $this->loadModel('Gears');

      $user_id = $this->Auth->user('id');
      $user = $this->Users->get($this->Auth->user('id'));
      $uid = $this->request->session()->read('Auth.User.id');
      $utype = $this->request->session()->read('Auth.User.utype');
      $uverify = $user->check_verified;

      $order_details = $this->Orders->find()->where(['id' => $order_id])->contain(['OrderDetails'=>['Gears' => ['Users']]])->toArray();
     
      // echo "<pre>";
      // print_r($order_details);
      // die;

      $this->set(compact('order_details','user'));

    }

    public function listsellerorderdetails($order_id){
      $this->viewBuilder()->layout('default');
      $this->loadModel('Users');
      $this->loadModel('Orders');
      $this->loadModel('OrderDetails');
      $this->loadModel('Gears');

      $user_id = $this->Auth->user('id');
      $user = $this->Users->get($this->Auth->user('id'));
      $uid = $this->request->session()->read('Auth.User.id');
      $utype = $this->request->session()->read('Auth.User.utype');
      $uverify = $user->check_verified;

      $order_details = $this->OrderDetails->find()->where(['order_id' => $order_id,'seller_id' => $user_id])->contain(['Orders' => ['Users'],'Gears'])->toArray();

      // echo "<pre>";
      // print_r($order_details);exit;

      $this->set(compact('order_details','user'));

    }

    public function requestlist(){
      $this->viewBuilder()->layout('default');
      $this->loadModel('Users');
      $this->loadModel('Messages');
      
      $user_id = $this->Auth->user('id');
      $user = $this->Users->get($this->Auth->user('id'));
      $uid = $this->request->session()->read('Auth.User.id');
      $utype = $this->request->session()->read('Auth.User.utype');
      $uverify = $user->check_verified;

      $requestlist = $this->Messages->find()->where(['user_id' => $user_id])->toArray();

      // echo "<pre>";
      // print_r($requestlist);
      // die;

      $this->set(compact('requestlist','user'));

    }

    public function buyermessage(){
      $this->viewBuilder()->layout('default');
      $this->loadModel('Users');
      $this->loadModel('Messages');
      $this->loadModel('Products');
      
      $user_id = $this->Auth->user('id');
      $user = $this->Users->get($this->Auth->user('id'));
      $uid = $this->request->session()->read('Auth.User.id');
      $utype = $this->request->session()->read('Auth.User.utype');
      $uverify = $user->check_verified;

      $requestlist = $this->Messages->find()->where(['user_id' => $user_id])->contain(['Users','Products'])->toArray();
      $this->set(compact('requestlist','user'));
    }

    public function sellermessage(){
      $this->viewBuilder()->layout('default');
      $this->loadModel('Users');
      $this->loadModel('Messages');
      $this->loadModel('Products');
      
      $user_id = $this->Auth->user('id');
      $user = $this->Users->get($this->Auth->user('id'));
      $uid = $this->request->session()->read('Auth.User.id');
      $utype = $this->request->session()->read('Auth.User.utype');
      $uverify = $user->check_verified;

      $requestlist = $this->Messages->find()->where(['Messages.seller_id' => $user_id])->contain(['Users','Products'])->toArray();
      $this->set(compact('requestlist','user'));
    }

    public function request($product_id){
        
        $this->viewBuilder()->layout('default');
        $this->loadModel('Products');
        $this->loadModel('Users');
        $this->loadModel('Productsimages');
        $this->loadModel('Bikemodels');
        $this->loadModel('Makes');
        $this->loadModel('Categories');
        $this->loadModel('Requests');
        $this->loadModel('EmailTemplates');
        

        $product = $this->Products->find()->contain(['Productsimages','Users','Bikemodels', 'Makes', 'Categories'])->where(['Products.id' => $product_id])->first();

        // echo "<pre>";
        // print_r($product);
        // echo $product->productsimages[0]['name'];
        // die;

        if($this->Auth->user('id')){
          $user_id = $this->Auth->user('id');
          $etRegObj = TableRegistry::get('EmailTemplates');
          $emailTemp = $etRegObj->find()->where(['id' => 4])->first()->toArray();            
          $name = $product->Users->first_name." ".$product->Users->last_name;
          $emailfrom = $product->Users->email;
          $phone = $product->Users->phone;            
          $message = "Product request";
          $mail_To = $product['contact_email'];
          //$mail_To = 'kaustav@natitsolved.com';
          $mailusername = 'Biketory';
          //$mail_CC = '';
          $mail_subject = $emailTemp['subject'];
          $url = Router::url('/', true);


          $mail_body = str_replace(array('[NAME]', '[EMAIL]', '[PHONE]', '[MESSAGE]'), array($name, $emailfrom, $phone, $message), $emailTemp['content']);
          //echo $mail_body;die; 


          $email = new Email('default');
          $email->emailFormat('html')->from([$emailfrom => $mailusername])
                  ->to($mail_To)
                  ->subject($mail_subject)
                  ->send($mail_body);

          $requestinstance = $this->Requests->newEntity();
          $request_data['user_id'] = $product->Users->id;
          $request_data['prd_id'] = $product->id;
          if($product->product_name){
            $request_data['prd_name'] = $product->product_name;
          }
          else{
            $request_data['prd_name'] = '';
          }
          
          $request_data['image'] = $product->productsimages[0]['name'];


          $request_data = $this->Requests->patchEntity($requestinstance, $request_data);
          $rs = $this->Requests->save($request_data);

          $this->Flash->success(__('Request Message delivered successfully.'));

          return $this->redirect(['controller'=>'Products','action'=>'result']);
        }
        else{
          $this->Flash->error(__('Please login to send request message'));
          return $this->redirect(['controller'=>'Products','action'=>'result']);
        }
        $this->set(compact('product'));
        $this->set('_serialize', ['product']);
    }

    public function addtowishlist(){

      $product_id = $_REQUEST['id'];
      $status = $_REQUEST['status'];

      if($status == 'gears')
        $message = 'Gear';
      else if($status == 'bikes')
        $message = 'Bike';

      $this->viewBuilder()->layout('false');
      $this->loadModel('Products');
      $this->loadModel('Users');
      $this->loadModel('Gears');
      $this->loadModel('Wishlists');
      $this->loadModel('Productsimages');
      $this->loadModel('Bikemodels');
      $this->loadModel('Makes');
      $this->loadModel('Categories');

      if($this->Auth->user('id')){

        $user_id = $this->Auth->user('id');
        $user = $this->Users->get($this->Auth->user('id'));
        $uid = $this->request->session()->read('Auth.User.id');
        $utype = $this->request->session()->read('Auth.User.utype');
        $uverify = $user->check_verified;

        $wishlistexist = $this->Wishlists->find()->where(['prod_id' => $product_id, 'user_id' => $user_id, 'status' => $status])->first();

        
        if(count($wishlistexist) > 0){

          $wishlist_id = $wishlistexist->id;
          $getwishlistdata = $this->Wishlists->get($wishlist_id);

          if ($this->Wishlists->delete($getwishlistdata)){ 
            echo "$message removed from wish list";
          }

        }
        else{
          $wishlist = $this->Wishlists->newEntity();

          $wishlist_data['user_id'] = $user_id;
          $wishlist_data['prod_id'] = $product_id;
          $wishlist_data['status'] = $status;

          $wishlist_data = $this->Wishlists->patchEntity($wishlist, $wishlist_data);

          if($this->Wishlists->save($wishlist_data)){
            echo "$message added to wish list";
          }
        }

      }
      else{
        echo "FALSE";exit;
      }
      
      exit;
    }

    function removewishlist(){
      $id = $_REQUEST['id'];
      $status = $_REQUEST['status'];

      $this->viewBuilder()->layout('false');
      $this->loadModel('Users');
      $this->loadModel('Wishlists');

      if($this->Auth->user('id')){

        $user_id = $this->Auth->user('id');
        $user = $this->Users->get($this->Auth->user('id'));
        $uid = $this->request->session()->read('Auth.User.id');
        $utype = $this->request->session()->read('Auth.User.utype');
        $uverify = $user->check_verified;

        $getwishlistdata = $this->Wishlists->get($id);
        if ($this->Wishlists->delete($getwishlistdata)){ 
          echo "$message removed from wish list";exit;
        }

      }
      else{
        echo "FALSE";exit;
      }
      exit;

    }

    public function wishlisting(){

      $this->viewBuilder()->layout('default');
      $this->loadModel('Products');
      $this->loadModel('Users');
      $this->loadModel('Gears');
      $this->loadModel('Wishlists');

      $user_id = $this->Auth->user('id');
      $user = $this->Users->get($this->Auth->user('id'));
      $uid = $this->request->session()->read('Auth.User.id');
      $utype = $this->request->session()->read('Auth.User.utype');
      $uverify = $user->check_verified;

      $wishlistgeardata = $this->Wishlists->find()->where(['Wishlists.user_id' => $user_id,'status' => 'gears'])->contain(['Gears'])->toArray();

      $wishlistbikedata = $this->Wishlists->find()->where(['Wishlists.user_id' => $user_id,'Wishlists.status' => 'bikes'])->contain(['Products' => ['Productsimages','Bikemodels','Makes']])->toArray();

      // echo "<pre>";
      // print_r($wishlistbikedata);die;

      $this->set(compact('wishlistgeardata','wishlistbikedata','user'));
      
    }

    public function addratingreview($gear_id){
      $this->viewBuilder()->layout('default');
      $this->loadModel('Users');
      $this->loadModel('ReviewRatings');
      
      if($this->Auth->user('id')){
        $reviewRatings = $this->ReviewRatings->newEntity();
        
        $user = $this->Users->get($this->Auth->user('id'));
        $uid = $this->request->session()->read('Auth.User.id');
        $utype = $this->request->session()->read('Auth.User.utype');
        $uverify = $user->check_verified;

        $user_id = $user->id;
        $rating = $this->request->data['rating'];
        $review = $this->request->data['review'];

        $rating_review['user_id'] = $user_id;
        $rating_review['prod_id'] = $gear_id;
        $rating_review['rating'] = $rating;
        $rating_review['review'] = $review;
        $rating_review['review_date'] = date('Y-m-d H:i:s');

        $reviewRating_data = $this->ReviewRatings->patchEntity($reviewRatings, $rating_review);

        if ($rs=$this->ReviewRatings->save($reviewRating_data)) {
          $this->Flash->success(__('Review added'));
          $this->redirect($this->referer());
          //return $this->redirect(['action' => 'addratingreview',$gear_id]);
        }
      }
      else{
        $this->Flash->error(__('Please login to add to cart'));
        $this->redirect($this->referer());
      }
    }
}

?>