<?php

namespace App\Controller\Api;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Mailer\Email;


class CrownfabricationsController extends AppController {

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['list_service','add','uploads','change_brightness','details','update','technicians_list','viewdetails','white_balance']);
        $this->loadComponent('RequestHandler');
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
                        $image = new \Imagick($full_flg_path);
                        $iwidth = $image->getImageWidth();
                        $swidth = $this->request->data['screenwidth'];
                        $ratio = $iwidth/$swidth;
                        $iheight = $image->getImageHeight();
                        $sheight = $iheight/$ratio;
                        //var_dump($result);
                        $this->set([
                            'ack' => 1,
                            'message' => 'Image uploaded successfully.',
                            'filename' => $filename,
                            'result' => $result,
                            'height' => (int)$sheight,
                            'width'  => (int)$swidth,
                            'url' => Router::url('/', true).$uploadFolder.'/'.$filename,
                            '_serialize' => ['ack', 'message','filename','url','result','height','width']
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
    
    public function white_balance()
    {
        if($this->request->is('post'))
        {
            $uploadFolder = "crownimg/";
            $uploadPath = WWW_ROOT;	
            $source_file = $uploadPath.$uploadFolder.$this->request->data['image'];
            $dest_name = 'conv_'.$this->request->data['image'];
            $destination_file = $uploadPath.$uploadFolder.$dest_name;
//            $crop_cmd = $source_file.' -crop "130x70+25+25" '.$uploadPath.$uploadFolder.'crop_'.$this->request->data['image'].' 2>&1';
//            exec($crop_cmd,$out);
//            echo $crop_cmd;
//            var_dump($out);
//            exit;
            if(!empty($this->request->data['pointer']))
            {
                $pointer = (array)json_decode($this->request->data['pointer']);
                $iheight = $this->request->data['height'];
                $iwidth = $this->request->data['width'];
                $card_img = $uploadPath.$uploadFolder."card_".$this->request->data['image'];
                $imgsource = new \Imagick($source_file);
                $imgsource->resizeImage($iwidth,$iheight,\Imagick::FILTER_LANCZOS,1);
                $imgsource->cropImage(4, 4, $pointer['left']-2, $pointer['top']-2);
                $imgsource->writeImage($card_img);
                //exec('convert '.$card_img.' +repage -format "%[fx:mean]" info:',$grey_output);
              
//                if(empty($grey_output))
//                {
//                    $grey_color = $grey_output['0'];
//                }
//                else
//                {
//                    $grey_color = 0.5;
//                }
//                $command = 'infile="'.$source_file.'"';
//                $command .= '&& gray='.$grey_color;
//                $command .= '&& declare `convert "$infile" '.$card_img.' +repage -format "rratio=%[fx:$gray/mean.r]\ngratio=%[fx:$gray/mean.g]\nbratio=%[fx:$gray/mean.b]\n" info:`';
//                //$command .= '&& echo "$rratio $gratio $bratio"';
//                $command .= '&& convert "$infile" -color-matrix "$rratio 0 0 0 $gratio 0 0 0 $brati" '.$destination_file.' 2>&1';
//                exec('infile="'.$source_file.'" && gray='.$grey_color.' && declare `convert "$infile" '.$card_img.' +repage -format "rratio=%[fx:$gray/mean.r]\ngratio=%[fx:$gray/mean.g]\nbratio=%[fx:$gray/mean.b]\n" info:`');
//                exec('echo "$rratio $gratio $bratio"',$res);
//                var_dump($res);
//                exit;
//                exec('convert "$infile" -color-matrix "$rratio 0 0 0 $gratio 0 0 0 $bratio" '.$destination_file);
//                exec($command,$output);
                //var_dump($output);
                //exit;
                $query = 'convert '.$source_file.' \( +clone \( '.$card_img.' -gravity Center -crop "2x2+2+2" -scale "1x1" -negate \) +dither -interpolate Integer -clut \) -compose Overlay -composite '.$destination_file.' 2>&1';
                //exec($command,$output);
            }
            else
            {
                $query = 'convert '.$source_file.' \( +clone \( /var/www/html/bikash/PerfectShade/webroot/test/1.jpeg -gravity Center -crop "10x10+4+4" -scale "1x1" -negate \) +dither -interpolate Integer -clut \) -compose Overlay -composite '.$destination_file.' 2>&1';
                //exec($query,$output);
            }
            //exec('convert /var/www/html/bikash/PerfectShade/webroot/crownimg/597eff7d90727.jpg \( +clone \( /var/www/html/bikash/PerfectShade/webroot/test/2.jpeg -gravity Center -crop "10x10+4+4" -scale "1x1" -negate \) +dither -interpolate Integer -clut \) -compose Overlay -composite /var/www/html/bikash/PerfectShade/webroot/crownimg/conv_597eff7d90727.jpg',$output);
            exec($query,$output);
            //print_r($this->request->data);
//            var_dump($output);
//            echo $query;
//            exit;
            
//            $imagick = new \Imagick($destination_file);
//            $imagick->modulateImage(130,100,100);
//            $imagick->writeImage($destination_file);
            $this->set([
                'ack' => 1,
                'message' => 'Image uploaded successfully.',
                //'filename' => $filename,
                'result' => $output,
                'details' => [
                'ind' => $this->request->data['ind'],
                'image' => $dest_name,
                'url' => Router::url('/', true).$uploadFolder.$dest_name."?".time()],
                '_serialize' => ['ack', 'message','details','result']
            ]);
        }
    }
}