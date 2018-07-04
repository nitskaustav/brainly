<?php
namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\Auth\DefaultPasswordHasher;
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['token','register','forgotpassword','updateuser_service','listtechnician','updateimage_service','emailcheck','edituserprofile','changepassword']);
        $this->loadComponent('RequestHandler');
    }
    
    public function add()
    {
        $this->Crud->on('afterSave', function(Event $event) {
            if ($event->subject->created) {
                $this->set('data', [
                    'id' => $event->subject->entity->id,
                    'token' => JWT::encode(
                        [
                            'sub' => $event->subject->entity->id,
                            'exp' =>  time() + 604800
                        ],
                    Security::salt())
                ]);
                $this->Crud->action()->config('serialize.data', 'data');
            }
        });
        return $this->Crud->execute();
    }
    
    public function token()
    {
        //pr($this->request->data);
        //exit;
        $user = $this->Auth->identify();
        if (!$user) {
            $rarray = array('ack' => 0, );
            $this->set([
                'ack' => 0,
                'message' => 'Inavlid email or password.',
                '_serialize' => ['ack', 'message']
            ]);
        }
        else
        {
            if(empty($user['profile_image']))
            {
                $user['profile_image'] = 'default.png';
            }
            $user['image_url'] = Router::url('/', true).'user_img/';
            $user['token'] = JWT::encode([
                        'sub' => $user['id'],
                        'exp' =>  time() + 604800
                    ],
                    Security::salt());
            $this->set([
                'ack' => 1,
                'details' => $user,
                '_serialize' => ['ack', 'data','details']
            ]);
        }
    }
    
    public function emailcheck()
    {

        if ($this->request->is('post')) {
             //$tableRegObj = TableRegistry::get('Users');
            $userExist = $this->Users
                            ->find()
                            ->where(['email' => $this->request->data['email']])->toArray();
            if(!empty($userExist))
            {
                $rarray = array('ack' => 1,'message' => 'Email already exist.');
            }
            else
            {
                $rarray = array('ack' => 0,'message' => 'Email not exist.');
            }
        }
        //print_r($rarray);exit;
        $this->set([
                'details' => $rarray,
                '_serialize' => ['details']
            ]);
        
    }
    public function register()
    {
        $user = $this->Users->newEntity();

        //if ($this->request->is('post')) {
             //$tableRegObj = TableRegistry::get('Users');
        unset($this->request->data['con_password']);
        //print_r($this->request->data);exit;
            $userExist = $this->Users
                            ->find()
                            ->where(['email' => $this->request->data['email']])->toArray();
            if(!empty($userExist))
            {
                $rarray = array('ack' => 0,'message' => 'Email already exist.');
            }
            else
            {
                $themail = $this->request->data['email'];
                $this->request->data['created'] = gmdate("Y-m-d h:i:s");
                $this->request->data['modified'] = gmdate("Y-m-d h:i:s");
               // print_r($this->request->data);exit;
                $user = $this->Users->patchEntity($user, $this->request->data);
                $rs = $this->Users->save($user);
                //print_r($rs);exit;
                if ($rs = $this->Users->save($user)) {
                    //$unique_id = rand(1000,9999);
                    //$unique_id = $unique_id . $rs->id;

                    $subquestion = TableRegistry::get('Users');
                    $query = $subquestion->query();
                    //$query->update()->set(['unique_id' => $unique_id])->where(['id' => $rs->id])->execute();



                    $etRegObj = TableRegistry::get('EmailTemplates');
                    $emailTemp = $etRegObj->find()->where(['id' => 2])->first()->toArray();

                    $chkPost = base64_encode($rs->id . "/" . $themail);
                    $mail_To = $themail;
                    //$mail_CC = '';
                    $mail_subject = $emailTemp['subject'];
                    $url = Router::url('/', true);
                    $link = $url . 'users/activeaccount/' . $chkPost;

                    $mail_body = str_replace(array('[NAME]', '[LINK]'), array($this->request->data['first_name'], $link), $emailTemp['content']);
                    //echo $mail_body; //exit;

                    //Sending user email validation link
                    $email = new Email('default');
                    $email->emailFormat('html')
                            ->to($mail_To)
                            ->subject($mail_subject)
                            ->send($mail_body);
                    $rarray = array('ack' => 1,'message' => 'Please check your mail for verification link.');
                }
                else {
                    $rarray = array('ack' => 0, 'message' => 'Internal error. Please try again later.','error' => $rs);
                }
                
            }

            $this->set([
                'details' => $rarray,
                '_serialize' => ['details']
            ]);
        //}
    }
    
    public function forgotpassword()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            
            // Checking if User is valid or not.
            $tableRegObj = TableRegistry::get('Users');
            $userExist = $tableRegObj->find()->where(['email' => $this->request->data['email']])->first();

            $etRegObj = TableRegistry::get('EmailTemplates');
            $emailTemp = $etRegObj->find()->where(['id' => 1])->first()->toArray();

           
            if (!empty($userExist)) {
                $chkPost = rand(1000,9999); //Generating new Password

//                $userdt = TableRegistry::get('Users');
//                $query = $userdt->query();
//                $this->Users->save();
                $userExist->password = $chkPost;
                $this->Users->save($userExist);
                //$query->update()->set(['password' => $chkPost])->where(['id' => $userExist['id']])->execute();

                $mail_To = $userExist->email;
                $mail_CC = '';
                $mail_subject = $emailTemp['subject'];
                $name = $userExist->first_name;
                $url = Router::url('/', true);
                $link = $url . 'users/setpassword/' . $chkPost;

                $mail_body = str_replace(array('[NAME]', '[PASSWORD]'), array($name, $chkPost), $emailTemp['content']);
                //echo $mail_body; //exit;
                
                // Sending user the reset password link.
                $email = new Email('default');
                if ($email->emailFormat('html')
                                ->to($userExist->email)
                                ->subject($mail_subject)
                                ->send($mail_body)) {
                    
                    $this->set([
                        'ack' => 1,
                        'message' => 'Please check your email for new password.',
                        '_serialize' => ['ack', 'message']
                    ]);
                } else {
                    $this->set([
                        'ack' => 0,
                        'message' => 'Ineternal error. Please try again later.',
                        '_serialize' => ['ack', 'message']
                    ]);
                }
            } else {
                $this->set([
                    'ack' => 0,
                    'message' => 'Email Not Registerd With Us, try with another.',
                    '_serialize' => ['ack', 'message']
                ]);
            }
        }
    }
    
    public function details()
    {
        if($this->request->is('post'))
        {
            $user_details = $this->Users->find()->where(['Users.id' => $this->request->data['user_id']])->first();
            if(!empty($user_details))
            {
                if(empty($user_details['profile_image']))
                {
                    $user_details['profile_image'] = 'default.png';
                }
                $user_details['image_url'] = Router::url('/', true).'user_img/';
                $this->set([
                    'ack' => 1,
                    'details' => $user_details,
                    '_serialize' => ['details','ack']
                ]);
            }
            else
            {
                $this->set([
                    'ack' => 0,
                    'message' => 'User not found',
                    '_serialize' => ['ack','message']
                ]);
            }
        }
    }
    
    public function updateuser_service()
    {
        if($this->request->is('post'))
        {
            if(!empty($this->request->data['pass']))
            {
                $this->request->data['password'] = $this->request->data['pass'];
            }
            else {
                unset($this->request->data['password']);
            }
            $users = $this->Users->get($this->request->data['id']);
            $users = $this->Users->patchEntity($users, $this->request->data);
            $users->modified = date("Y-m-d H:i:s");
            if($this->Users->save($users))
            {
                $this->set([
                    'ack' => 1,
                    'message' => 'Profile updated successfully.',
                    '_serialize' => ['message','ack']
                ]);
            }
            else
            {
                $this->set([
                    'ack' => 0,
                    'message' => 'Internal error. Please try again later.',
                    '_serialize' => ['ack','message']
                ]);
            }
        }
    }
    
    public function updateimage_service(){
        if(!empty($_FILES))
        {
            $this->loadModel('Users');
            $rarray = array();
            $ext = explode('/', $_FILES['photo']['type']);
            if ($ext) {
                $uploadFolder = "user_img";
                $uploadPath = WWW_ROOT . $uploadFolder;
                $extensionValid = array('jpg', 'jpeg', 'png', 'gif');
                if (in_array($ext[1], $extensionValid)) {

                   
                    $imageName = $_POST['user_id'] . '_' . (strtolower(trim($_FILES['photo']['name'])));
                    $full_image_path = $uploadPath . '/' . $imageName;
                    move_uploaded_file($_FILES['photo']['tmp_name'], $full_image_path);
                    $User_data['profile_image'] = $imageName;
                    $User_data['id'] = $_POST['user_id'];
                    $user = $this->Users->get($this->request->data['user_id']);
                    $crowns = $this->Users->patchEntity($user, $User_data);
                    //if($crown_fabric = $this->Crownfabrications->save($crowns))
                    /**/
                    //unlink($uploadPath. '/' .$this->request->data['User']['hidprofile_img']);
                   
                    if($this->Users->save($crowns))
                    {
                        //$rarray = array('ack' => 1,'message' => 'Profile picture updated successfully.');
                        $this->set([
                            'ack' => 1,
                            'message' => 'Profile picture updated successfully.',
                            '_serialize' => ['message','ack']
                        ]);
                    }
                    else
                    {
                        $this->set([
                            'ack' => 0,
                            'message' => 'Not enough permission to upload.',
                            '_serialize' => ['message','ack']
                        ]);
                    }                   
                } else {
                    $this->set([
                            'ack' => 0,
                            'message' => 'Please upload image of .jpg, .jpeg, .png or .gif format.',
                            '_serialize' => ['message','ack']
                    ]);
                }
            }
            else {
                //$rarray = array('ack' => 0, 'message' => 'Internal error. Please try again later');
                    $this->set([
                            'ack' => 0,
                            'message' => 'Internal error. Please try again later',
                            '_serialize' => ['message','ack']
                    ]);
            }
           
        }
    }
    
    public function listtechnician( ) {
        $this->loadModel('Users');        
        $users = $this->Users->find('all')->where(['Users.utype' => 3,'Users.is_active' => 1]);
        $this->set([
                    'ack' => 1,
                    'technicians' => $users,
                    '_serialize' => ['technicians','ack']
                ]);

    }

    public function edituserprofile(){

        $this->loadModel('Users');

        $user = $this->Users->get($this->request->data['user_id']);

        $this->request->data['modified'] = gmdate("Y-m-d h:i:s");

        $user = $this->Users->patchEntity($user, $this->request->data);

        if ($this->Users->save($user)){
            $this->set([
                    'Ack' => 1,
                    '_serialize' => ['Ack']
                ]);
        }
        else{
            $this->set([
                    'Ack' => 0,
                    '_serialize' => ['Ack']
                ]);
        }
    }

    public function changepassword(){

        $this->loadModel('Users');

        $user = $this->Users->get($this->request->data['user_id']);

        $existing_password = $user->password;

        $current_password = $this->request->data['current_password'];
        $new_password = $this->request->data['new_password'];
        $con_password = $this->request->data['con_password'];

        $hasher = new DefaultPasswordHasher();

        //$old_hashpass = $hasher->hash($old_password);

        //$return_data = $hasher->check($current_password, $existing_password);

        if($hasher->check($current_password, $existing_password)){

            if($new_password == $con_password){

                $update_password['password'] = $new_password;
                $user = $this->Users->patchEntity($user, $update_password);
                if ($this->Users->save($user)){
                    $this->set([
                            'Ack' => 1,
                            'message' => 'Password changed successfully',
                            '_serialize' => ['Ack','message']
                        ]);
                }
                else{
                    $this->set([
                            'Ack' => 1,
                            'message' => 'Error changing password. Please try again later',
                            '_serialize' => ['Ack','message']
                        ]);

                }

            }
            else{
                $this->set([
                    'Ack' => 0,
                    'message' => 'New password and confirm password mismatch',
                    '_serialize' => ['Ack','message']
                ]);
            }

        }
        elseif($return_data == ''){
            $this->set([
                    'Ack' => 0,
                    'message' => 'Current password wrong',
                    '_serialize' => ['Ack','message']
                ]);
        }
    }
}