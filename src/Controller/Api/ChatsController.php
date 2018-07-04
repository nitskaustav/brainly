<?php

namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Mailer\Email;


class ChatsController extends AppController {

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['message_chat_service','chatnoti_service']);
        $this->loadComponent('RequestHandler');
    }
    
    
    public function message_chat_service()
    {
        if($this->request->is('post'))
        {
            $this->loadModel('Chats');
            $this->loadModel('Users');
            $receiver_id = $this->request->data('receiver_id');
            $userid = $this->request->data('user_id');
            
//            $chats = $conn->execute("SELECT * FROM chats as Chat where (Chat.sender_id=$userid and Chat.receiver_id=$receiver_id) or (Chat.sender_id=$receiver_id and Chat.receiver_id=$userid)");
            $chats = $this->Chats->find('all')->where(["OR" => [["Chats.sender_id" => $userid,"Chats.receiver_id" => $receiver_id],["Chats.sender_id" => $receiver_id, "Chats.receiver_id" => $userid]]]);
//            $all_chats = $chats ->fetchAll('assoc');
//            $s = $this->Chat->updateAll(array('Chat.is_read' => 1), array( 'Chat.receiver_id' => $userid));
            $receiver = $this->Users->find()->where(['Users.id' => $receiver_id])->first();
            if(!empty($receiver))
            {
                $receiver['image_url'] = Router::url('/', true).'user_img/';
            }
//            $result = array('ack' => 1, 'chats' => $chats, 'server_url' => Router::url('/', true),'receiver' => $receiver);
//            echo json_encode($result);
//            exit;
             $this->set([
                        'ack' => 1,
                        'chats' => $chats,
                        'server_url' => Router::url('/', true),
                        'receiver' => $receiver,
                        '_serialize' => ['ack', 'chats','server_url','receiver']
                    ]);
        }
    }
    
    public function chatnoti_service(){
        $this->loadModel('Chats');
        $this->loadModel('Users');
        $user_id = $this->request->data['user_id'];
        //$comment_chats = $this->Chat->Query("SELECT * FROM chats as Chat where Chat.receiver_id = $user_id or Chat.sender_id = $user_id group by Chat.sender_id,Chat.receiver_id order by Chat.id DESC");
        $comment_chats = $this->Chats->find('all')->where(["OR" => ["Chats.receiver_id" => $user_id,"Chats.sender_id" => $user_id]])->group("Chats.sender_id","Chats.receiver_id")->order(['Chats.id' => 'DESC'])->contain(['sender','receiver']);
//        
        if(!empty($comment_chats))
        {
            $other_ids = array();
            foreach($comment_chats as $ind => $cmnt_chat)
            {

                if($cmnt_chat['sender_id']==$user_id)
                {
                    //$comment_chats[$ind]['sender'] = $comment_chats[$ind]['receiver'];
                    if(in_array($cmnt_chat['receiver_id'],$other_ids))
                    {
                        unset($comment_chats[$ind]);
                    }
                    $other_ids[] = $cmnt_chat['receiver_id'];
                }
                else
                {
                    if(in_array($cmnt_chat['sender_id'],$other_ids))
                    {
                        unset($comment_chats[$ind]);
                    }
                    $other_ids[] = $cmnt_chat['sender_id'];
                    
                }

            }
        }
        
        if(!empty($comment_chats))
        {
             $this->set([
                        'ack' => 1,
                        'details' => $comment_chats,
                        'img_url' => Router::url('/', true).'user_img/',
                        '_serialize' => ['ack', 'details','img_url']
                    ]);
        }
        else
        {
            $this->set([
                        'ack' => 0,
                        'message' => 'No notification found.',
                        '_serialize' => ['ack', 'message']
                    ]);
        }        
       
    }
    
    
    
    public function list_service() {
        //$this->viewBuilder()->layout('admin');
        $this->loadModel('Crownfabrications');
        
        if($this->request->is('post'))
        {
            $fabrications = $this->Crownfabrications->find('all',['order' => ['Crownfabrications.id DESC']])->where(['Crownfabrications.doctor_id' => $this->request->data['user_id']])->contain(['Users','Crownfabricimages','Patient']);
            $this->set([
                'ack' => 1,
                'details' => $fabrications,
                'image_url' =>  Router::url('/', true).'crownimg/',
                '_serialize' => ['ack','details','image_url']
            ]);
        }
    }
    
    public function technicians_list() {
        //$this->viewBuilder()->layout('admin');
        $this->loadModel('Crownfabrications');
        
        if($this->request->is('post'))
        {
            $fabrications = $this->Crownfabrications->find('all',['order' => ['Crownfabrications.id DESC']])->where(['Crownfabrications.technician_id' => $this->request->data['user_id']])->contain(['Users','Crownfabricimages','Patient']);
            $this->set([
                'ack' => 1,
                'details' => $fabrications,
                'image_url' =>  Router::url('/', true).'crownimg/',
                '_serialize' => ['ack','details','image_url']
            ]);
        }
    }
    
    public function details()
    {
        $this->loadModel('Crownfabrications');
        $this->loadModel('Users');
        if($this->request->is('post'))
        {
            $id= $this->request->data['id'];
            $fabrication = $this->Crownfabrications->find()
                                ->where(['Crownfabrications.id' => $id])
                                ->contain(['Crownfabricimages'])->first();
            if(!empty($fabrication))
            {
                $images = array();
                
                $users = $this->Users->find()->where(['Users.id' => $fabrication['user_id']])->first();
                $fabrication['name'] = $users['first_name'].' '.$users['last_name'];

                if(!empty($fabrication['Crownfabricimages']))
                {
                   $fabrication['Crownfabricimages'] = array_map(function($i){
                       $i['url'] = Router::url('/', true).'crownimg/'.$i['image'];
                       return $i;
                   },$fabrication['Crownfabricimages']);
                }

                $images = $fabrication['Crownfabricimages'];
                unset($fabrication['Crownfabricimages']);
                
                $this->set([
                    'ack' => 1,
                    'details' => $fabrication,
                    'images' => $images,
                    'image_url' =>  Router::url('/', true).'crownimg/',
                    '_serialize' => ['ack','details','image_url','images']
                ]);
            }
            else
            {
                $this->set([
                        'ack' => 0,
                        'message' => 'Crown could not be found.',
                        '_serialize' => ['ack', 'message']
                    ]);
            }
        }
    }
    
    public function viewdetails()
    {
        $this->loadModel('Crownfabrications');
        $this->loadModel('Users');
        if($this->request->is('post'))
        {
            $id= $this->request->data['id'];
            $fabrication = $this->Crownfabrications->find()
                                ->where(['Crownfabrications.id' => $id])
                                ->contain(['Crownfabricimages','Users'])->first();
            if(!empty($fabrication))
            {
                $images = array();
                
                $users = $this->Users->find()->where(['Users.id' => $fabrication['user_id']])->first();
                $fabrication['name'] = $users['first_name'].' '.$users['last_name'];

                if(!empty($fabrication['Crownfabricimages']))
                {
                   $fabrication['Crownfabricimages'] = array_map(function($i){
                       $i['url'] = Router::url('/', true).'crownimg/'.$i['image'];
                       return $i;
                   },$fabrication['Crownfabricimages']);
                }

                $images = $fabrication['Crownfabricimages'];
                unset($fabrication['Crownfabricimages']);
                $fabrication['user_images'] = Router::url('/', true).'user_img/';
                $this->set([
                    'ack' => 1,
                    'details' => $fabrication,
                    'images' => $images,
                    'image_url' =>  Router::url('/', true).'crownimg/',
                    '_serialize' => ['ack','details','image_url','images']
                ]);
            }
            else
            {
                $this->set([
                        'ack' => 0,
                        'message' => 'Crown could not be found.',
                        '_serialize' => ['ack', 'message']
                    ]);
            }
        }
    }

    public function update()
    {
        $this->loadModel('Crownfabrications');
        $this->loadModel('Users');
        
        

        if ($this->request->is('post')) {
            $this->request->data['created'] = gmdate("Y-m-d h:i:s");
            $this->request->data['modified'] = gmdate("Y-m-d h:i:s"); 
            $name = $this->request->data['name'];
            $name = explode(" ", $name);
            $this->request->data['first_name'] = (!empty($name['0'])?$name['0']:'');
            $this->request->data['last_name'] = (!empty($name['1'])?$name['1']:'');
            $product_id = $this->request->data['id'];
            $this->request->data['id'] = $this->request->data['user_id'];
            $user = $this->Users->get($this->request->data['id']);
           
            $users = $this->Users->patchEntity($user, $this->request->data);
             if ($result=$this->Users->save($users)) {
                $last_user_id=$result->id;
                //$this->request->data['user_id'] = $last_user_id; 
                $this->request->data['id'] = $product_id;
                $crown = $this->Crownfabrications->get($this->request->data['id']);
                $crowns = $this->Crownfabrications->patchEntity($crown, $this->request->data);
                if($crown_fabric = $this->Crownfabrications->save($crowns))
                {
                    $crown_fabric_id = $this->request->data['id'];
                    $images = json_decode($this->request->data['images']);
                    
                    $this->loadModel('Crownfabricimages');
                    $this->Crownfabricimages->deleteAll(['Crownfabricimages.crown_id' => $crown_fabric_id]);
                    foreach($images as $img)
                    {
                        $img->crown_id = $crown_fabric_id;
                        $crownimage = $this->Crownfabricimages->newEntity();
                        $cimage = $this->Crownfabricimages->patchEntity($crownimage,(array)$img);
                        $this->Crownfabricimages->save($cimage);
                    }
                    $this->set([
                        'ack' => 1,
                        'message' => 'The Crown Fabrication has been saved.',
                        '_serialize' => ['ack', 'message']
                    ]);
                }
                else
                {
                    $this->set([
                        'ack' => 0,
                        'message' => 'Crown could not be saved. Please try again later.',
                        '_serialize' => ['ack', 'message']
                    ]);
                }
            } else {
                $this->set([
                        'ack' => 0,
                        'message' => 'Users could not be saved. Please try again later.',
                        '_serialize' => ['ack', 'message']
                ]);
            }
        }
        else
        {
            $this->set([
                'ack' => 0,
                'message' => 'Internal error. Please try again later.',
                '_serialize' => ['ack', 'message']
            ]);
        }
    }
    
    public function add()
    {
        $this->loadModel('Crownfabrications');
        $this->loadModel('Users');
        $crown = $this->Crownfabrications->newEntity();
        $user = $this->Users->newEntity();

        if ($this->request->is('post')) {
            $this->request->data['created'] = gmdate("Y-m-d h:i:s");
            $this->request->data['modified'] = gmdate("Y-m-d h:i:s"); 
            $name = $this->request->data['name'];
            $name = explode(" ", $name);
            $this->request->data['first_name'] = (!empty($name['0'])?$name['0']:'');
            $this->request->data['last_name'] = (!empty($name['1'])?$name['1']:'');
            
           
                
            $users = $this->Users->patchEntity($user, $this->request->data);
             if ($result=$this->Users->save($users)) {
                $last_user_id=$result->id;
                $this->request->data['user_id'] = $last_user_id; 
                $crowns = $this->Crownfabrications->patchEntity($crown, $this->request->data);
                if($crown_fabric = $this->Crownfabrications->save($crowns))
                {
                    $crown_fabric_id = $crown_fabric->id;
                    $images = json_decode($this->request->data['images']);
                    //var_dump($images);
                    $this->loadModel('Crownfabricimages');
                    foreach($images as $img)
                    {
                        $img->crown_id = $crown_fabric_id;
                        $crownimage = $this->Crownfabricimages->newEntity();
                        $cimage = $this->Crownfabricimages->patchEntity($crownimage,(array)$img);
                        $this->Crownfabricimages->save($cimage);
                    }
                    $this->set([
                        'ack' => 1,
                        'message' => 'The Crown Fabrication has been saved.',
                        '_serialize' => ['ack', 'message']
                    ]);
                }
                else
                {
                    $this->set([
                        'ack' => 0,
                        'message' => 'Crown could not be saved. Please try again later.',
                        '_serialize' => ['ack', 'message']
                    ]);
                }
            } else {
                $this->set([
                        'ack' => 0,
                        'message' => 'Users could not be saved. Please try again later.',
                        '_serialize' => ['ack', 'message']
                ]);
            }
        }
        else
        {
            $this->set([
                'ack' => 0,
                'message' => 'Internal error. Please try again later.',
                '_serialize' => ['ack', 'message']
            ]);
        }
    }
   
    public function uploads() 
    {
        if ($this->request->is('post')) 
        {
            if(!empty($this->request->data['photoimg']['name'])){
                $pathpart=pathinfo($this->request->data['photoimg']['name']);
                $ext=$pathpart['extension'];
                $extensionValid = array('jpg','jpeg','png','gif');
                if(in_array(strtolower($ext),$extensionValid)){
                    $uploadFolder = "crownimg";
                    $uploadPath = WWW_ROOT . $uploadFolder;	
                    $filename =uniqid().'.'.$ext;
                    $full_flg_path = $uploadPath . '/' . $filename;
                    if(move_uploaded_file($this->request->data['photoimg']['tmp_name'],$full_flg_path))
                    {
                       
                        //var_dump($result);
                        $this->set([
                            'ack' => 1,
                            'message' => 'Image uploaded successfully.',
                            'filename' => $filename,
                            'result' => $result,
                            'url' => Router::url('/', true).$uploadFolder.'/'.$filename,
                            '_serialize' => ['ack', 'message','filename','url','result']
                        ]);
                    }
                    else
                    {
                        $this->set([
                            'ack' => 0,
                            'message' => 'Not enough permission to upload.',
                            '_serialize' => ['ack', 'message']
                        ]);
                    }
                }
                else{
                    $this->set([
                        'ack' => 0,
                        'message' => 'Invalid image type.',
                        '_serialize' => ['ack', 'message']
                    ]);
                }
            }
        }
        
    }
    public function change_brightness()
    {
        $uploadFolder = "crownimg/";
        $uploadPath = WWW_ROOT . $uploadFolder;	
        $full_flg_path = $uploadPath.$this->request->data['name'];
        $mime = getimagesize($full_flg_path);
        if($mime['mime']=='image/png') {
            $src_img = imagecreatefrompng($full_flg_path);
        }
        if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
            $src_img = imagecreatefromjpeg($full_flg_path);
        }   
        $s = imagefilter($src_img,IMG_FILTER_BRIGHTNESS,$this->request->data['bright']);
        //var_dump($s);
        $dest_name = rand(10,1000).$this->request->data['name'];
        $destination = $uploadPath.$dest_name;
         if($mime['mime']=='image/png') {
            $result = imagepng($src_img,$destination);
        }
        if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
            $result = imagejpeg($src_img,$destination);
        }
       
        $this->set([
                'ack' => 1,
                'message' => 'Image uploaded successfully.',
                //'filename' => $filename,
                'result' => $result,
                'url' => Router::url('/', true).$uploadFolder.$dest_name,
                '_serialize' => ['ack', 'message','filename','url','result']
            ]);
    }
    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    
    public function delete($id = null) {
        //$this->request->allowMethod(['post', 'delete']);
        $doctor = $this->Crownfabrications->get($id);
        if ($this->Crownfabrications->delete($doctor)) {
            $this->Flash->success(__('Crownfabrications has been deleted.'));
        } else {
            $this->Flash->error(__('Crownfabrications could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function delete_photo($id = null) {
        //$this->request->allowMethod(['post', 'delete']);
        $this->loadModel("Crownfabricimages");
        $doctor = $this->Crownfabricimages->get($id);
        if ($this->Crownfabricimages->delete($doctor)) {
            echo "1";
        } else {
            echo "0";
        }
        exit;
        
    }
    
    

    public function addresslist($id = null) {
        $this->viewBuilder()->layout('admin');
        //echo $id; exit;
        //$this->loadModel('Addrs'); $addr = $this->Addrs->find()->where(['customer_id' => $id]);
        //$adresses = TableRegistry::get('Adresses'); $adresses->find('all');

        $address = $this->Customers->Addresses->find()->contain(['Runs', 'Customers'])->where(['customer_id' => $id]);


        //$results = $address->toArray(); pr($results); exit;
        $address = $this->paginate($address);
        //$results = $address->toArray();
        //echo $id; pr($results); exit;

        $this->set(compact('address'));
        $this->set('_serialize', ['address']);
    }
    
    /*
     *  Change Admin Status
     */
}