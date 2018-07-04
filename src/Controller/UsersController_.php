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
use Cake\Auth\DefaultPasswordHasher;

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

    public $paginate = ['limit' => 2];

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['signup', 'signin', 'forgotpassword', 'setpassword', 'activeaccount', 'paynow', 'index', 'searchlist', 'servicedetails', 'ajaxaddtofavourite', 'fblogin', 'uploadphoto_add', 'toptenlist', 'jimjafav', 'googlelogin', 'fetchservice', 'services', 'reviews', 'contactus', 'subscribe', 'servicesearch','forgotpassword']);
        $this->loadComponent('Paginator');
    }

    public $uses = array('User', 'Admin');

    //Menu pages start  



    public function index() {
        $session = $this->request->session();

        $this->loadModel('Users');
        $this->loadModel('Makes');
        $this->loadModel('Bikemodels');
        $this->loadModel('Categories');
        $this->loadModel('Site_settings');

        $makes = $this->Makes->find()->where(['status' => 1])->toArray();
        $models = $this->Bikemodels->find()->where(['status' => 1])->toArray();
        $categories = $this->Categories->find()->toArray();

        $site_settings = $this->paginate($this->Site_settings);

        // echo "<pre>";
        // print_r($site_settings);die;

        foreach ($site_settings as $site_settings_val) {
            $session->write('twitter',$site_settings_val->twitter_url);
            $session->write('instagram',$site_settings_val->instagram_url);
            $session->write('facebook',$site_settings_val->facebook_url);
            $session->write('gplus',$site_settings_val->gplus_url);
            $session->write('pinterest',$site_settings_val->pinterest_url);
        }

        $this->set(compact('makes', 'models', 'categories'));
    }

    function subscribe() {

        $this->viewBuilder()->layout(false);
        $this->loadModel('EmailSubscribers');

        $email = $_REQUEST['email'];

        $subscribers = $this->EmailSubscribers->newEntity();

        if ($this->request->is('post')) {

            $this->request->data['email_id'] = $email;
            $this->request->data['date'] = gmdate('Y-m-d H:i:s');

            $subscribersExist = $this->EmailSubscribers->find()->where(['email_id' => $email])->toArray();
            if (!empty($subscribersExist)) {

                $Msg = array('Ack' => 0, 'data' => 'Already Subscribed.');
            } else {

                $subscribers = $this->EmailSubscribers->patchEntity($subscribers, $this->request->data);

                if ($this->EmailSubscribers->save($subscribers)) {

                    $mail_body = "You are subscribed to our newsletter.";
                    $mail_To = $email;
                    $mail_subject = "Biketory Newsletter Subscription";
                    $headers = "From: admin@biketory.com". "\r\n";
                    $mail_val = mail($to,$subject,$message,$headers);

                    $email = new Email('default');
                    $email->emailFormat('html')->from(['nits.spandan@gmail.com' => 'Biketory'])
                            ->to($mail_To)
                            ->subject($mail_subject)
                            ->send($mail_body);


                    $Msg = array('Ack' => 1, 'data' => 'Successfully Subscribed.');
                }
            }
        }


        echo json_encode($Msg);
        exit();
    }
    
    public function thumbimage(){
        $this->viewBuilder()->layout('false');
        $this->loadModel('Users');

        $data = $_POST['image'];
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);

        $data = base64_decode($data);
        $imageName = 'thumb_'.time().'.png';
        $filename = time().'.png';
        $upload_path = WWW_ROOT ."user_img/".$imageName;
        file_put_contents($upload_path, $data);

        $this->request->data['pimg'] = $filename;
        $user = $this->Users->get($this->Auth->user('id'));
        $user = $this->Users->patchEntity($user, $this->request->data);
        if ($this->Users->save($user)) {
          $data = array('Ack'=>1, 'image' => $filename);
        }
        else{
         $data = array('Ack'=>0); 
        }
        echo json_encode($data);
        die;
        
      }
    public function services() {

        $this->viewBuilder()->layout('default');
        $this->loadModel('ServiceProviderTypes');
        $this->loadModel('ServiceProviderImages');
        $this->loadModel('Services');
        $this->loadModel('Reviews');
        $conn = ConnectionManager::get('default');

        //$this->set('perpageservice', $this->Paginator->paginate($this->Services, [ 'limit' => 2, 'contain' => ['Users'=>['ServiceProviderImages']], 'conditions' => ['Services.is_active'=>1]])); 

        $allservice = $this->Services->find()->contain(['Users' => ['ServiceProviderImages']])->where(['Services.is_active' => 1])->order(['Services.id' => 'DESC'])->toArray();
        //pr($allservice);exit;

        foreach ($allservice as $dt) {

            $avg_rating = $conn->execute("SELECT avg(`rating`) as avr FROM `reviews` where is_active= 1 and service_id= '" . $dt['id'] . "' ")->fetchAll('assoc');
            $price_range = $conn->execute("SELECT min(min_price) as mp,max(max_price) as mxp FROM `service_provider_types` where service_id= '" . $dt['id'] . "' ")->fetchAll('assoc');

            $allservices[] = array('rating' => $avg_rating, 'price' => $price_range, 'details' => $dt);
        }

        //pr($allservices);exit;        
        //$this->set('allservices', $this->Paginator->paginate($allservices[]['details']));
        $this->set(compact('allservices'));
    }

    public function servicesearch() {

        $this->viewBuilder()->layout(false);
        //$this->layout = false;
        $this->loadModel('ServiceProviderTypes');
        $this->loadModel('ServiceTypes');
        $this->loadModel('Services');
        $this->loadModel('Reviews');
        $keyword = $_REQUEST['keyword'];
        $vtype1 = 0;
        $vtype1 = $_REQUEST['vtype'];

        $this->request->session()->write('vtype', $vtype1);
        $vtype = $this->request->session()->read('vtype');


        //echo $vtype;exit;
        $conn = ConnectionManager::get('default');



        $allservice = $this->Services->find()->contain(['Users' => ['ServiceProviderImages'], 'ServiceProviderTypes' => ['ServiceTypes']])->where(['Services.is_active' => 1, 'Services.service_name like' => '%' . $keyword . '%'])->orWhere(['Services.description like' => '%' . $keyword . '%'])->order(['Services.id' => 'DESC'])->toArray();

//       $allservice= $conn->execute("SELECT * FROM `services` as s left join users as u on u.id=s.provider_id left join servive_provider_images as spi on u.id=spi.serviceprovider_id left join service_provider_types as spt on spt.service_id=s.id left join service_types as st on st.id=spt.type_id  where s.is_active= 1 and s.service_name like '%'.$keyword.'%' or s.description like '%'.$keyword.'%' or st.type_name like '%'.$keyword.'%'  ")->fetchAll('assoc');
//       
        //pr($allservice);exit;

        foreach ($allservice as $dt) {

            $avg_rating = $conn->execute("SELECT avg(`rating`) as avr FROM `reviews` where is_active= 1 and service_id= '" . $dt['id'] . "' ")->fetchAll('assoc');
            $price_range = $conn->execute("SELECT min(min_price) as mp,max(max_price) as mxp FROM `service_provider_types` where service_id= '" . $dt['id'] . "' ")->fetchAll('assoc');

            $allservices[] = array('rating' => $avg_rating, 'price' => $price_range, 'details' => $dt);
        }

        //pr($allservices); exit;      
        //$this->set('allservices', $this->Paginator->paginate($allservices));
        $this->set(compact('allservices', 'vtype'));
        //exit();
    }

    public function reviews() {

        $this->viewBuilder()->layout('default');

        $this->loadModel('Reviews');

        $this->set('allreview', $this->Paginator->paginate($this->Reviews, [ 'limit' => 12, 'contain' => ['Users'], 'conditions' => ['Reviews.is_active' => 1]]));

        $this->set(compact('allreview'));
    }

    public function contactus() {

        $this->loadModel('EmailTemplates');
        $this->loadModel('SiteSettings');
        if ($this->request->is('post')) {
            $etRegObj = TableRegistry::get('EmailTemplates');
            $emailTemp = $etRegObj->find()->where(['id' => 3])->first()->toArray();
            $contactmail = $this->SiteSettings->find()->where(['id' => 1])->first();

            $name = $this->request->data['name'];
            $themail = $this->request->data['email'];
            $phone = $this->request->data['phone'];
            $title = $this->request->data['title'];
            $message = $this->request->data['message'];
            $mail_To = $contactmail['contact_email'];
            //$mail_CC = '';
            $mail_subject = $emailTemp['subject'];
            $url = Router::url('/', true);


            $mail_body = str_replace(array('[NAME]', '[EMAIL]', '[PHONE]', '[TITLE]', '[MESSAGE]'), array($name, $themail, $phone, $title, $message), $emailTemp['content']);
            //echo $mail_body; //exit;


            $email = new Email('default');
            $email->emailFormat('html')->from([$themail])
                    ->to($mail_To)
                    ->subject($mail_subject)
                    ->send($mail_body);

            $this->Flash->success(__('Your message sent successfully.'));
        }
    }

    //menu pages end


    public function fblogin() {

        //print_r($this->request->data);exit;
        $this->viewBuilder()->layout('false');
        $user = $this->Users->newEntity();
        //$fb_id=$this->Users->find("first",array('conditions'=>array('Users.facebook_id'=>$this->request->data['Users']['facebook_id'])));

        $flag = true;
        $tableRegObj = TableRegistry::get('Users');
        $userExist = $tableRegObj
                        ->find()
                        ->where(['facebook_id' => $this->request->data['data']['User']['facebook_id']])->toArray();
        //echo $this->request->data['data']['User']['facebook_id'];
        //print_r($userExist);exit;
        if (count($userExist) < 1) {

            // $email=$this->request->data['email'];
            // echo $email;exit;
            if (isset($this->request->data['data']['User']['email'])) {
                //$email=$this->Users->find("first",array('conditions'=>array('Users.email'=>$this->request->data['Users']['email'])));
                //echo "not exist";exit;

                $email = $tableRegObj
                                ->find()
                                ->where(['email' => $this->request->data['data']['User']['email']])->toArray();

                // print_r($email);exit;

                if (count($email) < 1) {

                    $this->request->data['data']['User']['password'] = 'jimja';
                    $user = $this->Users->patchEntity($user, $this->request->data['data']['User']);
                    $this->Users->save($user);
                    //   	$user=$this->Users->find("first",array('conditions'=>array('Users.email'=>$this->request->data['Users']['email'])));
                    // //log in the user with facebook credentials
                    // $this->Auth->login($user['User']);
                    //$this->Auth->login() ;
                    //$this->Users->save($this->request->data);
                    $this->request->data['email'] = $this->request->data['data']['User']['email'];
                    $this->request->data['password'] = 'jimja';
                    $user = $this->Auth->identify();
                    //$this->redirect(['controller' => 'Users','action'=>"dashboard"]);
                    $url = Router::url('/', true);
                    $data['status'] = 1;
                    $data['url'] = $url . 'users/dashboard';
                    //print_r($data);exit;
//                $this->Auth->setUser($user);
//         //print_r($user);exit;
// echo json_encode($data);exit;
                } else {
                    $data = '';
                }
            } else {
                //pr($this->request->data);exit;
                //echo "fghfgh";exit;
                $this->request->data['data']['User']['password'] = 'jimja';
                $user = $this->Users->patchEntity($user, $this->request->data['data']['User']);
                $this->Users->save($user);
                $this->request->data['email'] = $this->request->data['data']['User']['email'];
                $this->request->data['password'] = 'jimja';
                $user = $this->Auth->identify();
                //print_r($user);exit;
                if ($user) {
                    $this->Flash->success(__('You are Loged In Successfully.'));
                    $this->redirect(['controller' => 'Users', 'action' => "dashboard"]);
                    $url = Router::url('/', true);
                    $data['status'] = 1;
                    $data['url'] = $url . 'users/dashboard';
                } else {
                    $this->Flash->error('Your username or password is incorrect.');
                    return $this->redirect(['action' => 'home']);
                    $url = Router::url('/', true);
                    $data['status'] = 1;
                    $data['url'] = $url . 'users/home';
                }
            }
        } else {
            //print_r($userExist[0]->email);exit;
            //$this->Users->save($this->request->data);
            // echo $this->request->data['data']['User']['email'];
            $this->request->data = '';
            $this->request->data['email'] = $userExist[0]->email;
            $this->request->data['password'] = 'jimja'; // $userExist[0]->password;
            //print_r($this->request->data);exit;
            // $this->Auth->fields = array('username' => 'email', 'password' => 'password');
            //log in the user with facebook credentials
            //$user= $this->Auth->identify($userExist);
            $user = $this->Auth->identify();

            if ($user) {

                $this->Flash->success(__('You are Loged In Successfully.'));
                $rt = $this->redirect(['controller' => 'Users', 'action' => "dashboard"]);
                $url = Router::url('/', true);
                $data['status'] = 1;
                $data['url'] = $url . 'users/dashboard';
                //print_r($rt);exit;
                //print_r($user);exit;
            } else {
                $this->Flash->error('Your username or password is incorrect.');
                return $this->redirect(['action' => 'home']);
            }
        }
        $this->Auth->setUser($user);
        //print_r($user);exit;
        echo json_encode($data);
        exit;
    }

    public function googlelogin() {
        // print_r($this->request->data['data']['User']['email']);exit;
        $this->viewBuilder()->layout('false');
        $user = $this->Users->newEntity();
        //$fb_id=$this->Users->find("first",array('conditions'=>array('Users.facebook_id'=>$this->request->data['Users']['facebook_id'])));

        $flag = true;
        $tableRegObj = TableRegistry::get('Users');
        $userExist = $tableRegObj
                        ->find()
                        ->where(['google_id' => $this->request->data['data']['User']['google_id']])->toArray();

//print_r($userExist);exit;
        if (count($userExist) < 1) {
            //$email=$this->request->data('email_address');
            if (isset($this->request->data['User']['email_address'])) {
                $email = $tableRegObj
                                ->find()
                                ->where(['email' => $this->request->data['data']['User']['email']])->toArray();

                // print_r($email);exit;

                if (count($email) < 1) {

                    $this->request->data['data']['User']['password'] = 'carvis';
                    $user = $this->Users->patchEntity($user, $this->request->data['data']['User']);
                    $this->Users->save($user);
                    //      $user=$this->Users->find("first",array('conditions'=>array('Users.email'=>$this->request->data['Users']['email'])));
                    // //log in the user with facebook credentials
                    // $this->Auth->login($user['User']);
                    //$this->Auth->login() ;
                    //$this->Users->save($this->request->data);
                    $this->request->data['email'] = $this->request->data['data']['User']['email'];
                    $this->request->data['password'] = 'carvis';
                    $user = $this->Auth->identify();
                    //$this->redirect(['controller' => 'Users','action'=>"dashboard"]);
                    $url = Router::url('/', true);
                    $data['status'] = 1;
                    $data['url'] = $url . 'users/dashboard';
                    //print_r($data);exit;
//                $this->Auth->setUser($user);
//         //print_r($user);exit;
// echo json_encode($data);exit;
                } else {
                    $data = '';
                }
            } else {
                $this->request->data['data']['User']['password'] = 'carvis';
                $user = $this->Users->patchEntity($user, $this->request->data['data']['User']);
                $this->Users->save($user);
                //      $user=$this->Users->find("first",array('conditions'=>array('Users.email'=>$this->request->data['Users']['email'])));
                // //log in the user with facebook credentials
                // $this->Auth->login($user['User']);
                //$this->Auth->login() ;
                //$this->Users->save($this->request->data);
                $this->request->data['email'] = $this->request->data['data']['User']['email'];
                $this->request->data['password'] = 'carvis';
                $user = $this->Auth->identify();
                //$this->redirect(['controller' => 'Users','action'=>"dashboard"]);
                $url = Router::url('/', true);
                $data['status'] = 1;
                $data['url'] = $url . 'users/dashboard';
            }
        } else {
            $this->request->data['email'] = $this->request->data['data']['User']['email'];
            $this->request->data['password'] = 'carvis';
            //print_r($this->request->data);exit;
            $user = $this->Auth->identify();
            // print_r($user);
            //print_r($this->request->data['data']['User']['email']);
            //echo "here";exit;
            //$this->redirect(['controller' => 'Users','action'=>"dashboard"]);
            $url = Router::url('/', true);
            $data['status'] = 1;
            $data['url'] = $url . 'users/dashboard';
        }
        //print_r($user);exit;
        $this->Auth->setUser($user);
        echo json_encode($data);
        exit;
    }

    public function signup() {

        //$this->viewBuilder()->layout('default');

        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {

            // echo "<pre>";
            // print_r($this->request->data);
            // echo "</pre>";die;

            $flag = true;
            $tableRegObj = TableRegistry::get('Users');
            $userExist = $tableRegObj
                            ->find()
                            ->where(['email' => $this->request->data['email']])->toArray();

            // Users form validation

            if($this->request->data['utype'] == 1){
                if ($this->request->data['first_name'] == "") {
                $this->Flash->error(__('First name can not be empty. Please, try again.'));
                $flag = false;
                }
                if ($this->request->data['last_name'] == "") {
                    $this->Flash->error(__('Last name can not be empty. Please, try again.'));
                    $flag = false;
                }

                $first_name = trim($this->request->data['first_name']);
                $last_name = trim($this->request->data['last_name']);

                $this->request->data['first_name'] = $first_name;
                $this->request->data['last_name'] = $last_name;

                $this->request->data['business_name'] = "";
                $this->request->data['phone'] == "";
            }
            elseif($this->request->data['utype'] == 2){
                if ($this->request->data['business_name'] == "") {
                    $this->Flash->error(__('Business name can not be empty. Please, try again.'));
                    $flag = false;
                }
                if ($this->request->data['phone'] == "") {
                    $this->Flash->error(__('Phone number can not be empty. Please, try again.'));
                    $flag = false;
                }

                $business_name = trim($this->request->data['business_name']);
                $phone = trim($this->request->data['phone']);

                $this->request->data['business_name'] = $business_name;
                $this->request->data['phone'] = $phone;

                $this->request->data['first_name'] == "";
                $this->request->data['last_name'] == "";
            }

            
            if ($this->request->data['email'] == "") {
                $this->Flash->error(__('email can not be empty. Please, try again.'));
                $flag = false;
            }
            if ($this->request->data['password'] != $this->request->data['con_password']) {
                $this->Flash->error(__('Password and confirm password not matched. Please, try again.'));
                $flag = false;
            }

            $email = trim($this->request->data['email']);
            $this->request->data['email'] = $email;

            if ($flag) {
                if ($userExist) {
                    $flag = false;
                    $this->Flash->error(__('Email Already Registered, try with another.'));
                }
            }

            if ($flag) {
                if($this->request->data['utype'] == 1){
                    $fullname = trim($this->request->data['first_name']).' '.trim($this->request->data['last_name']);
                }
                elseif($this->request->data['utype'] == 2){
                    $fullname = trim($this->request->data['business_name']);

                }
                // Saving data after validating the form
                
                $themail = trim($this->request->data['email']);
                $this->request->data['utype'] = $this->request->data['utype'];
                //$this->request->data['address']= $this->request->data['address']; 
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
                    //echo $rs->id;exit;


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
                    $email->emailFormat('html')->from(['nits.spandan@gmail.com' => 'Biketory'])
                            ->to($mail_To)
                            ->subject($mail_subject)
                            ->send($mail_body);

                    $this->Flash->success(__('You are registered successfully. Please check you mail for verification link'));
                    return $this->redirect(['action' => 'signin']);
                }
            }
        }
        
        //$this->set(compact('user'));
        //$this->set('_serialize', ['user']);
    }

    public function activeaccount($idnew) {

        $this->viewBuilder()->layout('default');

        //if ($this->request->session()->check('Auth.User') == true) {
       


//        if ($this->request->session()->check('Auth.Doctor') == true) {
//            $this->redirect(['controller' => 'Doctors', 'action' => 'dashboard']);
//        }

        $idText = base64_decode($idnew);
        $idTextArr = explode("/", $idText);
        
        // echo "<pre>";
        // print_r($idTextArr);die;

        $tableRegObj = TableRegistry::get('Users');
        $userExist = $tableRegObj->find()->where(['email' => $idTextArr[1]])->first();

        // echo "<pre>";
        // print_r($userExist);
        //echo $idnew; pr($idTextArr); echo $idText; pr($userExist); exit;
        if ($userExist) {
            $subquestion = TableRegistry::get('Users');
            $query = $subquestion->query();
            $query->update()->set(['is_mail_verified' => 1, 'is_active' => 1])->where(['id' => $idTextArr[0]])->execute();
            $this->Flash->success(__('Your account verified successfully.Please Login Now!'));
            $this->redirect(['controller' => 'Users', 'action' => "signin"]);
        } else {
            $this->Flash->error(__('Your account not exist.'));
            $this->redirect(['controller' => 'Users', 'action' => "signin"]);
        }

       

        //$this->autoRender = false;
    }

    public function signin($val = null) {

        //$this->viewBuilder()->layout('default');
        if ($this->request->is('post')) {
            //print_r($this->request->data['password']);exit;
            $email = trim($this->request->data['email']);
            $this->request->data['email'] = $email;

            if($this->request->data['remember']){

               /* Set cookie to last 1 year */
                setcookie('email', $this->request->data['email'], time()+60*60*24*365, '/');
                setcookie('passwordone', $this->request->data['password'], time()+60*60*24*365, '/');
            
            }
            elseif(!$this->request->data['remember']){
                setcookie("email", '', 1, '/');
                setcookie("passwordone", '', 1, '/');
                // unset($_COOKIE['email']);
                // unset($_COOKIE['passwordone']);
                // setcookie("email", "", time()-3600);
                // setcookie("passwordone", "", time()-3600);
            }
            

            $user = $this->Auth->identify();

            //print_r($user);exit();

            if ($user) {
                if ($user['is_mail_verified'] == 1) {
                    if ($user['is_active'] == 1) {
                        $this->Auth->setUser($user);
                        if ($user['utype'] == 1) {

                            $SiteSettings = $this->site_setting();
                            $is_login = 0;


                            $this->Flash->success(__('You are Loged In Successfully.'));
                            $this->redirect(['controller' => 'Users', 'action' => "dashboard"]);
                        } else if ($user['utype'] == 2) {

                            $this->Flash->success(__('You are Loged In Successfully.'));
                            $this->redirect(['controller' => 'Users', 'action' => "sellerdashboard"]);
                        }
                    } else {
                        $this->Flash->error('Your Account Not activated.');
                        return $this->redirect(['action' => 'signin']);
                    }
                } else {
                    $this->Flash->error('Your Email Id Not verified.');
                    return $this->redirect(['action' => 'signin']);
                }
            } else {
                $this->Flash->error('Your username or password is incorrect.');
                return $this->redirect(['action' => 'signin']);
            }
        }
    }

    public function forgotpassword() {


        $this->loadModel('Users');

        //$user = $this->Users->newEntity();
        if ($this->request->is('post')) {

            // Checking if User is valid or not.
            $tableRegObj = TableRegistry::get('Users');
            $userExist = $tableRegObj->find()->where(['email' => $this->request->data['email']])->first();
            //pr($userExist);
            //echo $userExist->id;
            //exit;
            $etRegObj = TableRegistry::get('EmailTemplates');
            $emailTemp = $etRegObj->find()->where(['id' => 1])->first()->toArray();

            $siteSettings = $this->site_setting();
            //pr($siteSettings); pr($emailTemp); pr($userExist); pr($this->request->data); exit;
            if (!empty($userExist)) {
                $chkPost = $this->generateRandomString(); //Generating new Password
                $this->request->data['password'] = $chkPost;
                $this->request->data['password'] = $this->request->data['password'];
                $this->request->data['id'] = $userExist->id;
                $userdt = TableRegistry::get('Users');
                $query = $userdt->query();

                //$user = $this->Admins->find()->where(['id' => $this->request->data['id']])->first();
                $user = $this->Users->patchEntity($userExist, $this->request->data);
                $this->Users->save($user);

                $mail_To = $userExist['email'];
                $mail_CC = '';
                $mail_subject = $emailTemp['subject'];
                $name = $userExist['first_name']." ".$userExist['last_name'];
                $url = Router::url('/', true);
                //$link = $url . 'users/setpassword/' . $chkPost;

                $mail_body = str_replace(array('[NAME]', '[PASSWORD]'), array($name, $chkPost), $emailTemp['content']);
                //echo $mail_body; exit();
                // Sending user the reset password link.
                $email = new Email('default');
                if ($email->emailFormat('html')->from(['nit.spandan@gmail.com' => 'Biketory'])
                                ->to($userExist['email'])
                                ->subject($mail_subject)
                                ->send($mail_body)) {
                    $this->Flash->success(__('Your new password sent to your email.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->error(__('Email Not Registerd With Us, try with another.'));
                    return $this->redirect(array('action' => 'index'));
                }
            } else {
                $this->Flash->error(__('Email Not Registerd With Us, try with another.'));
                return $this->redirect(array('action' => 'index'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function signout() {
        $this->Auth->logout();
        $this->Flash->success(__('You are Successfully loged out.'));
        return $this->redirect('/');
    }

    public function dashboard() {
        
        $this->viewBuilder()->layout('default');
        $this->loadModel('Products');
        $this->loadModel('Productsimages');
        $this->loadModel('Bikemodels'); 
        $this->loadModel('Makes');
        $this->loadModel('Users');
        $this->loadModel('Recentviews');

        $prdIdArray = array();
        $recentViewProdId = $this->Recentviews->find()->select('prd_id')->distinct('prd_id')->where(['type' => 'bike'])->order(['id' => 'DESC'])->limit(4)->toArray();

        foreach($recentViewProdId as $prdval){
            $prod_id = $prdval->prd_id;

            array_push($prdIdArray, $prod_id);
        }

        $condition = ['Products.id IN' => $prdIdArray];

        $productsRecent = $this->Products->find()                        
                        ->where($condition)                        
                        ->order(['Products.price' => $order_by])
                        ->contain(['Productsimages', 'Makes', 'Bikemodels'])
                        ->toArray();

        $prdIdMostViewArray = array();
        $mostViewProdId = $this->Recentviews->find()->select('prd_id')->where(['type' => 'bike'])->order(['COUNT(prd_id)' => 'DESC'])->group('prd_id')->limit(4)->toArray();

        foreach($mostViewProdId as $mostviewad){
            $mvprdid = $mostviewad->prd_id;
            array_push($prdIdMostViewArray, $mvprdid);
        }

        $condition_one = ['Products.id IN' => $prdIdMostViewArray];

        $productsMostViewed = $this->Products->find()                        
                        ->where($condition_one)                        
                        ->order(['Products.price' => $order_by])
                        ->contain(['Productsimages', 'Makes', 'Bikemodels'])
                        ->toArray();

        $title = "Dashboard";
        
        $uid = $this->request->session()->read('Auth.User.id');
        $user = $this->Users->get($this->Auth->user('id'));

        $this->set(compact('productsRecent','productsMostViewed'));
        
    }

    public function sellerdashboard() {
        $this->viewBuilder()->layout('default');
        $this->loadModel('Products');
        $this->loadModel('Productsimages');
        $this->loadModel('Bikemodels'); 
        $this->loadModel('Makes');
        $this->loadModel('Users');
        $this->loadModel('Recentviews');
        
        $prdIdArray = array();
        $recentViewProdId = $this->Recentviews->find()->select('prd_id')->distinct('prd_id')->where(['type' => 'bike'])->order(['id' => 'DESC'])->limit(4)->toArray();

        foreach($recentViewProdId as $prdval){
            $prod_id = $prdval->prd_id;

            array_push($prdIdArray, $prod_id);
        }

        $condition = ['Products.id IN' => $prdIdArray];

        $productsRecent = $this->Products->find()                        
                        ->where($condition)                        
                        ->order(['Products.price' => $order_by])
                        ->contain(['Productsimages', 'Makes', 'Bikemodels'])
                        ->toArray();

        $prdIdMostViewArray = array();
        $mostViewProdId = $this->Recentviews->find()->select('prd_id')->where(['type' => 'bike'])->order(['COUNT(prd_id)' => 'DESC'])->group('prd_id')->limit(4)->toArray();

        foreach($mostViewProdId as $mostviewad){
            $mvprdid = $mostviewad->prd_id;
            array_push($prdIdMostViewArray, $mvprdid);
        }

        $condition_one = ['Products.id IN' => $prdIdMostViewArray];

        $productsMostViewed = $this->Products->find()                        
                        ->where($condition_one)                        
                        ->order(['Products.price' => $order_by])
                        ->contain(['Productsimages', 'Makes', 'Bikemodels'])
                        ->toArray();

        $title = "Dashboard";
        $uid = $this->request->session()->read('Auth.User.id');
        $user = $this->Users->get($this->Auth->user('id'));
        //print_r($user);

        /*$latitude = $user->latitude;
        $longitude = $user->longitude;

        $conn = ConnectionManager::get('default');
        $services = $conn->execute('SELECT S.*, U.full_name, U.pimg, ( 3959 * acos( cos( radians(' . $latitude . ') ) * cos( radians( S.latitude ) ) * cos( radians( S.longitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin(radians(S.latitude)) ) ) AS distance FROM services as S left join users as U on S.provider_id = U.id HAVING distance < 200 ORDER BY distance LIMIT 0 , 20')->fetchAll('assoc');
            */
        $this->set(compact('title', 'user','productsRecent','productsMostViewed'));
    }

    public function addmultiplephoto() {

        $this->loadModel('ServiceProviderImages');

        $this->viewBuilder()->layout('other_layout');
        $user = $this->Users->get($this->Auth->user('id'));
        $id = $this->Auth->user('id');
        if ($this->request->is(['post', 'put'])) {

            if ($this->request->data['image'] != '') {
                $file_image_name = explode(",", $this->request->data['image']);
                //print_r($file_image_name);exit;
                foreach ($file_image_name as $img) {

                    $this->request->data['serviceprovider_id'] = $id;
                    $this->request->data['image_name'] = $img;
                    $spimage = $this->ServiceProviderImages->newEntity();
                    $spimage = $this->ServiceProviderImages->patchEntity($spimage, $this->request->data);

                    $this->ServiceProviderImages->save($spimage);
                }
            }

            $this->Flash->success(__('Your photos has been edited successfully.'));
            //return $this->redirect(['action' => 'serviceeditprofile']);
        }


        $all_image = $this->ServiceProviderImages->find()->where(['ServiceProviderImages.serviceprovider_id' => $this->Auth->user('id')])->toArray();

        $this->set(compact('user', 'all_image'));
        $this->set('_serialize', ['user', 'all_image']);
    }

    function fetchservice() {
        $this->loadModel('Services');
        $cid = $_REQUEST['stid'];

        //echo $cid;exit;
        $size = $this->Services->find()->where(['service_type_id' => $cid])->toArray();


        if (!empty($size)) {
            $data = array('Ack' => 1, 'data' => $size);
        } else {
            $data = array('Ack' => 0);
        }
        echo json_encode($data);
        exit();
    }

    //service edit
    public function serviceeditprofile() {

        $this->viewBuilder()->layout('default');
        $user = $this->Users->get($this->Auth->user('id'));
        $id = $this->Auth->user('id');
        if ($this->request->is(['post', 'put'])) {
            pr($this->request->data);
            $flag = true;

            if ($flag) {
                $user = $this->Users->patchEntity($user, $this->request->data);
                $user['modified'] = gmdate("Y-m-d H:i:s");
                if ($this->Users->save($user)) {

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


        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function uploadphotoaddi() {


        //$this->viewBuilder()->autoRender(false);
        $this->viewBuilder()->layout(false);
        $filen = '';
        //print_r($_FILES);
        if (!empty($_FILES['files']['name'])) {

            if($_FILES["files"]['name']){
                $no_files = count($_FILES["files"]['name']);
            }

            

            //echo $no_files;exit;
            for ($i = 0; $i < $no_files; $i++) {
                if ($_FILES["files"]["error"][$i] > 0) {
                    echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
                    //echo 'a';exit;
                } else {

                    $pathpart = pathinfo($_FILES["files"]["name"][$i]);
                    //echo $pathpart;exit;
                    $ext = $pathpart['extension'];
                    $uploadFolder = "user_img/";
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

    public function uploaddocadd() {


        //$this->viewBuilder()->autoRender(false);
        $this->viewBuilder()->layout(false);
        $filen = '';
        //print_r($_FILES);
        if (!empty($_FILES['files1']['name'])) {

            if($_FILES["files1"]['name']){
                $no_files = count($_FILES["files1"]['name']);    
            }
            

            //echo $no_files;exit;
            for ($i = 0; $i < $no_files; $i++) {
                if ($_FILES["files1"]["error"][$i] > 0) {
                    echo "Error: " . $_FILES["files1"]["error"][$i] . "<br>";
                    //echo 'a';exit;
                } else {

                    $pathpart = pathinfo($_FILES["files1"]["name"][$i]);
                    //echo $pathpart;exit;
                    $ext = $pathpart['extension'];
                    $uploadFolder = "user_doc/";
                    $uploadPath = WWW_ROOT . $uploadFolder;
                    $filename = uniqid() . '.' . $ext;
                    $full_flg_path = $uploadPath . '/' . $filename;
                    if (move_uploaded_file($_FILES['files1']['tmp_name'][$i], $full_flg_path)) {
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

    public function deletefavourite() {

        //$this->viewBuilder()->layout(false);
        $this->loadModel('Favourites');
        $imageid = $this->Favourites->get($_GET['id']);


        if ($this->Favourites->delete($imageid)) {

            $data = array('Ack' => 1);
        } else {
            $data = array('Ack' => 0);
        }
        echo json_encode($data);
        exit();
    }

    public function deleteimage() {

        //$this->viewBuilder()->layout(false);
        $this->loadModel('ServiceProviderImages');
        $imageid = $this->ServiceProviderImages->get($_GET['id']);


        if ($this->ServiceProviderImages->delete($imageid)) {
            if ($imageid->image_name != "") {
                $filePathDel = WWW_ROOT . 'user_img' . DS . $imageid->image_name;
                if (file_exists($filePathDel)) {
                    unlink($filePathDel);
                }
            }
            $data = array('Ack' => 1);
        } else {
            $data = array('Ack' => 0);
        }
        echo json_encode($data);
        exit();
    }

    public function deletedocument() {

        //$this->viewBuilder()->layout(false);
        $this->loadModel('ServiceProviderDocuments');
        $imageid = $this->ServiceProviderDocuments->get($_REQUEST['id']);

        if ($this->ServiceProviderDocuments->delete($imageid)) {

            if ($imageid->doc_name != "") {
                $filePathDel = WWW_ROOT . 'user_doc' . DS . $imageid->doc_name;
                if (file_exists($filePathDel)) {
                    unlink($filePathDel);
                }
            }
            $data = array('Ack' => 1);
        } else {
            $data = array('Ack' => 0);
        }
        echo json_encode($data);
        exit();
    }

    // Users edit profile
    public function editprofile() {

        $this->viewBuilder()->layout('default');
        $user = $this->Users->get($this->Auth->user('id'));
        if ($this->request->is(['post', 'put'])) {

            $flag = true;

            if ($flag) {
                $this->request->data['modified'] = gmdate("Y-m-d h:i:s");

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


        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function changepass() {

        $this->viewBuilder()->layout('default');
        $this->loadModel('Users');
        $user = $this->Users->get($this->Auth->user('id'));
        //$user = $this->Auth->identify();

        // echo "<pre>";
        // print_r($user);
        // exit;
        $existing_password = $user->password;

        //echo $user->password.'<br>';

        if ($this->request->is(['post', 'put'])) {

            //echo "<pre>";print_r($this->request->data);exit;

            $old_pass = $this->request->data['old_password'];
            $new_pass = $this->request->data['new_password'];
            $confirm_pass = $this->request->data['confirm_password'];

            $hasher = new DefaultPasswordHasher();

            if($hasher->check($old_pass, $existing_password)){

                if($new_pass == $confirm_pass){
                    $update_password['password'] = $new_pass;
                    $user = $this->Users->patchEntity($user, $update_password);
                    if ($this->Users->save($user)){
                        $this->Flash->success(__('Password has been Changed successfully.'));
                    }
                }
                else{
                    $this->Flash->error(__('New password and confirm password mismatch.'));
                }

            }
            else{
                $this->Flash->error(__('Old password incorrect.'));
            }

            //return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function searchlist() {
        $this->viewBuilder()->layout('default');
        $this->loadModel('Services');
        //$this->loadModel('Favourites');
        $uid = $this->request->session()->read('Auth.User.id');
        $conn = ConnectionManager::get('default');
        //this->loadModel('Tags');
        if ($this->request->is('post')) {
            $make_id = $this->request->data['make_id'];
            $service_type_id = $this->request->data['service_type_id'];
            $lat = $this->request->data['latitude'];
            $long = $this->request->data['longitude'];
            $conditions = "";

            if ($make_id != '') {
                $conditions .='u.service_make_id LIKE "%' . $make_id . '%" AND ';
            }
            if ($service_type_id != "") {

                $conditions .='u.service_type_id LIKE "%' . $service_type_id . '%" AND ';
            }

            if ($lat != "" && $long != "") {

                $allservice = $conn->execute("select *,s.id, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( u.latitude ) ) * cos( radians( u.longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) * sin( radians( u.latitude ) ) ) ) AS distance from users as u left join services as s on u.id=s.provider_id left join service_provider_images as spi on spi.serviceprovider_id=u.id  where $conditions s.is_active='1' group by s.id having distance <=10 ")->fetchAll('assoc');
            } else {

                $allservice = $conn->execute("select *,s.id from users as u left join services as s on u.id=s.provider_id left join service_provider_images as spi on spi.serviceprovider_id=u.id  where $conditions s.is_active='1' group by s.id ")->fetchAll('assoc');
            }

            // pr($allservice);exit;
            // $allservice = $this->Services->find()->contain(['Users'=>['ServiceProviderImages']])->where([$conditions])->order(['Services.id' => 'DESC'])->toArray();
            //pr($allservice);exit;

            foreach ($allservice as $dt) {

                // pr($dt);exit;


                $avg_rating = $conn->execute("SELECT avg(`rating`) as avr FROM `reviews` where is_active= 1 and service_id= '" . $dt['id'] . "' ")->fetchAll('assoc');
                $price_range = $conn->execute("SELECT min(min_price) as mp,max(max_price) as mxp FROM `service_provider_types` where service_id= '" . $dt['id'] . "' ")->fetchAll('assoc');

                $allservices[] = array('rating' => $avg_rating, 'price' => $price_range, 'details' => $dt);
            }

            //pr($allservices);exit;        
            //$this->set('allservices', $this->Paginator->paginate($allservices));
            $this->set(compact('allservices'));
        }
    }

    /* public function searchlist() {
      $this->viewBuilder()->layout('other_layout');
      $this->loadModel('Services');
      $this->loadModel('Favourites');
      $uid = $this->request->session()->read('Auth.User.id');
      $conn = ConnectionManager::get('default');
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


      $top_results = $this->Services->find()->where([$conditions])->contain(['Users','ServiceProviderTags'=>['Tags']])->limit(2)->toArray();

      foreach($top_results as $dt){

      $rvratings = $conn->execute("SELECT avg(rating) as avgr FROM `reviews` WHERE  service_id= '".$dt['id']."' and is_active=1 ")->fetchAll('assoc');

      $favourite="";
      if($uid!='' && isset($uid)){
      $favourite = $this->Favourites->find()->where(['service_id' => $dt['id'],'user_id' => $uid])->first();
      }

      $top_result[] = array('rating' => $rvratings, 'favourite'=>$favourite, 'details' => $dt);

      }


      $rest_results = $this->Services->find()->where([$conditions])->contain(['Users','ServiceProviderTags'=>['Tags']])->limit(8)->offset(2)->toArray();

      foreach($rest_results as $dt){

      $rvratings = $conn->execute("SELECT avg(rating) as avgr FROM `reviews` WHERE  service_id= '".$dt['id']."' and is_active=1 ")->fetchAll('assoc');

      $favourite="";
      if($uid!='' && isset($uid)){
      $favourite = $this->Favourites->find()->where(['service_id' => $dt['id'],'user_id' => $uid])->first();
      }


      $rest_result[] = array('rating' => $rvratings, 'favourite'=>$favourite, 'details' => $dt);

      }




      $result = $this->Services->find()->where([$conditions])->contain(['Users','ServiceProviderTags'=>['Tags']])->toArray();

      $this->set(compact('top_result','rest_result','result'));



      }

      } */

    public function recendviewlist() {
        $this->viewBuilder()->layout('other_layout');
        $this->loadModel('ServiceViews');
        $this->loadModel('Favourites');
        $uid = $this->request->session()->read('Auth.User.id');
        $conn = ConnectionManager::get('default');

        $top_results = $this->ServiceViews->find()->where(['user_id' => $uid])->contain(['Services' => ['Users', 'ServiceProviderTags' => ['Tags']]])->limit(2)->toArray();

        foreach ($top_results as $dt) {

            $rvratings = $conn->execute("SELECT avg(rating) as avgr FROM `reviews` WHERE  service_id= '" . $dt['service']['id'] . "' and is_active=1 ")->fetchAll('assoc');

            $favourite = $this->Favourites->find()->where(['service_id' => $dt['service']['id'], 'user_id' => $uid])->first();
            $top_result[] = array('rating' => $rvratings, 'favourite' => $favourite, 'details' => $dt);
        }

        $rest_results = $this->ServiceViews->find()->where(['user_id' => $uid])->contain(['Services' => ['Users', 'ServiceProviderTags' => ['Tags']]])->limit(8)->offset(2)->toArray();

        foreach ($rest_results as $dt) {

            $rvratings = $conn->execute("SELECT avg(rating) as avgr FROM `reviews` WHERE  service_id= '" . $dt['service']['id'] . "' and is_active=1 ")->fetchAll('assoc');

            $favourite = $this->Favourites->find()->where(['service_id' => $dt['service']['id'], 'user_id' => $uid])->first();
            $rest_result[] = array('rating' => $rvratings, 'favourite' => $favourite, 'details' => $dt);
        }

        $result = $this->ServiceViews->find()->where(['user_id' => $uid])->contain(['Services' => ['Users', 'ServiceProviderTags' => ['Tags']]])->toArray();

        $this->set(compact('top_result', 'rest_result', 'result'));
    }

    public function toptenlist() {
        $this->viewBuilder()->layout('other_layout');
        $this->loadModel('Reviews');
        $this->loadModel('Services');
        $this->loadModel('Tags');
        $this->loadModel('Users');
        $this->loadModel('Favourites');
        $this->loadModel('ServiceProviderTags');
        $uid = $this->request->session()->read('Auth.User.id');
        $conn = ConnectionManager::get('default');
        $review = $conn->execute("SELECT * from (SELECT sum(`rating`) as rate,service_id FROM `reviews` group by `service_id`) as temp order by rate desc limit 10")->fetchAll('assoc');
        // pr($review);exit;
        for ($i = 0; $i < 2; $i++) {
            $top_results = $this->Services->find()->where(['Services.id' => $review[$i]['service_id']])->contain(['Users', 'ServiceProviderTags' => ['Tags']])->toArray();

            $ttrating = $conn->execute("SELECT avg(rating) as avgr FROM `reviews` WHERE  service_id= '" . $review[$i]['service_id'] . "' and is_active=1 ")->fetchAll('assoc');

            $favourite = "";
            if ($uid != '' && isset($uid)) {
                $favourite = $this->Favourites->find()->where(['service_id' => $review[$i]['service_id'], 'user_id' => $uid])->first();
            }
            $top_result[] = array('rating' => $ttrating, 'favourite' => $favourite, 'details' => $top_results);

            $result[] = $this->Services->find()->where(['Services.id' => $review[$i]['service_id']])->contain(['Users', 'ServiceProviderTags' => ['Tags']])->toArray();
//pr($result);
        }

        if($review){
            for ($i = 2; $i < count($review); $i++) {
                $rest_results = $this->Services->find()->where(['Services.id' => $review[$i]['service_id']])->contain(['Users', 'ServiceProviderTags' => ['Tags']])->toArray();


                $ttrating = $conn->execute("SELECT avg(rating) as avgr FROM `reviews` WHERE  service_id= '" . $review[$i]['service_id'] . "' and is_active=1 ")->fetchAll('assoc');

                $favourite = "";
                if ($uid != '' && isset($uid)) {
                    $favourite = $this->Favourites->find()->where(['service_id' => $review[$i]['service_id'], 'user_id' => $uid])->first();
                }

                $rest_result[] = array('rating' => $ttrating, 'favourite' => $favourite, 'details' => $rest_results);

                //$result[] = $this->Services->find()->where(['Services.id'=>$review[$i]['service_id']])->contain(['Users','ServiceProviderTags'=>['Tags']])->toArray();
            }
        }
        


        $this->set(compact('top_result', 'rest_result', 'result'));
    }

    public function jimjafav() {
        $this->viewBuilder()->layout('other_layout');
        $this->loadModel('Reviews');
        $this->loadModel('Services');
        $this->loadModel('Tags');
        $this->loadModel('Users');
        $this->loadModel('ServiceProviderTags');
        $this->loadModel('Favourites');
        $uid = $this->request->session()->read('Auth.User.id');
        $conn = ConnectionManager::get('default');
        $jimjafav = $this->ServiceProviderTags->find()->where(['ServiceProviderTags.tag_id' => 1])->toArray();
        //pr($jimjafav);exit;
        for ($i = 0; $i < 2; $i++) {
            $top_results = $this->Services->find()->where(['Services.id' => $jimjafav[$i]['service_id']])->contain(['Users', 'ServiceProviderTags' => ['Tags']])->toArray();

            $jfrating = $conn->execute("SELECT avg(rating) as avgr FROM `reviews` WHERE  service_id= '" . $jimjafav[$i]['service_id'] . "' and is_active=1 ")->fetchAll('assoc');

            $favourite = "";
            if ($uid != '' && isset($uid)) {
                $favourite = $this->Favourites->find()->where(['service_id' => $jimjafav[$i]['service_id'], 'user_id' => $uid])->first();
            }

            $top_result[] = array('rating' => $jfrating, 'favourite' => $favourite, 'details' => $top_results);


            $result[] = $this->Services->find()->where(['Services.id' => $jimjafav[$i]['service_id']])->contain(['Users', 'ServiceProviderTags' => ['Tags']])->toArray();
//pr($result);
        }

        if($jimjafav){
            for ($i = 2; $i < count($jimjafav); $i++) {
                $rest_results = $this->Services->find()->where(['Services.id' => $jimjafav[$i]['service_id']])->contain(['Users', 'ServiceProviderTags' => ['Tags']])->toArray();

                $jfrating = $conn->execute("SELECT avg(rating) as avgr FROM `reviews` WHERE  service_id= '" . $jimjafav[$i]['service_id'] . "' and is_active=1 ")->fetchAll('assoc');

                $favourite = "";
                if ($uid != '' && isset($uid)) {
                    $favourite = $this->Favourites->find()->where(['service_id' => $jimjafav[$i]['service_id'], 'user_id' => $uid])->first();
                }

                $rest_result[] = array('rating' => $jfrating, 'favourite' => $favourite, 'details' => $rest_results);

                //$result[] = $this->Services->find()->where(['Services.id'=>$review[$i]['service_id']])->contain(['Users','ServiceProviderTags'=>['Tags']])->toArray();
            }

        }
        


        $this->set(compact('top_result', 'rest_result', 'result'));
    }

    public function servicedetails($sid = NULL) {

        $this->viewBuilder()->layout('default');
        $this->loadModel('Services');
        $this->loadModel('ServiceViews');
        $this->loadModel('ServiceProviderImages');
        $this->loadModel('ServiceProviderTypes');
        $this->loadModel('Reviews');
        $uid = $this->request->session()->read('Auth.User.id');
        $utype = $this->request->session()->read('Auth.User.utype');

        if ($uid != '' && isset($uid)) {

            $alredyview = $this->ServiceViews->find()->where(['user_id' => $uid, 'service_id' => $sid])->first();
            if ($alredyview) {
                $serviceview = $this->ServiceViews->get($alredyview->id);
                $this->request->data['id'] = $alredyview->id;
                $this->request->data['user_id'] = $uid;
                $this->request->data['service_id'] = $sid;
                $this->request->data['view_date'] = gmdate("Y-m-d H:i:s");
                $serviceview = $this->ServiceViews->patchEntity($serviceview, $this->request->data);
                $this->ServiceViews->save($serviceview);
            } else {

                $this->request->data['user_id'] = $uid;
                $this->request->data['service_id'] = $sid;
                $this->request->data['view_date'] = gmdate("Y-m-d H:i:s");
                $serviceview = $this->ServiceViews->newEntity();
                $serviceview = $this->ServiceViews->patchEntity($serviceview, $this->request->data);
                $this->ServiceViews->save($serviceview);
            }
        }

        $conditions = ['Services.id' => $sid];

        $result = $this->Services->find()->where([$conditions])->contain(['Users', 'ServiceProviderTypes' => ['ServiceTypes'], 'ServiceProviderFeatures' => ['Features']])->first();

        $servicetypes = $this->ServiceProviderTypes->find()->where(['provider_id' => $result->user->id])->contain(['ServiceTypes'])->toArray();

        //$related_services = $this->Services->find()->where(['provider_id'=>$result->user->id, 'id !='=>$sid])->toArray();

        $serviceimages = $this->ServiceProviderImages->find()->where(['serviceprovider_id' => $result->user->id])->toArray();
        $workingdays = $this->Users->find()->where(['id' => $result->user->id])->first();

        $conn = ConnectionManager::get('default');
        $related_services = $conn->execute("SELECT avg(r.rating) as avg,s.id,s.service_name,min(spt.min_price) as mp FROM services as s left join `reviews` as r on r.service_id=s.id left join service_provider_types as spt on spt.service_id=s.id WHERE  s.id!=$sid and s.is_active=1 ")->fetchAll('assoc');
        //pr($review);exit;

        $reviewer = $this->Reviews->find()->contain(['Users', 'ReviewImages'])->where(['Reviews.service_provider_id' => $result->user->id, 'Reviews.is_active' => 1])->order('Reviews.id')->limit(3)->toArray();

        //pr($related_services);exit();

        $this->set(compact('result', 'serviceimages', 'workingdays', 'reviewer', 'servicetypes', 'related_services'));
    }

    /* public function servicedetails($sid = NULL) {

      $this->viewBuilder()->layout('other_layout');
      $this->loadModel('Services');
      $this->loadModel('ServiceViews');
      $this->loadModel('ServiceProviderImages');
      $this->loadModel('Reviews');
      $uid = $this->request->session()->read('Auth.User.id');
      $utype = $this->request->session()->read('Auth.User.utype');

      if($uid!='' && isset($uid)){

      $alredyview=$this->ServiceViews->find()->where(['user_id'=>$uid,'service_id'=>$sid])->first();
      if($alredyview){
      $serviceview = $this->ServiceViews->get($alredyview->id);
      $this->request->data['id'] = $alredyview->id;
      $this->request->data['user_id'] = $uid;
      $this->request->data['service_id'] = $sid;
      $this->request->data['view_date'] = gmdate("Y-m-d H:i:s");
      $serviceview = $this->ServiceViews->patchEntity($serviceview, $this->request->data);
      $this->ServiceViews->save($serviceview);
      }else{

      $this->request->data['user_id'] = $uid;
      $this->request->data['service_id'] = $sid;
      $this->request->data['view_date'] = gmdate("Y-m-d H:i:s");
      $serviceview = $this->ServiceViews->newEntity();
      $serviceview = $this->ServiceViews->patchEntity($serviceview, $this->request->data);
      $this->ServiceViews->save($serviceview);
      }
      }

      $conditions = ['Services.id' => $sid];

      $result = $this->Services->find()->where([$conditions])->contain(['Users','ServiceProviderTags'=>['Tags'],'ServiceProviderFeatures'=>['Features']])->first();
      //pr($result);
      $serviceimages = $this->ServiceProviderImages->find()->where(['serviceprovider_id'=>$result->user->id])->toArray();
      $workingdays = $this->Users->find()->where(['id'=>$result->user->id])->first();

      $conn = ConnectionManager::get('default');
      $review = $conn->execute("SELECT count(id) as reviewcount,avg(pricey) as ap,avg(friendly) as af,avg(comfortable) as ac,avg(ambient) as aa,avg(selection) as ase,avg(food) as afd FROM `reviews` WHERE  `service_id`=$sid and is_active=1 ")->fetchAll('assoc');
      //pr($review);

      $reviewer = $this->Reviews->find()->contain(['Users','ReviewImages'])->where(['Reviews.service_id'=>$sid,'Reviews.is_active'=>1])->order('Reviews.id')->limit(5)->toArray();

      // pr($reviewer);
      $this->set(compact('result','serviceimages','workingdays','review','reviewer'));


      } */

    public function addreview($id = null, $spid = null) {

        $this->viewBuilder()->layout('other_layout');
        $user = $this->request->session()->read('Auth.User.id');
        //echo $spid;exit;
        if ($user != '' && isset($user)) {
            $this->loadModel('ServiceTypes');
            $this->loadModel('Services');
            $this->loadModel('Tags');
            $this->loadModel('Reviews');
            $this->loadModel('RatingTypes');
            $this->loadModel('RatingTexts');
            $this->loadModel('ReviewImages');
            $review = $this->Reviews->newEntity();
            if ($this->request->is(['post'])) {


                if ($this->request->data['service_id'] != "") {


                    $this->request->data['user_id'] = $user;

                    $this->request->data['service_id'] = $this->request->data['service_id'];

                    $this->request->data['service_provider_id'] = $this->request->data['service_provider_id'];
                    $this->request->data['address'] = $this->request->data['address'];
                    $this->request->data['latitude'] = $this->request->data['latitude'];
                    $this->request->data['longitude'] = $this->request->data['longitude'];
                    $this->request->data['review'] = $this->request->data['review'];
                    $this->request->data['food'] = $this->request->data['FOOD'];
                    $this->request->data['friendly'] = $this->request->data['FRIENDLY'];
                    $this->request->data['ambient'] = $this->request->data['AMBIENT'];
                    $this->request->data['selection'] = $this->request->data['SELECTION'];
                    $this->request->data['pricey'] = $this->request->data['PRICEY'];
                    $this->request->data['comfortable'] = $this->request->data['COMFORTABLE'];
                    $this->request->data['post_date'] = gmdate("Y-m-d h:i:s");
                    $this->request->data['tag'] = implode(',', $this->request->data['tag']);
                    $this->request->data['rating'] = ($this->request->data['FOOD'] + $this->request->data['FRIENDLY'] + $this->request->data['AMBIENT'] + $this->request->data['SELECTION'] + $this->request->data['PRICEY'] + $this->request->data['COMFORTABLE']);

                    $reviewexists = $this->Reviews->find()->where(['user_id' => $user, 'service_id' => $this->request->data['service_id']])->first();


                    if (!$reviewexists) {
                        $review = $this->Reviews->patchEntity($review, $this->request->data);
                        if ($rs = $this->Reviews->save($review)) {

                            $review_image = explode(",", $this->request->data['image_name']);
                            //print_r($file_image_name);exit;
                            foreach ($review_image as $img) {


                                $this->request->data['review_id'] = $rs->id;
                                $this->request->data['image_name'] = $img;
                                $spimage = $this->ReviewImages->newEntity();
                                $spimage = $this->ReviewImages->patchEntity($spimage, $this->request->data);

                                $this->ReviewImages->save($spimage);
                            }

                            $this->Flash->success(__('Your review added successfully.'));
                        } else {

                            $this->Flash->error(__('Your review could not be added. Please, try again.'));
                        }
                    } else {
                        $this->Flash->error(__('Already review given.'));
                    }
                    $this->redirect(['action' => 'addreview', $this->request->data['service_id'], $this->request->data['service_provider_id']]);
                } else {

                    $this->Flash->error(__('Please select service.'));
                }
            }


            $conn = ConnectionManager::get('default');
            $ratingtypes = $conn->execute("SELECT * FROM `rating_types` WHERE is_active= 1 ")->fetchAll('assoc');

            foreach ($ratingtypes as $dt) {

                $findratingtext = $conn->execute("SELECT * FROM `rating_texts` as x inner join `rating_types` as y on y.id=x.type_id WHERE x.is_active= 1 and x.type_id= '" . $dt['id'] . "' ")->fetchAll('assoc');
                //pr($findratingtext);
                $ratingdetails = array();
                foreach ($findratingtext as $dt) {
                    $ratingdetails[] = array(
                        'id' => $dt['id'],
                        'type_id' => $dt['type_id'],
                        'rating_value' => $dt['rating_value'],
                        'rating_text' => $dt['rating_text'],
                        'type_name' => $dt['type_name'],
                    );
                }
                $rating[] = array(
                    'id' => $dt['id'],
                    'type_name' => $dt['type_name'],
                    'details' => $ratingdetails
                );
            }

            //pr($rating);
            $ratingtypes = $this->RatingTypes->find()->where(['is_active' => 1])->toArray();
            $servicetypes = $this->ServiceTypes->find()->where(['status' => 1])->toArray();
            $servicetags = $this->Tags->find()->where(['status' => 1])->toArray();
            $servicedetails = $this->Services->find()->where(['id' => $id])->first();


            $this->set(compact('user', 'ratingtypes', 'rating', 'id', 'spid', 'servicetypes', 'servicetags', 'servicedetails'));
            $this->set('_serialize', ['user']);
        }
    }

    public function favouritelist() {
        $this->viewBuilder()->layout('default');
        $uid = $this->request->session()->read('Auth.User.id');
        $utype = $this->request->session()->read('Auth.User.utype');
        $user = $this->Users->get($this->Auth->user('id'));
        $this->loadModel('Favourites');
        if ($uid != '' && isset($uid)) {

            $this->set('favourite', $this->Paginator->paginate($this->Favourites, [ 'limit' => 12, 'contain' => ['Services' => ['Users', 'ServiceProviderTags' => ['Tags']]], 'conditions' => [ 'Favourites.user_id' => $uid, 'Services.is_active' => 1]]));

            $this->set(compact('favourite', 'user'));
        } else {

            $this->Flash->error('Please login to access dashboard.');
            return $this->redirect('/');
        }
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
            $Msg = array('Ack' => 0, 'data' => 'Please Login First.');
        } else {

            $product = $this->Services->find()->where(['id' => $id])->first();
            //pr($product);exit;

            $Current_woner_id = $product['provider_id'];
            //echo $Current_woner_id;exit;
            $productsInCart = $this->Favourites->find()->where(['Favourites.user_id' => $userid])->toArray();

            if ($this->request->is('post')) {
                $product_woner_id = '';
                $alreadyIn = false;
                $woner_check = false;
                if ($productsInCart && count($productsInCart) > 0) {
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
                        $Msg = array('Ack' => 1, 'data' => 'Service added to favourite list.');
                    } else {
                        $Msg = array('Ack' => 0, 'data' => 'The Service could not be saved into the faviourite list. Please, try again.');
                    }
                } elseif ($userid == $Current_woner_id) {
                    $Msg = array('Ack' => 0, 'data' => 'You cannot add your own Service.');
                } else {
                    $Msg = array('Ack' => 0, 'data' => 'Service already in favourite list.');
                }
            }
        }
        echo json_encode($Msg);
        exit();
    }

    public function uploadreviewadd() {

        $this->viewBuilder()->layout(false);
        $filen = '';

        if (!empty($_FILES['files']['name'])) {
            if($_FILES["files"]['name']){
                $no_files = count($_FILES["files"]['name']);
            }
            

            //echo $no_files;exit;
            for ($i = 0; $i < $no_files; $i++) {
                if ($_FILES["files"]["error"][$i] > 0) {
                    echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
                    //echo 'a';exit;
                } else {

                    $pathpart = pathinfo($_FILES["files"]["name"][$i]);
                    //echo $pathpart;exit;
                    $ext = $pathpart['extension'];
                    $uploadFolder = "review_img/";
                    $uploadPath = WWW_ROOT . $uploadFolder;
                    $filename = uniqid() . '.' . $ext;
                    $full_flg_path = $uploadPath . '/' . $filename;
                    if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $full_flg_path)) {


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
//    public function forgotpassword() {
//
////        if ($this->request->session()->check('Auth.User') == true) {
////            $this->redirect(['controller' => 'Users', 'action' => 'dashboard']);
////        }
////
////        if ($this->request->session()->check('Auth.Doctor') == true) {
////            $this->redirect(['controller' => 'Doctors', 'action' => 'dashboard']);
////        }
//
//        //$this->viewBuilder()->layout('default');
//        $user = $this->Users->newEntity();
//        if ($this->request->is('post')) {
//
//            // Checking if User is valid or not.
//            $tableRegObj = TableRegistry::get('Users');
//            $userExist = $tableRegObj->find()->where(['email' => $this->request->data['email']])->first()->toArray();
//
//            $etRegObj = TableRegistry::get('EmailTemplates');
//            $emailTemp = $etRegObj->find()->where(['id' => 1])->first()->toArray();
//
//            $siteSettings = $this->site_setting();
//            //pr($siteSettings); pr($emailTemp); pr($userExist); pr($this->request->data); exit;
//            if (!empty($userExist)) {
//                $chkPost = $this->generateRandomString(); //Generating new Password
//
//                $userdt = TableRegistry::get('Users');
//                $query = $userdt->query();
//
//                $query->update()->set(['cpass_req' => 1, 'cpass_value' => $chkPost])->where(['id' => $userExist['id']])->execute();
//
//                $mail_To = $userExist['email'];
//                $mail_CC = '';
//                $mail_subject = $emailTemp['subject'];
//                $name = $userExist['first_name'] . " " . $userExist['last_name'];
//                $url = Router::url('/', true);
//                $link = $url . 'users/setpassword/' . $chkPost;
//
//                $mail_body = str_replace(array('[NAME]', '[LINK]'), array($name, $link), $emailTemp['content']);
//                //echo $mail_body; //exit;
//
//                // Sending user the reset password link.
//                $email = new Email('default');
//                if ($email->emailFormat('html')->from(['info@proptino.com' => 'Proptino'])
//                                ->to($userExist['email'])
//                                ->subject($mail_subject)
//                                ->send($mail_body)) {
//                    $this->Flash->success(__('Your change password link has been sent to your email.'));
//                    return $this->redirect(array('action' => 'forgotpassword'));
//                } else {
//                    $this->Flash->error(__('Email Not Registerd With Us, try with another.'));
//                }
//            } else {
//                $this->Flash->error(__('Email Not Registerd With Us, try with another.'));
//            }
//        }
//        $this->set(compact('user'));
//        $this->set('_serialize', ['user']);
//    }
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
        foreach ($orderExist as $ordExist) {
            foreach ($ordExist['orderdetails'] as $ordDet) {
                $medArr[] = $ordDet->medicine->id;
            }
        }
        $medArr = array_unique($medArr);

        if (!empty($medArr)) {
            if (count($medArr) == 1) {
                $revMedicine = $medArr[0];
            } else {
                $revMedicineDt = "";
                foreach ($medArr as $k => $v) {
                    $revMedicineDt = $revMedicineDt . "," . $v;
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
            }

            if ($this->request->data['ftype'] == 'review') {
                //pr($this->request->data); exit;
                if (!empty($this->request->data['rate'])) {
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
                } else {
                    $this->Flash->error(__('Please enter your rating.'));
                }
            }
        }

        //$this->request->session()->read('Auth.User.id');

        $reviews = $this->Reviews->find()->where(['Reviews.txn_id' => $txn])->first();
        if (!empty($reviews)) {
            $review = $reviews->toArray();
        } else {
            $review = array();
        }
        //pr($review);
        //pr($orderExist); exit;


        $this->set(compact('orderExist', 'user', 'presc', 'transaction', 'review', 'revMedicine'));
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
            $this->Flash->error('Your Cart is empty.'); //Checking cart is empty or not
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


        $this->set(compact('orderExist', 'cartData', 'is_login', 'user'));
        $this->set('_serialize', ['cartData']);
    }

    public function exportUsers() {

        $uid = $this->Auth->user('id');
        //$events = $this->User->find('all',array('conditions' => array('User.is_paid' => 1)));
        $this->loadModel('Landlords');
        $this->loadModel('Properties');
        $events = $this->Landlords->find()->where(['user_id' => $uid])->toArray();


        //print_r($events);
        //$this->layout = false;
        $output = '';
        $output .='Id,Property,Company, Email,FirstName,LastName,Phone,Address, BankDetails';
        $output .="\n";

        if (!empty($events)) {
            //print_r($events);die;
            foreach ($events as $event) {
                $id = $event->id;
                $property_id = $event->property_id;
                //echo$id; die;
                $company_name = $event->company_name;
                $address = $event['address'];
                //print_r($address);die;
                $bank_details = $event['bank_details'];
                $email = $event['email'];
                $first_name = $event['first_name'];
                $last_name = $event['last_name'];
                $phone = $event['phone'];
                $add_date = $event['add_date'];
                $props = $this->Properties->find("all")->where(["is_active" => 1, 'id' => $property_id])->toArray();
                foreach ($props as $prop) {
                    $properties = $prop->address;
                }

                $output .='"' . $id . '","' . $properties . '","' . $company_name . '","' . $email . '","' . $first_name . '","' . $last_name . '","' . $phone . '","' . $address . '","' . $bank_details . '"';
                $output .="\n";
            }
        }


        $filename = "myFile" . time() . ".csv";
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        echo $output;
        exit;
    }

    //export certificate
    public function exportCertificate() {
        $uid = $this->Auth->user('id');
        $this->loadModel('Certificate');
        $events = $this->Certificate->find()->where(['user_id' => $uid])->toArray();
        $output = '';
        $output .='Id,Title,CertificateNo,IssueDate,ExpriDate';
        $output .="\n";
        if (!empty($events)) {
            //print_r($events);die;
            foreach ($events as $event) {
                $id = $event->id;

                //echo$id; die;
                $title = $event['title'];
                //print_r($address);die;
                $certificate_no = $event['certificate_no'];
                $issue_date = $event['issue_date'];
                $expire_date = $event['expire_date'];
                $output .='"' . $id . '","' . $title . '","' . $certificate_no . '","' . $issue_date . '","' . $expire_date . '"';
                $output .="\n";
            }
        }


        $filename = "myFile" . time() . ".csv";
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        echo $output;
        exit;
    }

////add certficate
    public function certificates() {
        $this->loadModel('Certificate');
        $this->loadModel("Properties");
        $uid = $this->Auth->user('id');
        //echo $uid; die;
        $conditions["Certificate.user_id"] = $uid;
        // print_r($conditions); die;

        if ($this->request->is('get')) {
            //echo $this->request->is('get');die;


            $filter = array("page");
            //print_r($filter); die;
            foreach ($this->request->query as $key => $val) {
                if (!in_array($key, $filter)) {
                    if (!empty($val)) {
                        if ($key == "property_id" || $key == "certificate_no") {
                            $conditions["Certificate." . $key] = $val;
                        } else {
                            $conditions["Certificate." . $key . " LIKE "] = '%' . $val . '%';
                            //print_r($conditions); die;
                        }
                    }
                    $this->request->data[$key] = $val;
                }
            }
            // print_r($conditions); die;
        }
        $options = [
            "limit" => 10,
            // "contain"=>"Properties",
            "order" => [
                'Certificate.id' => 'desc'
            ],
            "conditions" => $conditions
        ];
        // print_r($options);die;
        $result = $this->paginate($this->Certificate, $options);
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
        $this->set(compact('result', 'Certi'));
        $this->set('_serialize', ['result']);
    }

    public function addcretificate() {

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
        $this->request->data["user_id"] = $uid;

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

        if ($flag) {
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
        $props = $this->Properties->find("all")->where(["is_active" => 1, 'user_id' => $uid])->toArray();
        foreach ($props as $prop) {
            $properties[$prop->id] = $prop->address;
        }

        $this->set(compact('addcertificate', 'properties'));
        $this->set('_serialize', ['addcertificate', 'properties']);
    }

    public function delete($id) {
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

        $id = base64_decode($id);
        $this->request->data["user_id"] = $uid;
        $props = $this->Properties->find("all")->where(["is_active" => 1, 'user_id' => $uid])->toArray();
        foreach ($props as $prop) {
            $properties[$prop->id] = $prop->title;
        }

        // print_r($id);die;
        // $flag=false;
        if ($this->request->is(['patch', 'post', 'put'])) {



            // pr($this->request->data); exit;
            // $this->loadModel('SideBar');
            $tableRegObj = TableRegistry::get('Certificate');
            $slugExist = $tableRegObj
                            ->find()
                            ->where(['title' => $this->request->data['title'], 'id !=' => $id])->toArray();
            // print_r($slugExist);
            // $this->request->data; die;
            //pr($getAllResults); exit;
            //pr($this->request->data); exit;
            // $issue_date = date("Y-m-d", strtotime($this->request->data));
            //print_r($issue_date); die;

            $flag = true;

            if ($this->request->data['title'] == "") {
                $this->Flash->error(__('Title can not be null. Please, try again.'));
                $flag = false;
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

        $flag = "";
        if ($flag) {

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


        $this->set(compact('result', 'properties'));
        $this->set('_serialize', ['result', 'properties']);
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

        if ($txnId != "") {

            $transaction = $this->Transactions->find()->contain(['Orders', 'Users'])->where(['Transactions.transaction_id' => $txnId])->first()->toArray();

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
            if ($resArray['ACK'] == 'Success') {
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

                foreach ($transaction['Orders'] as $cancelOrder) {
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
                $this->redirect(['controller' => 'Users', 'action' => 'prescriptiondetail', $txnId]);
            } else {
                $this->Flash->success(__('Your cancel order Not done Try again.'));
                $this->redirect(['controller' => 'Users', 'action' => 'prescriptiondetail', $txnId]);
            }
        } else {
            $this->Flash->success(__('Your cancel order Not done Try again.'));
            $this->redirect(['controller' => 'Users', 'action' => 'prescriptiondetail', $txnId]);
        }
    }

    public function insertmessagefooter(){

  //print_r($_REQUEST);exit;
     //print_r($_FILES["file"]["name"]);exit;
       $this->viewBuilder()->layout(false);
       $userid = $this->request->session()->read('Auth.User.id');
             
       $this->loadModel('Users');
       $this->loadModel('Chatmessages');
       //$this->loadModel('Myemojs');
       
       $Messages = $this->Chatmessages->newEntity();
        //$Messagesej = $this->Myemojs->newEntity();
        // $emj['emojicolumn'] = $_REQUEST['message_text'];
        // $Messagesej = $this->Myemojs->patchEntity($Messagesej, $emj);
       
       //$this->Myemojs->save($Messagesej);

         $friend_id = $_REQUEST['friend_id'];
         $message_text = $_REQUEST['message_text'];
         
         $this->request->data['from_id'] = $userid;
         $this->request->data['to_id'] = $friend_id;
         $this->request->data['message'] = base64_encode($message_text);
         $this->request->data['date_time'] = date('Y-m-d H:i:s');
         
         //print_r($this->request->data);exit;

        $user_details=  $this->Users->find()->where(['id'  => $userid])->select(['pimg'])->first();                       
        $Messages = $this->Chatmessages->patchEntity($Messages, $this->request->data);
         
        if ($rs=$this->Chatmessages->save($Messages)) {
                        
            $last_message_id = $rs->id;
            $curr_time = date('Y:m:d H:i:s');
            $diff_time = (strtotime($curr_time)-strtotime($this->request->data['date_time']));

            $hurs = intval($diff_time/(60*60));
            $mins = intval($diff_time/60);

            $message = '<div class="msg_a w-100 float-left mb-2 mr-0">
                <div class="msg-img-box rounded-circle d-inline-block mr-1">
                  <img class="rounded-circle img-fluid" src="'.$this->request->webroot.'user_img/'.(($user_details->pimg == "")? "default.png" : 'thumb_'.$user_details->pimg).'" alt="">          
                </div>
                <div class="msg-txt-box d-inline-block p-relative">
                  <p class="mb-0 font-13 text-dark">'.$message_text.'</p>
                </div>
                <div class="msg-datetim-box float-right w-25 text-right">
                  <span class="text-muted font-12">'.$curr_time.'</span>
                </div>
              </div>';  

        }
        echo $last_message_id."||".$message;
        exit();
    }

    public function chatmessage(){

        $this->loadModel("Chatmessages"); 
        $user_id = $this->request->session()->read('Auth.User.id'); 
        $conn = ConnectionManager::get('default'); 

        $all_users = $conn->execute("select U.id, U.pimg, U.first_name,U.last_name,U.business_name, U.is_active, F.message, F.date_time,(SELECT count(*) FROM chatmessages where chatmessages.from_id=U.id AND chatmessages.to_id = $user_id AND chatmessages.is_read = 'N' ) as read_count from users as U, chatmessages as F where ( F.from_id = $user_id and F.to_id = U.id) or (F.to_id = $user_id and F.from_id = U.id) group by U.id order by F.id desc")->fetchAll('assoc');

        //echo "<pre>"; print_r($all_users); exit;

        $messages = array();

        foreach ($all_users as $user) {
            //print_r($message);
            $msg = $conn->execute("select message, image, date_time from chatmessages where from_id =".$user['id']." or to_id=".$user['id']." order by id desc limit 0,1")->fetchAll('assoc');

            // if($msg[0]['image'] != "")
            //   $message = 'Image';
            // else 
            //   $message = base64_decode($msg[0]['message']);

            $full_name = $user['first_name']." ".$user['last_name'];

            $messages[] = array('id' => $user['id'], 'pimg' => $user['pimg'], 'full_name' => $full_name,'business_name' => $user['business_name'], 'message' => $message, 'date_time' => $msg[0]['date_time'], 'read_count' => $user['read_count']);
        }

        foreach ($messages as $key => $row) {
            $dates[$key]  = $row['date_time'];
        }

        array_multisort($dates, SORT_DESC, $messages);

        //echo "<pre>"; print_r($messages); exit;

        $this->set(compact('messages'));
        $this->set('_serialize', ['messages']);

    }

    public function footerusermessage(){

        $this->viewBuilder()->layout(false);
        $this->loadModel('Users');
        $this->loadModel('Chatmessages');

        $userid = $this->request->session()->read('Auth.User.id');
        $friend_id = $this->request->data['friend_id']; 
         
        $user_details = $this->Users->find()->where(['id'=>$friend_id])->first();

        //echo "<pre>";print_r($user_details); exit;

        if($user_details['business_name']==""){
            $friend_name = $user_details['first_name']." ".$user_details['last_name'];
        }else{
            $friend_name = $user_details['business_name'];  
        }

        $conn = ConnectionManager::get('default');  
        $conn->execute("UPDATE `chatmessages` SET `is_read`= 'Y' WHERE `to_id` = '".$userid."' and `from_id` = '".$friend_id."'");

        $all_messages = $conn->execute("select U.id as uid, U.first_name, U.last_name, U.pimg, M.id, M.date_time, M.message,M.image from users as U, chatmessages as M where (M.from_id =".$userid." and M.to_id = ".$friend_id." and M.from_id=U.id) or (M.to_id =".$userid." and M.from_id = ".$friend_id." and M.from_id=U.id) order by M.id desc limit 0,20")->fetchAll('assoc');
        $message = "";

        if($all_messages && count($all_messages) > 0){
            $all_messages = array_reverse($all_messages);
            foreach($all_messages as $all_message):

                $last_message_id = $all_message['id'];
                $curr_time = date('Y:m:d H:i:s');
                $diff_time = (strtotime($curr_time)-strtotime($all_message['date_time']));
                $hurs = intval($diff_time/(60*60));
                $mins = intval($diff_time/60);

                if($all_message['uid'] == $userid) {                    

        $message .='<div class="msg_a w-100 float-left mb-2 mr-0">
                    <div class="msg-img-box rounded-circle d-inline-block mr-1">
                      <img class="rounded-circle img-fluid" src="'.$this->request->webroot.'user_img/'.(($all_message['pimg'] == "")? "default.png" : 'thumb_'.$all_message['pimg']).'" alt="">          
                    </div>
                   ';
                      if($all_message['message']){
                   $message .='
                    <div class="msg-txt-box d-inline-block p-relative">
                      <p class="mb-0 font-13 text-dark">'.base64_decode($all_message['message']).'</p>
                    </div>';
                  }
                      if($all_message['image']){
                    $message .='<div class="msg-txt-box d-inline-block p-relative">
                      <img src="'.$this->request->webroot.'chat_image/'.$all_message['image'].'"  class="img-fluid">
                    </div>';
                  }
                    $message .='
                    <div class="msg-datetim-box float-right w-25 text-right">
                      <span class="text-muted font-12">'.$all_message['date_time'].'</span>
                    </div>
                  </div>';      
                }
                else
                {
                    //$message .= '<div class="msg_b">'.$all_message['message'].'</div>';

        $message .= '<div class="msg_b w-100 float-left mb-2 mr-0">
                    <div class="msg-datetim-box float-left w-25 text-left">
                      <span class="text-muted font-12">'.$all_message['date_time'].'</span>
                    </div>  
                    ';
                      if($all_message['message']){
                   $message .='
                    <div class="msg-txt-box d-inline-block p-relative">
                      <p class="mb-0 font-13 text-dark">'.base64_decode($all_message['message']).'</p>
                    </div>';
                  }
                      if($all_message['image']){
                    $message .='<div class="msg-txt-box d-inline-block p-relative">
                      <img src="'.$this->request->webroot.'chat_image/'.$all_message['image'].'" class="img-fluid">
                    </div>';
                  }
                    $message .='
                    <div class="msg-img-box rounded-circle d-inline-block mr-1">
                      <img class="rounded-circle img-fluid" src="'.$this->request->webroot.'user_img/'.(($all_message['pimg'] == "")? "default.png" : 'thumb_'.$all_message['pimg']).'" alt="">          
                    </div>
                  </div>';
                }
            
            endforeach;
        }
        else
        {
            $last_message_id = "";
        }
        $message.='<div class="msg_push"></div>';
          echo $last_message_id.'||'.$friend_name.'||'.$message;
        exit();
    }

    public function latestMessagefooter() {
        
        $this->viewBuilder()->layout(false);
        $this->loadModel('Users');
        $this->loadModel('Chatmessages');

        $userid = $this->request->session()->read('Auth.User.id');               
        $friend_id = $this->request->data['friend_id'];
        $lmessage_id = $this->request->data['last_message_id'];
                 
                
        $all_messages=array();
        if($lmessage_id != ''){ 
            $conn = ConnectionManager::get('default');

            $all_messages = $conn->execute("select U.id as uid, U.first_name, U.last_name, U.pimg, M.id, M.date_time, M.message, M.image from users as U, chatmessages as M where (M.from_id =".$userid." and M.to_id = ".$friend_id." and M.from_id=U.id) or (M.to_id =".$userid." and M.from_id = ".$friend_id." and M.from_id=U.id) having M.id > ".$lmessage_id." order by M.id desc")->fetchAll('assoc');
        }

        $message = "";
        if($all_messages && count($all_messages) > 0){
            $all_messages = array_reverse($all_messages);
            foreach($all_messages as $all_message){
                $lmessage_id = $all_message['id'];
                $curr_time = date('Y:m:d H:i:s');
                 $diff_time = (strtotime($curr_time)-strtotime($all_message['date_time']));
                $hurs = intval($diff_time/(60*60));
                 $mins = intval($diff_time/60);
                 if($all_message['uid'] == $userid) {
                 $lmessage_id = $all_message['id'];
                    $message .= '<div class="msg_a w-100 float-left mb-2 mr-0">
                        <div class="msg-img-box rounded-circle d-inline-block mr-1">
                          <img class="rounded-circle img-fluid" src="'.$this->request->webroot.'user_img/'.(($all_message['pimg'] == "")? "default.png" : 'thumb_'.$all_message['pimg']).'" alt="">          
                        </div>';
                          if($all_message['message']){
                       $message .='
                        <div class="msg-txt-box d-inline-block p-relative">
                          <p class="mb-0 font-13 text-dark">'.base64_decode($all_message['message']).'</p>
                        </div>';
                      }
                          if($all_message['image']){
                        $message .='<div class="msg-txt-box d-inline-block p-relative">
                          <img src="'.$this->request->webroot.'chat_image/'.$all_message['image'].'" class="img-fluid">
                        </div>';
                      }
                        $message .='
                        <div class="msg-datetim-box float-right w-25 text-right">
                          <span class="text-muted font-12">'.$all_message['date_time'].'</span>
                        </div>
                      </div>';      
                }
                else
                {
                    $message .= '<div class="msg_b w-100 float-left mb-2 mr-0">
                        <div class="msg-datetim-box float-left w-25 text-left">
                          <span class="text-muted font-12">'.$all_message['date_time'].'</span>
                        </div>  
                       ';
                          if($all_message['message']){
                        $message .='
                        <div class="msg-txt-box d-inline-block p-relative">
                          <p class="mb-0 font-13 text-dark">'.base64_decode($all_message['message']).'</p>
                        </div>';
                      }
                          if($all_message['image']){
                        $message .='<div class="msg-txt-box d-inline-block p-relative">
                          <img src="'.$this->request->webroot.'chat_image/'.$all_message['image'].'"  class="img-fluid">
                        </div>';
                      }
                      $message .='
                        <div class="msg-img-box rounded-circle d-inline-block mr-1">
                          <img class="rounded-circle img-fluid" src="'.$this->request->webroot.'user_img/'.(($all_message['pimg'] == "")? "default.png" : 'thumb_'.$all_message['pimg']).'" alt="">          
                        </div>
                      </div>';
                }
            
                        }
            $message.='<div class="msg_push"></div>';
        }
        
            echo $lmessage_id.'||'.$message;
      exit();
    }

    public function latestMessagefootercount() {
      
        $this->autoRender = false;
        $this->loadModel('Chatmessages');

        $userid = $this->request->session()->read('Auth.User.id');
             
        $msgcount = $this->Chatmessages->find()->where(['Chatmessages.to_id' => $userid,'Chatmessages.is_read' => 'N'])->toArray();
        
        if($msgcount){
            echo count($msgcount);
        }
        
        exit();
    }

   
    
    
    
}
