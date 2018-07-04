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

Type::build('date')->setLocaleFormat('yyyy-MM-dd');

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */

/*
 * Users Controller
 * Frontend User Management
 */

class UsersController extends AppController {

    public $paginate = ['limit' => 10];

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['signup', 'signin', 'forgotpassword', 'setpassword', 'activeaccount', 'paynow','index','searchlist','servicedetails','ajaxaddtofavourite']);
        $this->loadComponent('Paginator');
    }

    public $uses = array('User', 'Admin');

    public function index() {
        
        $this->viewBuilder()->layout('default');
        $this->loadModel('ServiceTypes');
        $this->loadModel('Services');
        $servicetype = $this->ServiceTypes->find()->where(['status' => 1])->toArray();
        $allservicelocation = $this->Services->find()->where(['is_active' => 1])->toArray();
        //pr($allservicelocation);
        $this->set(compact('servicetype','allservicelocation'));
       
    }
    
    
     public function fblogin()
    {
    	$this->autoRender = false;
           
    	$fb_id=$this->Users->find("first",array('conditions'=>array('Users.facebook_id'=>$this->request->data['Users']['facebook_id'])));
    	
    	if(count($fb_id)<1)
    	{
          //$email=$this->request->data('email_address');
    		if(isset($this->request->data['Users']['email']))
    	{
             $email=$this->Users->find("first",array('conditions'=>array('Users.email'=>$this->request->data['Users']['email'])));
              if(count($email)<1)
              {
              	$this->Users->save($this->request->data);
              	$user=$this->Users->find("first",array('conditions'=>array('Users.email'=>$this->request->data['Users']['email'])));
              	

            //log in the user with facebook credentials
            $this->Auth->login($user['User']);
				//$this->Auth->login() ;
			
				$data['url']= $this->webroot.'users/dashboard';
				//$data['url']= $this->webroot;
				$data['is_active']=1;
              }
              else
              {
                 $data=''; 
              }
          }
          else
          {
          	//pr($this->request->data);exit;
          	//echo "fghfgh";exit;
             $this->Users->save($this->request->data);
			
              	$user=$this->Users->find("first",array('conditions'=>array('User.facebook_id'=>$this->request->data['Users']['facebook_id'])));
				 $this->Auth->login($user['Users']) ;
              	//$this->Session->write('userid', $user['User']['id']);
                //$this->Session->write('username', $user['User']['first_name']);
				//$this->Session->write('user_type', $user['User']['user_type']);
				$data['url']=Configure::read('SITE_URL').'users/dashboard';
				//$data['url']=Configure::read('SITE_URL');
				$data['is_active']=1;//$user['User']['status'];
          }
    	}
    	else
    	{
		
            $this->Auth->login($fb_id['User']) ;
			//pr($this->Session->read());exit;
				$data['url']=Configure::read('SITE_URL').'users/home';
				//$data['url']=Configure::read('SITE_URL');
				$data['status']=1;//$user['User']['status'];


    	}

    	echo json_encode($data);
    	
    }
    
    public function signup() {

        //$this->viewBuilder()->layout('default');

        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {

            $flag = true;
            $tableRegObj = TableRegistry::get('Users');
            $userExist = $tableRegObj
                            ->find()
                            ->where(['email' => $this->request->data['email']])->toArray();

            // Users form validation
            
            if ($this->request->data['firstname'] == "" && $this->request->data['lastname'] == "") {
                $this->Flash->error(__('First Name and Last Name can not be null. Please, try again.'));
                $flag = false;
            }
            
             if ($this->request->data['password'] != $this->request->data['con_password']) {
                $this->Flash->error(__('Password and confirm password not matched. Please, try again.'));
                $flag = false;
            }
           
            if ($flag) {
                if ($userExist) {
                    $flag = false;
                    $this->Flash->error(__('Email Already Registered, try with another.'));
                }
            }

            if ($flag) {
                // Saving data after validating the form
                $fullname = $this->request->data['firstname'] . " " .$this->request->data['lastname'];
                $themail = $this->request->data['email'];
                $this->request->data['full_name']= $fullname;
                $this->request->data['utype']= $this->request->data['utype'];
                //$this->request->data['password'] = base64_encode($this->request->data['password']);
                $this->request->data['ptxt'] = base64_encode($this->request->data['password']);
                $this->request->data['created'] = gmdate("Y-m-d h:i:s");
                $this->request->data['modified'] = gmdate("Y-m-d h:i:s");

                $user = $this->Users->patchEntity($user, $this->request->data);
                if ($rs = $this->Users->save($user)) {

                    //$unique_id = $this->generateRandomString();
                    //$unique_id = $unique_id . $rs->id;

                    //$subquestion = TableRegistry::get('Users');
                    //$query = $subquestion->query();
                    //$query->update()->set(['unique_id' => $unique_id])->where(['id' => $rs->id])->execute();



                    $etRegObj = TableRegistry::get('EmailTemplates');
                    $emailTemp = $etRegObj->find()->where(['id' => 2])->first()->toArray();

                    $chkPost = base64_encode($rs->id . "/" . $themail);
                    $mail_To = $themail;
                    //$mail_CC = '';
                    $mail_subject = $emailTemp['subject'];
                    $url = Router::url('/', true);
                    $link = $url . 'users/activeaccount/' . $chkPost;

                    $mail_body = str_replace(array('[NAME]', '[LINK]'), array($fullname, $link), $emailTemp['content']);
                    //echo $mail_body; //exit;

                    //Sending user email validation link
                    $email = new Email('default');
                    $email->emailFormat('html')->from(['nit.spandan@gmail.com'=>'Jimja'])
                            ->to($mail_To)
                            ->subject($mail_subject)
                            ->send($mail_body);
                                    
                    $this->Flash->success(__('You are registered successfully. Please check you mail for verification link'));
                    
                }
            }
        }
                return $this->redirect(['action' => 'index']);
        //$this->set(compact('user'));
        //$this->set('_serialize', ['user']);
    }
    
    
    public function activeaccount($idnew) {

        $this->viewBuilder()->layout('default');

        //if ($this->request->session()->check('Auth.User') == true) {
            $this->redirect(['controller' => 'Users', 'action' => 'index']);
        

//        if ($this->request->session()->check('Auth.Doctor') == true) {
//            $this->redirect(['controller' => 'Doctors', 'action' => 'dashboard']);
//        }

        $idText = base64_decode($idnew);
        $idTextArr = explode("/", $idText);
        //pr($idTextArr);

        $tableRegObj = TableRegistry::get('Users');
        $userExist = $tableRegObj->find()->where(['email' => $idTextArr[1]])->first();

        //pr($userExist); exit;
        //echo $idnew; pr($idTextArr); echo $idText; pr($userExist); exit;
        if ($userExist) {
             $subquestion = TableRegistry::get('Users');
            $query = $subquestion->query();
            $query->update()->set(['is_mail_verified' => 1, 'is_active' => 1])->where(['id' => $idTextArr[0]])->execute();
             $message="Your account verified successfully.Please Login Now!";
           
        } else {
            $message= "Your account not exist.";
            
        }

        $this->set(compact('message'));

        //$this->autoRender = false;
    }
    
    public function signin($val = null) {
       
        //$this->viewBuilder()->layout('default');
        if ($this->request->is('post')) {

            $user = $this->Auth->identify();

            if ($user) {
                if ($user['is_mail_verified'] == 1) {
                    if ($user['is_active'] == 1) {
                        $this->Auth->setUser($user);
                        if ($user['utype'] == 1) {

                            $SiteSettings = $this->site_setting();
                            $is_login = 0;
                           
                            
                            $this->Flash->success(__('You are Loged In Successfully.'));
                            $this->redirect(['controller' => 'Users','action'=>"dashboard"]);

                        } else if ($user['utype'] == 2) {

                            $this->Flash->success(__('You are Loged In Successfully.'));
                            $this->redirect(['controller' => 'Users','action'=>"servicedashboard"]);
                        }
                    } else {
                        $this->Flash->error('Your Account Not activated.');
                        return $this->redirect(['action' => 'index']);
                    }
                } else {
                    $this->Flash->error('Your Email Id Not verified.');
                    return $this->redirect(['action' => 'index']);
                }
            } else {
                $this->Flash->error('Your username or password is incorrect.');
                return $this->redirect(['action' => 'index']);
            }
        }
    }
    
    
     public function signout() {
        $this->Auth->logout();
        $this->Flash->success(__('You are Successfully loged out.'));
        return $this->redirect('/');
    }
    
    public function dashboard() {
        
        $this->viewBuilder()->layout('other_layout');
        $title="Dashboard";
        $this->loadModel('Users');
        $uid = $this->request->session()->read('Auth.User.id');
        $user = $this->Users->get($this->Auth->user('id'));
        
        if($uid!='' && isset($uid)){
            
             $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
            if (!empty($this->request->data['image']['name'])) {
                $file = $this->request->data['image']; //put the data into a var for easy use
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                $fileName = time() . "." . $ext;
                if (in_array($ext, $arr_ext)) {
                    
                    if ($user->pimg != "" && $user->pimg != $fileName ) {
                        $filePathDel = WWW_ROOT . 'user_img' . DS . $user->pimg;
                        if (file_exists($filePathDel)) {
                            unlink($filePathDel);
                        }
                    }                     
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'user_img' . DS . $fileName);
                    $file = $fileName;
                    $this->request->data['pimg'] = $fileName;
                } else {
                    $flag = false;
                    $this->Flash->error(__('Upload image only jpg,jpeg,png files.'));
                }
            } else {
                $this->request->data['pimg'] = $user->pimg;
            }
         
            //pr($user);
        $this->set(compact('user','title'));
        $this->set('_serialize', ['user']);   
           
        
        }else{
        
            $this->Flash->error('Please login to access dashboard.');
            return $this->redirect('/');
            
        }
        
        
    }
    
public function servicedashboard() {
        
        $this->viewBuilder()->layout('other_layout');
        $title="Dashboard";
        $this->loadModel('Users');
        $uid = $this->request->session()->read('Auth.User.id');
        $user = $this->Users->get($this->Auth->user('id'));
        
        if($uid!='' && isset($uid)){
            
             $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
            if (!empty($this->request->data['image']['name'])) {
                $file = $this->request->data['image']; //put the data into a var for easy use
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                $fileName = time() . "." . $ext;
                if (in_array($ext, $arr_ext)) {
                    
                    if ($user->pimg != "" && $user->pimg != $fileName ) {
                        $filePathDel = WWW_ROOT . 'user_img' . DS . $user->pimg;
                        if (file_exists($filePathDel)) {
                            unlink($filePathDel);
                        }
                    }                     
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'user_img' . DS . $fileName);
                    $file = $fileName;
                    $this->request->data['pimg'] = $fileName;
                } else {
                    $flag = false;
                    $this->Flash->error(__('Upload image only jpg,jpeg,png files.'));
                }
            } else {
                $this->request->data['pimg'] = $user->pimg;
            }
         
            //pr($user);
        $this->set(compact('user','title'));
        $this->set('_serialize', ['user']);   
           
        
        }else{
        
            $this->Flash->error('Please login to access dashboard.');
            return $this->redirect('/');
            
        }
        
        
    }
 //service edit
    public function serviceeditprofile() {
        
         $this->loadModel('ServiceProviderImages');
        $this->loadModel('ServiceProviderDocuments');
        $this->loadModel('ServiceTypes'); 
        $this->loadModel('Tags'); 
        $this->loadModel('Features'); 
        $this->viewBuilder()->layout('other_layout');
        $user = $this->Users->get($this->Auth->user('id'));
        $id=$this->Auth->user('id');
        if ($this->request->is(['post', 'put'])) {
            
            $flag = true;

            if ($flag) {
                //print_r($this->request->data);exit;

                $servicetype = implode(',',$this->request->data['service_type_id']);
                $servicetag = implode(',',$this->request->data['service_tag_id']);
                $servicefeature = implode(',',$this->request->data['service_feature_id']);
                $workingdays = implode(',',$this->request->data['working_days']);
                $this->request->data['service_type_id']=$servicetype;
                $this->request->data['service_tag_id']=$servicetag;
                $this->request->data['service_feature_id']=$servicefeature;
                $this->request->data['working_days'] = $workingdays;
                //pr($this->request->data);
                //exit;
                $user = $this->Users->patchEntity($user, $this->request->data);
                $user['modified'] = gmdate("Y-m-d H:i:s");
                if ($this->Users->save($user)) {
                    
                    if($this->request->data['image']!=''){  
                    $file_image_name = explode(",",$this->request->data['image']);
                     //print_r($file_image_name);exit;
                    foreach( $file_image_name as $img)
                {
                        
                        
                $this->request->data['serviceprovider_id'] = $id;
                $this->request->data['image_name'] = $img;
                $spimage = $this->ServiceProviderImages->newEntity();        
                $spimage = $this->ServiceProviderImages->patchEntity($spimage, $this->request->data);
                
                $this->ServiceProviderImages->save($spimage);
                         
                }
                    
                    }
                    if($this->request->data['document']!=''){ 
                     $file_doc_name = explode(",",$this->request->data['document']);
                     
                    foreach( $file_doc_name as $img)
                {
                        
                        
                $this->request->data['serviceprovider_id'] = $id;
                $this->request->data['doc_name'] = $img;
                $spimage = $this->ServiceProviderDocuments->newEntity();        
                $spimage = $this->ServiceProviderDocuments->patchEntity($spimage, $this->request->data);
                
                $this->ServiceProviderDocuments->save($spimage);
                         
                }
                    } 

//                if ($this->request->data['password'] == "") {
//                    $this->request->data['password'] = base64_decode($user->ptxt);
//                    $this->request->data['ptxt'] = $user->ptxt;
//                } else {
//                    $this->request->data['ptxt'] = base64_encode($this->request->data['password']);
//                }

                $user = $this->Users->patchEntity($user, $this->request->data);
                if ($this->Users->save($user)) {

                    //pr($user); exit;
                    $this->Flash->success(__('Your profile has been edited successfully.'));
                    return $this->redirect(['action' => 'serviceeditprofile']);
                } else {

                    $this->Flash->error(__('Your profile could not be edited. Please, try again.'));
                    //return $this->redirect(['action' => 'editprofile']);
                }
            } else {
                $this->Flash->error(__('Your profile could not be edited. Please, try again.'));
            }
        }
        }
         $all_image = $this->ServiceProviderImages->find()->where(['ServiceProviderImages.serviceprovider_id' => $this->Auth->user('id')])->toArray();
        $all_document = $this->ServiceProviderDocuments->find()->where(['ServiceProviderDocuments.serviceprovider_id' => $this->Auth->user('id')])->toArray();
        
        $tags = $this->Tags->find()->where(['Tags.status' => 1])->toArray();
        $features = $this->Features->find()->where(['Features.status' => 1])->toArray();
        $servicetypes = $this->ServiceTypes->find()->where(['ServiceTypes.status' => 1])->toArray();
        $this->set(compact('user','servicetypes','all_image','tags','features','all_document'));
        $this->set('_serialize', ['user','servicetypes','all_image']);
    }

 public function uploadphotoaddi(){
            
            
           //$this->viewBuilder()->autoRender(false);
           $this->viewBuilder()->layout(false);
            $filen = '';
            //print_r($_FILES);
            if(!empty($_FILES['files']['name'])){

                $no_files = count($_FILES["files"]['name']);
                
                //echo $no_files;exit;
                for ($i = 0; $i < $no_files; $i++) {
                  if ($_FILES["files"]["error"][$i] > 0) {
                      echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
                      //echo 'a';exit;
                  } else {
                      
                     $pathpart=pathinfo($_FILES["files"]["name"][$i]); 
                     //echo $pathpart;exit;
                      $ext=$pathpart['extension'];          
                      $uploadFolder = "user_img/";
                      $uploadPath = WWW_ROOT . $uploadFolder;
                      $filename =uniqid().'.'.$ext;
                      $full_flg_path = $uploadPath . '/' . $filename;
                      if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $full_flg_path)) { 
                          //echo $product_id;exit;
                       // $this->request->data['ProductImage']['product_id'] = $product_id;
                        //$this->request->data['ProductImage']['name'] = $filename;
                        //echo $filename,exit;
                        //$this->admin_resize($full_flg_path, $filename,$ext);
                     
                     $file = array('filename' => $filename, 'last_id' => $i+1);
                     
                     if($filen == '')
                     {
                         $filen = $filename;
                     }
                     else
                     {
                         $filen = $filen.','.$filename;
                     }   
                        
                      } 
                      $file_details[] = $file;

                  }
                  
                  
              }
                $data = array('Ack'=>1, 'data'=>$file_details,'image_name'=>$filen);
                    
               }
               else {

                 $data = array('Ack'=> 0);
               }
               echo json_encode($data);
              exit();
       }
    
       
      public function uploaddocadd(){
            
            
           //$this->viewBuilder()->autoRender(false);
           $this->viewBuilder()->layout(false);
            $filen = '';
            //print_r($_FILES);
            if(!empty($_FILES['files1']['name'])){

                $no_files = count($_FILES["files1"]['name']);
                
                //echo $no_files;exit;
                for ($i = 0; $i < $no_files; $i++) {
                  if ($_FILES["files1"]["error"][$i] > 0) {
                      echo "Error: " . $_FILES["files1"]["error"][$i] . "<br>";
                      //echo 'a';exit;
                  } else {
                      
                     $pathpart=pathinfo($_FILES["files1"]["name"][$i]); 
                     //echo $pathpart;exit;
                      $ext=$pathpart['extension'];          
                      $uploadFolder = "user_doc/";
                      $uploadPath = WWW_ROOT . $uploadFolder;
                      $filename =uniqid().'.'.$ext;
                      $full_flg_path = $uploadPath . '/' . $filename;
                      if (move_uploaded_file($_FILES['files1']['tmp_name'][$i], $full_flg_path)) { 
                          //echo $product_id;exit;
                       // $this->request->data['ProductImage']['product_id'] = $product_id;
                        //$this->request->data['ProductImage']['name'] = $filename;
                        //echo $filename,exit;
                        //$this->admin_resize($full_flg_path, $filename,$ext);
                     
                     $file = array('filename' => $filename, 'last_id' => $i+1);
                     
                     if($filen == '')
                     {
                         $filen = $filename;
                     }
                     else
                     {
                         $filen = $filen.','.$filename;
                     }   
                        
                      } 
                      $file_details[] = $file;

                  }
                  
                  
              }
                $data = array('Ack'=>1, 'data'=>$file_details,'image_name'=>$filen);
                    
               }
               else {

                 $data = array('Ack'=> 0);
               }
               echo json_encode($data);
              exit();
       }
       
       
       public function deleteimage(){          
             
              //$this->viewBuilder()->layout(false);
              $this->loadModel('ServiceProviderImages');
              $imageid = $this->ServiceProviderImages->get($_GET['id']);
              
              
              if($this->ServiceProviderImages->delete($imageid)){
                   if ($imageid->image_name != "") {
                        $filePathDel = WWW_ROOT . 'user_img' . DS . $imageid->image_name;
                        if (file_exists($filePathDel)) {
                            unlink($filePathDel);
                        }
                    }
                 $data = array('Ack'=> 1);
              }
              else{
                 $data = array('Ack'=> 0);
              }
              echo json_encode($data);
              exit();
       }
    public function deletedocument(){          
             
              //$this->viewBuilder()->layout(false);
              $this->loadModel('ServiceProviderDocuments');
              $imageid = $this->ServiceProviderDocuments->get($_REQUEST['id']);
              
              if($this->ServiceProviderDocuments->delete($imageid)){
                  
                  if ($imageid->doc_name != "") {
                        $filePathDel = WWW_ROOT . 'user_doc' . DS . $imageid->doc_name;
                        if (file_exists($filePathDel)) {
                            unlink($filePathDel);
                        }
                    }
                 $data = array('Ack'=> 1);
              }
              else{
                 $data = array('Ack'=> 0);
              }
              echo json_encode($data);
              exit();
       }
       
       
       
       

     // Users edit profile
    public function editprofile() {
        
        $this->viewBuilder()->layout('other_layout');
        $user = $this->Users->get($this->Auth->user('id'));
        if ($this->request->is(['post', 'put'])) {
            
            $flag = true;

            if ($flag) {

                $this->request->data['modified'] = gmdate("Y-m-d h:i:s");
                $this->request->data['preference']= implode(',',$this->request->data['preference']);
                $this->request->data['interest']= implode(',',$this->request->data['interest']);

//                if ($this->request->data['password'] == "") {
//                    $this->request->data['password'] = base64_decode($user->ptxt);
//                    $this->request->data['ptxt'] = $user->ptxt;
//                } else {
//                    $this->request->data['ptxt'] = base64_encode($this->request->data['password']);
//                }

                $user = $this->Users->patchEntity($user, $this->request->data);
                if ($this->Users->save($user)) {

                    //pr($user); exit;
                    $this->Flash->success(__('Your profile has been edited successfully.'));
                    return $this->redirect(['action' => 'editprofile']);
                } else {

                    $this->Flash->error(__('Your profile could not be edited. Please, try again.'));
                    //return $this->redirect(['action' => 'editprofile']);
                }
            } else {
                $this->Flash->error(__('Your profile could not be edited. Please, try again.'));
            }
        }
        
        $this->loadModel('Tags');
        $tags = $this->Tags->find()->where(['Tags.status' => 1])->toArray();
        $this->loadModel('Interests'); 
        $servicetypes = $this->Interests->find()->where(['Interests.status' => 1])->toArray();

        $this->set(compact('user','tags','servicetypes'));
        $this->set('_serialize', ['user']);
    }
    
    
     public function searchlist() {
      $this->viewBuilder()->layout('other_layout');
      $this->loadModel('Services');
      //this->loadModel('Tags');
        if ($this->request->is('post')) {
         $search_key = $this->request->data['search'];   
         $service_id=  $this->request->data['service_id'];
         $conditions = ['Services.service_type_id' => $service_id];
          
        if($search_key!='')
        {
            $conditions['OR']['Users.full_name LIKE']='%'.$search_key.'%';
            $conditions['OR']['Services.service_name LIKE']='%'.$search_key.'%';
            $conditions['OR']['Services.city_name LIKE']='%'.$search_key.'%';
            $conditions['OR']['Services.country LIKE']='%'.$search_key.'%';
            $conditions['OR']['Users.description LIKE']='%'.$search_key.'%';
            $conditions['OR']['Users.pricing LIKE']='%'.$search_key.'%';
            //$conditions['OR']['tag_name LIKE']='%'.$search_key.'%';
            
        } 
       
        //$this->Services->recursive = 2; 
         $top_result = $this->Services->find()->where([$conditions])->contain(['Users','ServiceProviderTags'=>['Tags']])->limit(2)->toArray();
         //pr($top_result);
          $rest_result = $this->Services->find()->where([$conditions])->contain(['Users','ServiceProviderTags'=>['Tags']])->limit(8)->offset(2)->toArray();
          $result = $this->Services->find()->where([$conditions])->contain(['Users','ServiceProviderTags'=>['Tags']])->toArray();
          
         $this->set(compact('top_result','rest_result','result'));
         
         
         
        }
    
    }
    
    public function servicedetails($sid = NULL) {
        
      $this->viewBuilder()->layout('other_layout');
      $this->loadModel('Services');
      $conditions = ['Services.id' => $sid];
         
          $result = $this->Services->find()->where([$conditions])->contain(['Users','ServiceProviderTags'=>['Tags'],'ServiceProviderFeatures'=>['Features']])->first();
         // pr($result);
          
         $this->set(compact('result'));
         
       
    }
    
    
    public function favouritelist() {
      $this->viewBuilder()->layout('other_layout');
      $this->loadModel('Services');
      //this->loadModel('Tags');
      
         $this->set(compact('top_result','rest_result','result'));
         
    }
    
    public function ajaxaddtofavourite($id = null) {
        //$this->viewBuilder()->autoRender(false);
        $this->viewBuilder()->layout(false);
        $this->loadModel('Favourites');
        $this->loadModel('Services');
        $Faviourit = $this->Favourites->newEntity();
        $serviceExist = $this->Services->find()->where(['Services.id' => $id])->toArray();
        if (!$serviceExist) {
            $Msg = 'Invalid Service';
        }
        $userid = $this->request->session()->read('Auth.User.id');
        if (!isset($userid) && $userid == '') {
            $Msg = array('Ack'=> 0, 'data'=> 'Please Login First.');
        } else {
            
           $product = $this->Services->find()->where(['id'=>$id])->first();
           //pr($product);exit;
           
           $Current_woner_id = $product['provider_id'];
           //echo $Current_woner_id;exit;
           $productsInCart = $this->Favourites->find()->where(['Favourites.user_id' => $userid])->toArray();

            if ($this->request->is('post')) {
                $product_woner_id = '';
                $alreadyIn = false;
                $woner_check = false;
                if (count($productsInCart) > 0) {
                    foreach ($productsInCart as $productInCart) {
                        $product_woner_id = $productInCart['service_woner_id'];
                        if ($productInCart['service_id'] == $id) {
                            $alreadyIn = true;
                        }
                    }
                }

                if (!$alreadyIn && !$woner_check && $userid != $Current_woner_id) {

                    
                    $this->request->data['service_id'] = $id;
                    $this->request->data['user_id'] = $userid;
                    $this->request->data['service_owner_id'] = $Current_woner_id;
                    $this->request->data['add_date'] = gmdate('Y-m-d H:i:s');
                    $Faviourit = $this->Favourites->patchEntity($Faviourit, $this->request->data);
                    //print_r($this->request->data);exit;
                    if ($this->Favourites->save($Faviourit)) {
                        $Msg = array('Ack'=>1, 'data'=> 'Service added to favourite list.');
                    } else {
                        $Msg = array('Ack'=>0, 'data'=> 'The Service could not be saved into the faviourite list. Please, try again.');
                    }
                   
                } elseif ($userid == $Current_woner_id) {
                    $Msg = array('Ack'=>0, 'data'=> 'You cannot add your own Service.');
                } else {
                    $Msg = array('Ack'=>0, 'data'=> 'Service already in favourite list.');
                }
            }
        }
       echo json_encode($Msg);
       exit();
    }
    
    
    
    
    public function upload_photo_add(){
            
            
           //$this->viewBuilder()->autoRender(false);
           $this->viewBuilder()->layout(false);
            $filen = '';
            //print_r($_FILES);
            if(!empty($_FILES['files']['name'])){

                $no_files = count($_FILES["files"]['name']);
                
                //echo $no_files;exit;
                for ($i = 0; $i < $no_files; $i++) {
                  if ($_FILES["files"]["error"][$i] > 0) {
                      echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
                      //echo 'a';exit;
                  } else {
                      
                     $pathpart=pathinfo($_FILES["files"]["name"][$i]); 
                     //echo $pathpart;exit;
                      $ext=$pathpart['extension'];          
                      $uploadFolder = "user_img/";
                      $uploadPath = WWW_ROOT . $uploadFolder;
                      $filename =uniqid().'.'.$ext;
                      $full_flg_path = $uploadPath . '/' . $filename;
                      if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $full_flg_path)) { 
                          
                     
                     $file = array('filename' => $filename, 'last_id' => $i+1);
                     
                     if($filen == '')
                     {
                         $filen = $filename;
                     }
                     else
                     {
                         $filen = $filen.','.$filename;
                     }   
                        
                      } 
                      $file_details[] = $file;

                  }
                  
                  
              }
                $data = array('Ack'=>1, 'data'=>$file_details,'image_name'=>$filen);
                    
               }
               else {

                 $data = array('Ack'=> 0);
               }
               echo json_encode($data);
              exit();
       }
    
    
    
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //spandan jimja
    
   
    

    /*
     * Users Login Section
     */
    


    // User Logout
    

    //Doctors Logout
//    public function logout() {
//        $session = $this->request->session();
//        //$session->delete('Auth.Doctor');
//        $session->delete('Auth.User');
//        return $this->redirect('/');
//    }

    // Reset password for users
    public function forgotpassword() {

//        if ($this->request->session()->check('Auth.User') == true) {
//            $this->redirect(['controller' => 'Users', 'action' => 'dashboard']);
//        }
//
//        if ($this->request->session()->check('Auth.Doctor') == true) {
//            $this->redirect(['controller' => 'Doctors', 'action' => 'dashboard']);
//        }

        //$this->viewBuilder()->layout('default');
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {

            // Checking if User is valid or not.
            $tableRegObj = TableRegistry::get('Users');
            $userExist = $tableRegObj->find()->where(['email' => $this->request->data['email']])->first()->toArray();

            $etRegObj = TableRegistry::get('EmailTemplates');
            $emailTemp = $etRegObj->find()->where(['id' => 1])->first()->toArray();

            $siteSettings = $this->site_setting();
            //pr($siteSettings); pr($emailTemp); pr($userExist); pr($this->request->data); exit;
            if (!empty($userExist)) {
                $chkPost = $this->generateRandomString(); //Generating new Password

                $userdt = TableRegistry::get('Users');
                $query = $userdt->query();

                $query->update()->set(['cpass_req' => 1, 'cpass_value' => $chkPost])->where(['id' => $userExist['id']])->execute();

                $mail_To = $userExist['email'];
                $mail_CC = '';
                $mail_subject = $emailTemp['subject'];
                $name = $userExist['first_name'] . " " . $userExist['last_name'];
                $url = Router::url('/', true);
                $link = $url . 'users/setpassword/' . $chkPost;

                $mail_body = str_replace(array('[NAME]', '[LINK]'), array($name, $link), $emailTemp['content']);
                //echo $mail_body; //exit;

                // Sending user the reset password link.
                $email = new Email('default');
                if ($email->emailFormat('html')->from(['info@proptino.com' => 'Proptino'])
                                ->to($userExist['email'])
                                ->subject($mail_subject)
                                ->send($mail_body)) {
                    $this->Flash->success(__('Your change password link has been sent to your email.'));
                    return $this->redirect(array('action' => 'forgotpassword'));
                } else {
                    $this->Flash->error(__('Email Not Registerd With Us, try with another.'));
                }
            } else {
                $this->Flash->error(__('Email Not Registerd With Us, try with another.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    // Reset password from the generated mail.
    public function setpassword($ckval = null) {

//        if ($this->request->session()->check('Auth.User') == true) {
//            $this->redirect(['controller' => 'Users', 'action' => 'dashboard']);
//        }
//
//        if ($this->request->session()->check('Auth.Doctor') == true) {
//            $this->redirect(['controller' => 'Doctors', 'action' => 'dashboard']);
//        }
//

        if ($this->request->is(['post', 'put'])) {
            //echo "lll"; die;
            // Checking Password and Confirm Password
            $flag = true;
            if ($this->request->data['password'] != $this->request->data['cpassword']) {
                $this->Flash->error('Password not matched with Confirm password.');
                $flag = false;
            }

            //Saving new password
            if ($flag) {
                $user = $this->Users->find()->where(['id' => $this->request->data['id']])->first();
                $user = $this->Users->patchEntity($user, ['password' => $this->request->data['password']]);

                
                $user->password = $this->request->data['password'];
                $this->Users->save($user);
                $new = $user->password;

                $userdt = TableRegistry::get('Users');
                $query = $userdt->query();
                $query->update()->set(['cpass_req' => 0, 'cpass_value' => ''])->where(['id' => $this->request->data['id']])->execute();
                $this->Flash->success(__('Your password changed successfully.'));
                return $this->redirect(array('action' => 'signin'));
            } else {
                $this->Flash->error(__('Enter Password and Confirm Password Properly.'));
            }
        }

        $tableRegObj = TableRegistry::get('Users');
        $user = $tableRegObj->find()->where(['cpass_value' => $ckval, 'cpass_req' => 1])->first();

        if (empty($user)) {
            $this->Flash->error(__('Invalid Link. make forgot password request again.'));
            return $this->redirect(array('action' => 'forgotpassword'));
        } else {
            //pr($user); exit;
            //$userdt = TableRegistry::get('Users');
            //$query = $userdt->query();
            //$query->update()->set(['cpass_req' => 0, 'cpass_value' => ''])->where(['id' => $user->id])->execute();
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /*
      public function logout() {
      return $this->redirect($this->Auth->logout());
      } */

    // New user registration
    

    // Users account activation
    

    /*
      public function editprofile($id = null) {
      $this->viewBuilder()->layout('admin');
      $user = $this->Users->get($id);
      if ($this->request->is(['post', 'put'])) {
      //pr($this->request->data); exit;
      $flag = true;
      if ($this->request->data['first_name'] == "") {
      $this->Flash->error(__('First Name can not be null. Please, try again.'));
      $flag = false;
      }

      if ($this->request->data['last_name'] == "") {
      $this->Flash->error(__('Last Name can not be null. Please, try again.'));
      $flag = false;
      }

      if ($this->request->data['phone'] == "") {
      $this->Flash->error(__('Phone can not be null. Please, try again.'));
      $flag = false;
      }

      if ($this->request->data['epassword'] != "") {
      $this->request->data['password'] = $this->request->data['epassword'];
      }

      if ($flag) {
      $user = $this->Users->patchEntity($user, $this->request->data);
      $this->request->data['modified'] = gmdate("Y-m-d h:i:s A");
      if ($this->Users->save($user)) {
      $this->Flash->success(__('Patient has been edited successfully.'));
      return $this->redirect(['action' => 'listuser']);
      } else {
      $this->Flash->error(__('Patient could not be edit. Please, try again.'));
      return $this->redirect(['action' => 'listuser']);
      }
      } else {
      return $this->redirect(['action' => 'listuser']);
      }
      }
      $this->set(compact('user'));
      $this->set('_serialize', ['user']);
      }
     */

    // Patients Dashboard after login
    

    // Patients approved orders
    public function approvedorder() {

        $this->loadModel('Orders');
        $this->loadModel('Users');
        $uid = $this->request->session()->read('Auth.User.id');
        $user = $this->Users->get($this->Auth->user('id'));
        $this->set(compact('user', 'trans'));
        $this->set('_serialize', ['user']);

        $this->loadModel('Orders');
        $query = $this->Orders->find()->where(['Orders.user_id' => $uid, 'Orders.is_complete' => 1, 'isverified' => 1, 'is_reject' => 0, 'is_delivered' => 0, 'is_reject' => 0])->all()->toArray();

        $uniqueDt = array();
        foreach ($query as $q) {
            $uniqueDt[$q->transaction_id]['id'] = $q->id;
        }
        $dtArr = array();
        foreach ($uniqueDt as $dt) {
            $dtArr[$dt['id']] = $dt['id'];
        }
        if (empty($dtArr)) {
            $dtArr[0] = 0;
        }
        $this->set('orders', $this->Paginator->paginate($this->Orders, [ 'limit' => 10, 'order' => [ 'id' => 'DESC'], 'conditions' => [ 'id IN' => $dtArr]]));
        $this->set(compact('dtArr'));
    }

    //Patients rejected orders
    public function rejectedorder() {

        $this->loadModel('Orders');
        $this->loadModel('Users');
        $uid = $this->request->session()->read('Auth.User.id');
        $user = $this->Users->get($this->Auth->user('id'));
        $this->set(compact('user', 'trans'));
        $this->set('_serialize', ['user']);

        $this->loadModel('Orders');
        $query = $this->Orders->find()->where(['Orders.user_id' => $uid, 'Orders.is_complete' => 1, 'isverified' => 0, 'is_reject' => 1])->all()->toArray();

        $uniqueDt = array();
        foreach ($query as $q) {
            $uniqueDt[$q->transaction_id]['id'] = $q->id;
        }
        $dtArr = array();
        foreach ($uniqueDt as $dt) {
            $dtArr[$dt['id']] = $dt['id'];
        }
        if (empty($dtArr)) {
            $dtArr[0] = 0;
        }
        $this->set('orders', $this->Paginator->paginate($this->Orders, [ 'limit' => 10, 'order' => [ 'id' => 'DESC'], 'conditions' => [ 'id IN' => $dtArr]]));
        $this->set(compact('orders'));
        $this->set(compact('dtArr'));
    }

    //Patients Delivered Orders
    public function deliveredorder() {

        $this->loadModel('Orders');
        $this->loadModel('Users');
        $uid = $this->request->session()->read('Auth.User.id');
        $user = $this->Users->get($this->Auth->user('id'));
        $this->set(compact('user', 'trans'));
        $this->set('_serialize', ['user']);

        $this->loadModel('Orders');
        $query = $this->Orders->find()->where(['Orders.user_id' => $uid, 'Orders.is_complete' => 1, 'isverified' => 1, 'is_delivered' => 1])->all()->toArray();

        $uniqueDt = array();
        foreach ($query as $q) {
            $uniqueDt[$q->transaction_id]['id'] = $q->id;
        }
        $dtArr = array();
        foreach ($uniqueDt as $dt) {
            $dtArr[$dt['id']] = $dt['id'];
        }
        if (empty($dtArr)) {
            $dtArr[0] = 0;
        }
        $this->set('orders', $this->Paginator->paginate($this->Orders, [ 'limit' => 10, 'order' => [ 'id' => 'DESC'], 'conditions' => [ 'id IN' => $dtArr]]));
        $this->set(compact('dtArr'));
    }

    // Users prescription Details Page with Delivery Details
    public function newprescriptiondetail($txn = null) {
        $this->loadModel('Users');
        $uid = $this->request->session()->read('Auth.User.id');
        $user = $this->Users->get($this->request->session()->read('Auth.User.id'));

        $this->loadModel('Treatments');
        $this->loadModel('Orders');
        $this->loadModel('Orderdetails');
        $this->loadModel('Medicines');
        $this->loadModel('Pils');
        $this->loadModel('Prescriptions');

        $orderExist = $this->Orders->find()->contain(['Orderdetails', 'Treatments', 'Orderdetails.Medicines'])->where(['Orders.transaction_id' => $txn])->all()->toArray();
        $presc = $this->Prescriptions->find()->where(['Prescriptions.txnid' => $txn])->all()->toArray();

        foreach ($orderExist as $oExist) {
            $dt = json_decode($oExist['question']);
        }

        if ($this->request->is('post')) {

            //pr($this->request->data); exit;
            $this->loadModel('Users');
            $this->loadModel('Orders');
            $user = $this->Users->get($this->request->session()->read('Auth.Doctor.id'));
            if ($txn != "") {
                $ord = $this->Orders->find()->where(['Orders.transaction_id' => $this->request->data['transid']])->all()->toArray();
                //echo $txn; pr($user);pr($ord); exit;
                foreach ($ord as $ordDet) {
                    $tableRegObj = TableRegistry::get('Orders');
                    $query = $tableRegObj->query();
                    $query->update()->set(['isverified' => 2, 'reasion' => $this->request->data['data'], 'verifiedby' => $user['id']])->where(['id' => $ordDet->id])->execute();
                }

                $this->Flash->success(__('Prescription Rejected successfully.'));
                return $this->redirect(['action' => 'newprescription']);
            } else {
                return $this->redirect(['action' => 'newprescription']);
            }
        }

        //pr($orderExist); exit;


        $this->set(compact('orderExist', 'user', 'presc'));
        $this->set('_serialize', ['user']);
    }

    //Users prescription details
    public function prescriptiondetail($txn = null) {
        $this->loadModel('Users');
        $uid = $this->request->session()->read('Auth.User.id');
        $user = $this->Users->get($this->request->session()->read('Auth.User.id'));

        $this->loadModel('Transactions');
        $this->loadModel('Treatments');
        $this->loadModel('Orders');
        $this->loadModel('Orderdetails');
        $this->loadModel('Medicines');
        $this->loadModel('Pils');
        $this->loadModel('Prescriptions');
        $this->loadModel('Reviews');

        $transaction = $this->Transactions->find()->where(['Transactions.transaction_id' => $txn])->first()->toArray();
        $orderExist = $this->Orders->find()->contain(['Orderdetails', 'Treatments', 'Orderdetails.Medicines'])->where(['Orders.transaction_id' => $txn])->all()->toArray();
        $presc = $this->Prescriptions->find()->where(['Prescriptions.txnid' => $txn])->all()->toArray();

        $medArr = array();
        foreach($orderExist as $ordExist){
            foreach($ordExist['orderdetails'] as $ordDet){
                $medArr[] = $ordDet->medicine->id;
            }
        }
        $medArr = array_unique($medArr);

        if(!empty($medArr)){
            if(count($medArr) == 1){
                $revMedicine = $medArr[0];
            } else {
                $revMedicineDt = "";
                foreach($medArr as $k=>$v){
                    $revMedicineDt = $revMedicineDt.",".$v;
                }
                $revMedicine = ltrim($revMedicineDt, ",");
            }
        } else {
            $revMedicine = "";
        }



        foreach ($orderExist as $oExist) {
            $dt = json_decode($oExist['question']);
        }

        if ($this->request->is('post')) {

            //pr($this->request->data);
            if($this->request->data['ftype'] == 'msg'){
                $this->loadModel('Ordermsgs');
                $ordermsgsTable = TableRegistry::get('Ordermsgs');
                $ordermsg = $ordermsgsTable->newEntity();
                $ordermsg->ordid = $this->request->data['transid'];
                $ordermsg->fromid = $this->request->data['fromid'];
                $ordermsg->toid = $this->request->data['toid'];
                $ordermsg->msg = $this->request->data['msg'];
                $ordermsg->pid = $this->request->data['pid'];
                $ordermsg->type = $this->request->data['type'];
                $ordermsg->fromtype = $this->request->data['fromtype'];
                $ordermsg->totype = $this->request->data['totype'];
                $ordermsg->date = gmdate('Y-m-d H:i:s');
                if ($ordermsgsTable->save($ordermsg)) {
                    $id = $ordermsg->id;
                }
                $this->Flash->success(__('Message Sent To Customer Care Successfully.'));
            }

            if($this->request->data['ftype'] == 'review'){
                //pr($this->request->data); exit;
                if(!empty($this->request->data['rate']))
                {
                    $orde = $this->Orders->find()->where(['Orders.transaction_id' => $txn])->all()->toArray();

                    $reviewsTable = TableRegistry::get('Reviews');
                    $review = $reviewsTable->newEntity();
                    $review->rate = $this->request->data['rate'];
                    $review->trans_id = $this->request->data['trans_id'];
                    $review->user_id = $this->request->data['fromid'];
                    $review->txn_id = $this->request->data['txnid'];
                    $review->medicines = $this->request->data['medicines'];
                    $review->review = $this->request->data['review'];
                    $review->date = gmdate('Y-m-d H:i:s');
                    $review->is_active = 1;
                    if ($reviewsTable->save($review)) {
                        $id = $review->id;
                    }
                    $ordTable = TableRegistry::get('Orders');
                    $query = $ordTable->query();
                    $query->update()->set(['is_review' => 1])->where(['transaction_id' => $txn])->execute();

                    $transTable = TableRegistry::get('Transactions');
                    $query1 = $transTable->query();
                    $query1->update()->set(['is_review' => 1])->where(['transaction_id' => $txn])->execute();

                    $this->Flash->success(__('Review Saved Successfully.'));
                }
                else
                {
                    $this->Flash->error(__('Please enter your rating.'));
                }
            }

        }

        //$this->request->session()->read('Auth.User.id');

        $reviews = $this->Reviews->find()->where(['Reviews.txn_id' => $txn])->first();
        if(!empty($reviews)){ $review = $reviews->toArray(); } else { $review = array(); }
        //pr($review);
        //pr($orderExist); exit;


        $this->set(compact('orderExist', 'user', 'presc','transaction','review','revMedicine'));
        $this->set('_serialize', ['user']);
    }

    // Users Messages section
    public function mymessage() {
        $this->loadModel('Ordermsgs');
        $this->loadModel('Users');
        $this->loadModel('Orders');
        $uid = $this->request->session()->read('Auth.User.id');
        $user = $this->Users->get($this->request->session()->read('Auth.User.id'));
        $query1 = $this->Ordermsgs->find()->contain(['Users'])->where(['fromid' => $user->id, 'type' => 'p'])->orWhere(['toid' => $user->id, 'type' => 'p'])->all()->toArray();
        //pr($query1); exit;
        if (!empty($query1)) {
            $msgList = array();
            foreach ($query1 as $q) {
                $msgList[$q->ordid] = $q;
            }
        } else {
            $msgList = array();
        }

        $user = $this->Users->get($this->request->session()->read('Auth.User.id'));

        $this->set(compact('msgList', 'user'));
        $this->set('_serialize', ['msgList', 'user']);
    }

    // Users Message details page
    public function msgdetail($txn = null) {
        $this->loadModel('Users');
        $user = $this->Users->get($this->request->session()->read('Auth.User.id'));
        //pr($user); exit;
        $this->loadModel('Ordermsgs');
        $this->loadModel('Orders');
        $uid = $this->request->session()->read('Auth.User.id');
        $msg = $this->Ordermsgs->find()->contain(['Users'])->where(['fromid' => $user->id, 'type' => 'p', 'ordid' => $txn])->orWhere(['toid' => $user->id, 'type' => 'p', 'ordid' => $txn])->order(['date' => 'DESC'])->all()->toArray();

        //pr($msg); exit;

        $this->loadModel('Orders');
        $orderExist = $this->Orders->find()->where(['Orders.transaction_id' => $txn])->all()->toArray();

        if ($this->request->is('post')) {
            if ($this->request->data['ftype'] == 'msg') {
                $this->loadModel('Ordermsgs');
                $ordermsgsTable = TableRegistry::get('Ordermsgs');
                $ordermsg = $ordermsgsTable->newEntity();
                $ordermsg->ordid = $this->request->data['transid'];
                $ordermsg->fromid = $this->request->data['fromid'];
                $ordermsg->toid = $this->request->data['toid'];
                $ordermsg->msg = $this->request->data['msg'];
                $ordermsg->pid = $this->request->data['pid'];
                $ordermsg->type = $this->request->data['type'];
                $ordermsg->fromtype = $this->request->data['fromtype'];
                $ordermsg->totype = $this->request->data['totype'];
                $ordermsg->date = gmdate('Y-m-d H:i:s');
                if ($ordermsgsTable->save($ordermsg)) {
                    $id = $ordermsg->id;
                }
                $this->Flash->success(__('Message Sent To Customer Care Successfully.'));
                $this->redirect(['controller' => 'Users', 'action' => 'msgdetail', $txn]);
            }
        }

        $this->set(compact('user', 'msg', 'orderExist'));
        $this->set('_serialize', ['user']);
    }

   

    // Order checkout page.
    public function cartcheckout($id = null) {

        $this->viewBuilder()->layout('');
        //echo "ok"; exit;

        $this->loadModel('Orders');
        $this->loadModel('Orderdetails');

        $site = $this->site_setting();

        //pr($site);

        $curIp = $_SERVER['REMOTE_ADDR'];
        $orderExist = $this->Orders->find()->where(['Orders.client_ip' => $curIp, 'Orders.is_login' => 0, 'Orders.is_complete' => 0])->all()->toArray();
        $user = $this->Users->get($this->Auth->user('id'));
        foreach ($orderExist as $ordupdt) {
            $order = TableRegistry::get('Orders');
            $query = $order->query();
            $query->update()->set(['is_login' => 1, 'user_id' => $user->id, 'name' => $user->first_name . " " . $user->last_name, 'email' => $user->email, 'contact' => $user->phone, 'prescription_fee' => $site['prescfee'], 'billing_address' => $user->address])->where(['id' => 22])->execute();
        }

        $this->redirect(['controller' => 'Users', 'action' => 'checkout']);


        $this->autoRender = false;
    }

    // Checkout Payment Page
    public function checkout($delCh = null) {
        $this->viewBuilder()->layout('default');

        $this->loadModel('Treatments');
        $this->loadModel('Orders');
        $this->loadModel('Orderdetails');
        $this->loadModel('Medicines');
        $this->loadModel('Pils');

        $is_login = '';
        if ($this->request->session()->check('Auth.User')) {
            $is_login = 1;
            $uid = $this->request->session()->read('Auth.User.id');
            //$orderExist = $this->Orders->find()->contain(['Treatments','Orderdetails','Orderdetails.Medicines'])->where(['Orders.user_id' => $uid,'Orders.is_complete' => 0])->all();
            $orderExist = $this->Orders->find()->contain(['Orderdetails'])->where(['Orders.user_id' => $uid, 'Orders.is_complete' => 0])->all();
            //$orderExist = $this->Orders->find()->where(['Orders.user_id' => $uid,'Orders.is_complete' => 0])->all();
            $cartData = $orderExist->toArray();
        } else {
            $cartData = array();
        }



        if (empty($cartData)) {
            $this->Flash->error('Your Cart is empty.');//Checking cart is empty or not
            return $this->redirect('/');
        } else {
            $cData = array();
            if ($delCh == 1) {
                $deliveryCharge = 2.92;
            } else if ($delCh == 2) {
                $deliveryCharge = 5.93;
            } else if ($delCh == 3) {
                $deliveryCharge = 32.45;
            } else {
                $deliveryCharge = 0;
            }
            $cartAmount = 0;
            $prescriptionFee = 0;
            foreach ($cartData as $crt) {
                $prescriptionFee = $crt->prescription_fee;
                $cData[] = $crt->id;
                foreach ($crt->orderdetails as $cDataArr) {
                    $cartAmount = $cartAmount + $cDataArr->pil_price;
                }
            }
        }

        if ($this->request->is('post')) {

            //  4242424242424242
            //  12 / 2017
            //  111

            $amount = $deliveryCharge + $prescriptionFee + $cartAmount;
            $currencyCode = 'GBP';
            $paymentAction = 'Sale';
            $methodToCall = 'doDirectPayment';
            $nvpRecurring = '';
            $creditCardType = $this->request->data['card'];
            $creditCardNumber = $this->request->data['card_number'];
            $expDateMonth = $this->request->data['expiry_month'];
            $expDateYear = $this->request->data['expiry_year'];
            $cvv2Number = $this->request->data['cvv'];
            $firstName = $this->request->data['firstname'];
            $lastName = $this->request->data['lastname'];
            $city = $this->request->data['ship_city'];
            $state = "Westbengal";
            $zip = $this->request->data['ship_postcode'];

            $request_params = array(
                'METHOD' => 'DoDirectPayment',
                'USER' => 'nits.arpita_api1.gmail.com',
                'PWD' => '1383658129',
                'SIGNATURE' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AKsVq2ka8e2MK-zCBP3Um9xHlsFO',
                'VERSION' => '85.0',
                //'PAYMENTACTION'     => 'Authorization',
                'PAYMENTACTION' => 'Sale',
                'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
                'CREDITCARDTYPE' => $creditCardType,
                'ACCT' => $creditCardNumber,
                'EXPDATE' => $expDateMonth . $expDateYear,
                'CVV2' => $cvv2Number,
                'FIRSTNAME' => $firstName,
                'LASTNAME' => $lastName,
                'AMT' => $amount,
                'CURRENCYCODE' => 'GBP',
                'DESC' => 'Testing Payments Pro'
            );

            $nvp_string = '';
            foreach ($request_params as $var => $val) {
                $nvp_string .= '&' . $var . '=' . urlencode($val);
            }
            // Submit card details with amount to paypal for payment
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_VERBOSE, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_TIMEOUT, 3000);
            curl_setopt($curl, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

            $result = curl_exec($curl);
            curl_close($curl);
            //var_dump($result);
            //$resArray = $this->NVPToArray($result);

            parse_str($result, $resArray);


            if (!empty($resArray)) {
                if ($resArray["ACK"] == 'SUCCESS' || $resArray["ACK"] == 'Success') {

                    $ack = strtoupper($resArray["ACK"]);
                    $txn_id = $resArray["TRANSACTIONID"];
                    $chkPost = $this->generateRandomString();
                    $curIp = $_SERVER['REMOTE_ADDR'];

                    $transactionTable = TableRegistry::get('Transactions');
                    $transaction = $transactionTable->newEntity();
                    $transaction->client_ip = $curIp;
                    $transaction->user_id = $cartData[0]->user_id;
                    $transaction->prescription_fee = $cartData[0]->prescription_fee;
                    $transaction->amt = $amount;
                    $transaction->shipping_address = $this->request->data['ship_address'];
                    $transaction->shipping_city = $this->request->data['ship_city'];
                    $transaction->shipping_code = $this->request->data['ship_postcode'];
                    $transaction->shipping_country = $this->request->data['ship_country'];
                    $transaction->date = gmdate("Y-m-d h:i:s");
                    $transaction->transaction_id = $txn_id;

                    if ($transactionTable->save($transaction)) {
                        $transactionid = $transaction->id;
                    }

                    foreach ($cData as $k => $v) {
                        $tableRegObj = TableRegistry::get('Orders');
                        $query = $tableRegObj->query();
                        $query->update()->set(['transactionid' => $transactionid, 'transaction_id' => $txn_id, 'is_complete' => 1, 'is_cart' => 0, 'amt' => $amount, 'shipping_address' => $this->request->data['ship_address'], 'shipping_city' => $this->request->data['ship_city'], 'shipping_code' => $this->request->data['ship_postcode'], 'shipping_country' => $this->request->data['ship_country']])->where(['id' => $v])->execute();
                    }

                    // Sending Payment Success Mail with order details
                    $tableRegObj1 = TableRegistry::get('Users');
                    $user = $tableRegObj1->find()->where(['id' => $this->Auth->User('id')])->first()->toArray();
                    $this->loadModel('EmailTemplates');
                    $etRegObje = TableRegistry::get('EmailTemplates');
                    $emailTemp = $etRegObje->find()->where(['id' => 3])->first()->toArray();
                    $fullname = $user['first_name'] . " " . $user['last_name'];
                    $mail_To = $user['email'];
                    //$mail_CC = '';
                    $mail_subject = $emailTemp['subject'];
                    $url = Router::url('/', true);
                    $link = $url . 'users/signin';
                    $mail_body = str_replace(array('[NAME]', '[TRID]', '[LINK]'), array($fullname, $txn_id, $link), $emailTemp['content']);
                    $email = new Email('default');
                    $email->emailFormat('html')->from(['noreply@medicinesbymailbox.co.uk' => 'Medicines By Mailbox'])
                            ->to($mail_To)
                            ->subject($mail_subject)
                            ->send($mail_body);

                    $this->Flash->success(__('Your Order completed successfully.'));
                    $this->redirect(['controller' => 'Users', 'action' => 'dashboard', $txn_id]);
                } else {
                    //pr($cData); pr($this->request->data); pr($resArray); exit;
                    $this->Flash->success(__('Your Order not proccessed. Try again.'));
                    //$this->redirect(['controller' => 'Treatments', 'action' => 'cart']);
                }
            } else {
                $this->Flash->success(__('Your Card Detail Not Valid. Try again.'));
            }
        }


        $user = $this->Users->get($this->request->session()->read('Auth.User.id'))->toArray();


        $this->set(compact('orderExist', 'cartData', 'is_login','user'));
        $this->set('_serialize', ['cartData']);
    }
    public function changepass(){
       $user = $this->Users->get($this->Auth->user('id'));
          
       
         if ($this->request->is(['post', 'put'])) {
          
         // $new_pass = $this->request->data['password'];
          $confirm_pass = $this->request->data['confirm_password'];
          $user = $this->Users->patchEntity($user, $this->request->data);
          $this->Users->save($user);
          $this->Flash->success(__('Password has been Changed successfully.'));
          return $this->redirect(['action' => 'index']);
 }
 $this->set(compact('user'));
   $this->set('_serialize', ['user']);
      
}
public function exportUsers()
        {

            $uid = $this->Auth->user('id');
            //$events = $this->User->find('all',array('conditions' => array('User.is_paid' => 1)));
            $this->loadModel('Landlords');
             $this->loadModel('Properties');
            $events = $this->Landlords->find()->where(['user_id' => $uid])->toArray();
            

            //print_r($events);
            //$this->layout = false;
            $output='';
            $output .='Id,Property,Company, Email,FirstName,LastName,Phone,Address, BankDetails';
            $output .="\n";

            if(!empty($events))
            {
                //print_r($events);die;
                foreach($events as $event)
                {   
                    $id = $event->id;
                    $property_id = $event->property_id;
                    //echo$id; die;
                    $company_name = $event->company_name;
                     $address = $event['address'];
                     //print_r($address);die;
                    $bank_details = $event['bank_details'];
                    $email = $event['email'];
                    $first_name=$event['first_name'];
                    $last_name=$event['last_name'];
                    $phone=$event['phone'];
                    $add_date=$event['add_date'];
                    $props=$this->Properties->find("all")->where(["is_active"=>1,'id'=>$property_id])->toArray();
        foreach ($props as $prop)
        {
           $properties = $prop->address;
        }
                    
                    $output .='"'.$id.'","'.$properties.'","'.$company_name.'","'.$email.'","'.$first_name.'","'.$last_name.'","'.$phone.'","'.$address.'","'.$bank_details.'"';
                    $output .="\n";
                }
            }


            $filename = "myFile".time().".csv";
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename='.$filename);
            echo $output;
            exit;

            
        }
        //export certificate
        public function exportCertificate(){
              $uid = $this->Auth->user('id');
              $this->loadModel('Certificate');
          $events = $this->Certificate->find()->where(['user_id' => $uid])->toArray();
             $output='';
             $output .='Id,Title,CertificateNo,IssueDate,ExpriDate';
             $output .="\n";
             if(!empty($events))
            {
                //print_r($events);die;
                foreach($events as $event)
                {   
                    $id = $event->id;
                    
                    //echo$id; die;
                    $title = $event['title'];
                     //print_r($address);die;
                    $certificate_no = $event['certificate_no'];
                       $issue_date=$event['issue_date'];
                    $expire_date=$event['expire_date'];
                     $output .='"'.$id.'","'.$title.'","'.$certificate_no.'","'.$issue_date.'","'.$expire_date.'"';
                    $output .="\n";
                }
            }


            $filename = "myFile".time().".csv";
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename='.$filename);
            echo $output;
            exit;
         }

////add certficate
 public function certificates(){
   $this->loadModel('Certificate');
   $this->loadModel("Properties"); 
     $uid = $this->Auth->user('id');
     //echo $uid; die;
        $conditions["Certificate.user_id"]=$uid;
      // print_r($conditions); die;
       
        if ($this->request->is('get')) 
      {
        //echo $this->request->is('get');die;
      
           
           $filter=array("page");
           //print_r($filter); die;
            foreach ($this->request->query as $key =>$val)
           {
               if(!in_array($key, $filter))
                {
                     if(!empty($val))
                    {
                          if($key=="property_id"|| $key=="certificate_no")
                         {
                            $conditions["Certificate.".$key]=$val; 
                     }

                         else
                  {
                            $conditions["Certificate.".$key." LIKE "]='%'.$val.'%'; 
                            //print_r($conditions); die;

                         }
                    }
                    $this->request->data[$key]=$val;
               }
               
               
          }
        // print_r($conditions); die;
           
        }
        $options=[
        "limit"=>10,
      // "contain"=>"Properties",
        "order" => [
             'Certificate.id' => 'desc'
         ],    
       "conditions"=>$conditions    
       ];
      // print_r($options);die;
       $result = $this->paginate($this->Certificate,$options);
       // print_r($Certi);die;
 // $result =  $this->Certificate->find('all', 
 //        array(
            
 //            'order' => 'Certificate.id DESC',
            
 //       )
 //   );
 // $title = 'Certificate';
  // echo "hello"; die;
 // $result = $this->Certificate->find()->all();
 //echo "<pre>"; print_r($result); die; 
     $this->set(compact('result','Certi'));
   $this->set('_serialize', ['result']); 
 }
 public function addcretificate(){

    //add certificate to be modify from sidemanegment
   $this->loadModel("Properties");
     $this->loadModel('certificate');
     $uid = $this->Auth->user('id');
     //echo "<pre>"; print_r($uid);die;
      $addcertificate = $this->certificate->newEntity();
      if ($this->request->is('post')) {
       // echo "test"; die;
        // Modify from Here surbhi

            $tableRegObj = TableRegistry::get('certificate');
            $certificateExiist = $tableRegObj->find()->where(['title' => $this->request->data['title']])->toArray();
            $flag = true;
            //pr($mediciineExiist);
            //pr($this->request->data); exit;
            // Medicine Form validation
            if ($this->request->data['title'] == "") {
                $this->Flash->error(__('Title can not be null. Please, try again.'));
            }
            
        }
        $this->request->data["user_id"]=$uid;
         
      // if($flag){
      //           $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
      //           if (!empty($this->request->data['image']['name'])) {
      //               $file = $this->request->data['image']; //put the data into a var for easy use
      //               $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
      //               $fileName = time() . "." . $ext;
      //               if (in_array($ext, $arr_ext)) {
      //                   move_uploaded_file($file['tmp_name'], WWW_ROOT . 'certificate_img' . DS . $fileName);
      //                   $file = $fileName;
      //               } else {
      //                   $flag = false;
      //                   $this->Flash->error(__('Upload image only jpg,jpeg,png files.'));
      //               }
      //           } else {
      //               $flag = false;
      //               $this->Flash->error(__('Upload Certificate.'));
      //           }
      //       }

            if($flag){
                //$this->request->data['image'] = $file;
               //print_r ($this->request->data);die;
               $certificate_img = $this->Users->patchEntity($addcertificate, $this->request->data);
                if ($this->certificate->save($addcertificate)) {
                    $this->Flash->success(__('certificate has been saved.'));
                    return $this->redirect(['action' => 'certificates']);
                } else {
                    $this->Flash->error(__('certificate could not be saved. Please, try again.'));
                }
            }
            $props=$this->Properties->find("all")->where(["is_active"=>1,'user_id'=>$uid])->toArray();
        foreach ($props as $prop)
        {
           $properties[$prop->id]= $prop->address;
        }
        
          $this->set(compact('addcertificate','properties'));
           $this->set('_serialize', ['addcertificate','properties']);      
            }  

    public function delete($id){
                 $this->loadModel('Certificate');
        $result = $this->Certificate->get($id);
       // print_r($result);die;
        if ($this->Certificate->delete($result)) {
            $this->Flash->success(__('Certificate has been deleted.'));
        } else {
            $this->Flash->error(__('Certificate not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'certificates']);
    }
    public function edit($id) {

       // $this->viewBuilder()->layout('admin');
         $this->loadModel("Properties");
      $this->loadModel('Certificate');
      $uid = $this->Auth->user('id');
       $result = $this->Certificate->get(base64_decode($id));
       //print_r($result);die;
        $result->issue_date = date("Y-m-d", strtotime($result->issue_date));
        $result->expire_date = date("Y-m-d", strtotime($result->expire_date));

       $id= base64_decode($id);
        $this->request->data["user_id"]=$uid;
        $props=$this->Properties->find("all")->where(["is_active"=>1,'user_id'=>$uid])->toArray();
        foreach ($props as $prop)
        {
           $properties[$prop->id]= $prop->title;
        }
            
      // print_r($id);die;
     // $flag=false;
        if ($this->request->is(['patch', 'post', 'put'])) {



           // pr($this->request->data); exit;
            // $this->loadModel('SideBar');
             $tableRegObj = TableRegistry::get('Certificate');
             $slugExist = $tableRegObj
                            ->find()
                            ->where(['title' => $this->request->data['title'],'id !='=> $id])->toArray();
                           // print_r($slugExist);

          // $this->request->data; die;

            //pr($getAllResults); exit;
            //pr($this->request->data); exit;
                           // $issue_date = date("Y-m-d", strtotime($this->request->data));
                            
                            //print_r($issue_date); die;

            $flag = true;

            if($this->request->data['title'] == ""){
                $this->Flash->error(__('Title can not be null. Please, try again.')); $flag = false;
            }
            $this->request->data['issue_date'] = date("Y-m-d", strtotime($this->request->data['issue_date']));
            $this->request->data['expire_date'] = date("Y-m-d", strtotime($this->request->data['expire_date']));    
             }
             

             
           // if($flag){
                // $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
                // if (!empty($this->request->data['image'])) {
                //     $file = $this->request->data['image']; //put the data into a var for easy use
                //     $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension

                //     if($result->image != "") { $fileName = $result->image; } else { $fileName = time() . "." . $ext; }

                //     if (in_array($ext, $arr_ext)) {
                //         move_uploaded_file($file['tmp_name'], WWW_ROOT . 'certificate_img' . DS . $fileName);
                //         $this->request->data['image'] = $fileName;
                //     }
                // } else {
                //     $this->request->data['image'] = $result->image;
                // }
                 
  $flag="";
 if($flag){

              // print_r($this->request->data); die;
                $certificate = $this->Certificate->patchEntity($result, $this->request->data);
               //print_r($certificate); die;
                if ($this->Certificate->save($certificate)) {
                    $this->Flash->success(__('Certificate detail has been updated.'));
                    // return $this->redirect(['action' => 'certificate']);
                } else {
                    $this->Flash->error(__('certificate detail could not be update. Please, try again.'));
                }
            }
      //  }


        $this->set(compact('result','properties'));
        $this->set('_serialize', ['result','properties']);
    }

          // Adding Prescription for Users
    public function addprescription($txn = null) {
        //echo $txn; exit;
        $this->loadModel('Orders');
        $this->loadModel('Prescriptions');


        $prescription = $this->Prescriptions->newEntity();


        if ($this->request->is('post')) {

            //pr($this->request->data); exit;

            $flag = true;

            if ($flag) {
                $this->request->data['type'] = $this->request->data['file']['type'];
                $arr_ext = array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'doc', 'docs');
                if (!empty($this->request->data['file']['name'])) {
                    $file = $this->request->data['file']; //put the data into a var for easy use
                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                    $fileName = time() . "." . $ext;
                    if (in_array($ext, $arr_ext)) {
                        move_uploaded_file($file['tmp_name'], WWW_ROOT . 'prescription' . DS . $fileName);
                        $filedt = $fileName;
                    } else {
                        $flag = false;
                        $this->Flash->error(__('Upload only jpg,jpeg,png,pdf,doc,docs files.'));
                    }
                } else {
                    $flag = false;
                    $this->Flash->error(__('Prescribtion not Uploaded. Try again.'));
                }
            }

            if ($flag) {
                $this->request->data['txnid'] = $txn;
                $this->request->data['file'] = $filedt;

                $prescription = $this->Prescriptions->patchEntity($prescription, $this->request->data);

                if ($this->Prescriptions->save($prescription)) {
                    $this->Flash->success(__('Prescription has been saved.'));
                    return $this->redirect(['action' => 'dashboard']);
                } else {
                    $this->Flash->error(__('Prescription could not be saved. Please, try again.'));
                }
            }
        }

        $this->set(compact('prescription'));
        $this->set('_serialize', ['prescription']);
    }
   


    // Cancel oreder and Refund
    public function refundextra($txn_id = null) {


        $request_params = array(
            'METHOD' => 'RefundTransaction',
            'TRANSACTIONID' => $txn_id,
            'REFUNDTYPE' => 'Full',
            'USER' => 'nits.debsoumen2_api1.gmail.com',
            'PWD' => 'LJMGQ33VJGFUZGXQ',
            'SIGNATURE' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AjUTZMwQl04R5EwZTojhK76GG1wR',
            'VERSION' => '85.0',
            'CURRENCYCODE' => 'GBP',
        );

        $nvp_string = '';
        foreach ($request_params as $var => $val) {
            $nvp_string .= '&' . $var . '=' . urlencode($val);
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

        $result = curl_exec($curl);
        curl_close($curl);
        //var_dump($result);
        //$resArray = $this->NVPToArray($result);

        parse_str($result, $resArray);


        //$resArray = $this->PPHttpPost($methodToCall, $nvpstr, 'on', $API_UserName, $API_Password, $API_Signature);
        //end PennyAuctionSoft add
        //$nvpstr = "&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=" . $padDateMonth . $expDateYear . "&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state" . "&ZIP=$zip&COUNTRYCODE=TH&CURRENCYCODE=$currencyCode";
        //echo phpinfo();
        //pr($request_params);
        //pr($this->request->data); pr($resArray); exit;
        echo "<pre>";
        print_r($resArray);
        exit;
    }

    // Oreder canceletion by doctor.
    public function cancelnow($txnId = null) {
        $this->viewBuilder()->layout('');

        $this->loadModel('Treatments');
        $this->loadModel('Orders');
        $this->loadModel('Orderdetails');
        $this->loadModel('Medicines');
        $this->loadModel('Pils');
        $this->loadModel('Transactions');

        $is_login = '';
        if ($this->request->session()->check('Auth.User')) {
            $is_login = 1;
            $uid = $this->request->session()->read('Auth.User.id');
            $orderExist = $this->Orders->find()->where(['Orders.user_id' => $uid, 'Orders.transaction_id' => $txnId])->all()->toArray();
        }

        if($txnId != ""){

            $transaction = $this->Transactions->find()->contain(['Orders','Users'])->where(['Transactions.transaction_id' => $txnId])->first()->toArray();

            $request_params = array(
                'METHOD' => 'RefundTransaction',
                'TRANSACTIONID' => $txnId,
                'REFUNDTYPE' => 'Full',
                'USER' => 'nits.debsoumen2_api1.gmail.com',
                'PWD' => 'LJMGQ33VJGFUZGXQ',
                'SIGNATURE' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31AjUTZMwQl04R5EwZTojhK76GG1wR',
                'VERSION' => '85.0',
                'CURRENCYCODE' => 'GBP',
            );

            $nvp_string = '';
            foreach ($request_params as $var => $val) {
                $nvp_string .= '&' . $var . '=' . urlencode($val);
            }

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_VERBOSE, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_TIMEOUT, 3000);
            curl_setopt($curl, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

            $result = curl_exec($curl);
            curl_close($curl);
            parse_str($result, $resArray);
            if($resArray['ACK'] == 'Success' ){
                $retTransactionId = $resArray['REFUNDTRANSACTIONID'];
                $refAmt = $resArray['NETREFUNDAMT'];
                $record_id = $transaction['id'];
                $trans['is_reject'] = 1;
                $trans['reject_by'] = "Patient";
                $trans['reject_by_id'] = $this->request->session()->read('Auth.User.id');
                $trans['is_refunded'] = 1;
                $trans['refund_amt'] = $refAmt;
                $trans['refund_transaction_id'] = $retTransactionId;
                //$trans['reasion'] = $this->request->data['data'];

                $transactionTable = TableRegistry::get('Transactions');
                $query1 = $transactionTable->query();
                $query1->update()->set($trans)->where(['id' => $record_id])->execute();

                foreach($transaction['Orders'] as $cancelOrder){
                    $record_ids = $cancelOrder['id'];
                    $order['is_reject'] = 1;
                    $order['reject_by'] = "Patient";
                    $order['reject_by_id'] = $this->request->session()->read('Auth.User.id');
                    $order['is_refunded'] = 1;
                    $order['refund_amt'] = $refAmt;
                    $order['refund_transaction_id'] = $retTransactionId;
                    //$order['reasion'] = $this->request->data['data'];
                    $ordersTable = TableRegistry::get('Orders');
                    $query = $ordersTable->query();
                    $query->update()->set($order)->where(['id' => $record_ids])->execute();
                }
                $this->Flash->success(__('You have cancel order Successfully.'));
                $this->redirect(['controller'=>'Users' ,'action' => 'prescriptiondetail', $txnId]);
            } else {
                $this->Flash->success(__('Your cancel order Not done Try again.'));
                $this->redirect(['controller'=>'Users' ,'action' => 'prescriptiondetail', $txnId]);
            }

        } else {
            $this->Flash->success(__('Your cancel order Not done Try again.'));
            $this->redirect(['controller'=>'Users' ,'action' => 'prescriptiondetail', $txnId]);
        }

    }
    
    
    
    

}
