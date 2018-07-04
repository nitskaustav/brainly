<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

use Cake\I18n\FrozenDate;
use Cake\Database\Type; 
use Cake\Routing\Router;

/**
 * Addresses Controller
 *
 * @property \App\Model\Table\AddressesTable $Addresses
 */
class PropertiesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     * 
     */
    
     public function initialize() {
        parent::initialize();
        //$this->Auth->allow(['index', 'view','edit','chstatus','add','delete']); 
    }
    
    public function index()
    {
       $this->loadModel("Categories");  
       $title="Properties"; 
       $uid = $this->Auth->user('id');
       $conditions["Properties.user_id"]=$uid;
       
       if ($this->request->is('get')) 
       {
           
           $filter=array("page");
           foreach ($this->request->query as $key =>$val)
           {    
               if(!in_array($key, $filter))
               {
                    if(!empty($val))
                    {
                         if($key=='zip' or $key=="category_id")
                         {
                            $conditions["Properties.".$key]=$val; 
                         }

                         else
                         {
                            $conditions["Properties.".$key." LIKE "]='%'.$val.'%'; 

                         }
                    }
                    $this->request->data[$key]=$val;
               }
               
               
           }
           
       }
       $options=[
       "limit"=>10,
       "contain"=>"Categories",
        "order" => [
            'Properties.id' => 'desc'
        ],    
       "conditions"=>$conditions    
       ];
       $properties = $this->paginate($this->Properties,$options);
       // $cat=$this->Properties->find("all")->where(["is_active"=>1,'user_id'=>$uid])->toArray();
       // foreach ($cat as $cat)
       // {
       //    $categories[$cat->id]= $cat->address;
       // }
      $categories=$this->Categories->find("list")->where(["is_active"=>1])->toArray();
       $this->set(compact('properties','title','categories'));
       $this->set('_serialize', ['properties','title']); 

    }

    /**
     * View method
     *
     * @param string|null $id Address id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $property = $this->Properties->get($id,['contain'=>"Categories"]);
        //$results = $customer->toArray(); pr($results); exit;

        $this->set('property', $property);
        $this->set('_serialize', ['property']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
      public function add($id = null) {

        //$this->viewBuilder()->layout('admin');
        $this->loadModel("Categories");    
        $property =  $this->Properties->newEntity();
        $title="Add Property";
        $uid = $this->Auth->user('id');
        if ($this->request->is(['patch', 'post', 'put'])) {
            
                      
            $flag = true;
            $slugExist = $this->Properties
                            ->find()
                            ->where(['title' => $this->request->data['title']])->toArray();
            if($this->request->data['title'] == ""){
                $this->Flash->error(__('Name can not be null. Please, try again.')); $flag = false;
            }            
            if($slugExist){
                $this->Flash->error(__('Diplicate Title not allowed. Please, try again.')); $flag = false;
            } 
            if($this->request->data['category_id'] == ""){
                $this->Flash->error(__('Type can not be null. Please, try again.')); $flag = false;
            }   
            
            // if($this->request->data['rentable_unit'] == ""){
            //     $this->Flash->error(__('Rentable Unit can not be null. Please, try again.')); $flag = false;
            // }   
            
            if($this->request->data['address'] == ""){
                $this->Flash->error(__('Address can not be null. Please, try again.')); $flag = false;
            }   
            
            if($this->request->data['city'] == ""){
                $this->Flash->error(__('City can not be null. Please, try again.')); $flag = false;
            }   
            if($this->request->data['state'] == ""){
                $this->Flash->error(__('State can not be null. Please, try again.')); $flag = false;
            }   
            if($this->request->data['zip'] == ""){
                $this->Flash->error(__('ZIP can not be null. Please, try again.')); $flag = false;
            }   
            if($this->request->data['description'] == ""){
                $this->Flash->error(__('Description can not be null. Please, try again.')); $flag = false;
            }   
            
            if($this->request->data['price'] == ""){
                $this->Flash->error(__('Price can not be null. Please, try again.')); $flag = false;
            }  
            
             
            
            if($flag){
                $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
                if (!empty($this->request->data['image']['name'])) {
                   $pathpart=pathinfo($this->request->data['image']['name']);
                   $ext=$pathpart['extension'];
                    
                    if (in_array($ext, $arr_ext)) {
                        
                        $uploadFolder = "prop_images/";
                        $uploadPath = WWW_ROOT . $uploadFolder;
                        $filename =uniqid().'.'.$ext;
                        $full_flg_path = $uploadPath . '/' . $filename;
                        move_uploaded_file($this->request->data['image']['tmp_name'],$full_flg_path);                        
                        $this->request->data['image'] = $filename;
                    } else {
                        $flag = false;
                        $this->Flash->error(__('Upload image only jpg,jpeg,png files.'));
                        
                    }
                }               
            }             
            
            // Address
            $address = $this->request->data["address"];

            // Get JSON results from this request
            $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');

            // Convert the JSON to an array
            $geo = json_decode($geo, true);

            if ($geo['status'] == 'OK') {
              // Get Lat & Long
              $latitude = $geo['results'][0]['geometry']['location']['lat'];
              $longitude = $geo['results'][0]['geometry']['location']['lng'];
              $this->request->data["lat"]=$latitude;
              $this->request->data["lang"]=$longitude;
            }
              $this->request->data["slug"]=$this->create_slug($this->request->data["title"]);
            
            if($flag){
                $this->request->data["unique_id"]= uniqid();
                $this->request->data["user_id"]=$uid;
                $this->request->data["add_date"]= gmdate("Y-m-d H:i:s");
                //print_r($this->request->data); die;
                $property = $this->Properties->patchEntity($property, $this->request->data);
                if ($this->Properties->save($property)) {
                    $this->Flash->success(__('Property detail has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('Property detail could not be update. Please, try again.'));
                }
            }
        } 
        $categories=$this->Categories->find("list")->where(["is_active"=>1])->toArray();
        $this->set(compact('property','categories','title'));
        $this->set('_serialize', ['property','categories','title']);
    } 
    //Export property Details
     public function exportUsers(){

             $uid = $this->Auth->user('id');
             //find()->where(['title' => $this->request->data['title']])->toArray();
            //$events = $this->User->find('all',array('conditions' => array('User.is_paid' => 1)));
            
             $this->loadModel('Properties');
            $events = $this->Properties->find()->where(['user_id' => $uid])->toArray();

            //print_r($events);
            //$this->layout = false;
            $output='';
            $output .='Id,Title,Type,Category,City,Address,Address1,State,Country, Zip,Des,Price';
            $output .="\n";

            if(!empty($events))
            {
                //print_r($events);die;
                foreach($events as $event)
                {   
                    $id = $event->id;
                    $category_id = $event->category_id;
                    $title = $event->title;
                    //echo$id; die;
                    //$company_name = $event->company_name;
                     $rentable_unit = $event['rentable_unit'];
                     //print_r($address);die;
                    $selected_category = $event['selected_category'];
                    $city = $event['city'];
                    $address=$event['address'];
                    $address1=$event['address1'];
                    $state=$event['state'];
                    $country=$event['country'];
                    $zip=$event['zip'];
                    $description=$event['description'];
                    $price=$event['price'];
                    $this->loadModel('Categories');
                    $props=$this->Categories->find("all")->where(['id'=>$category_id])->toArray();
                    //print_r($props);die;
        foreach ($props as $prop)
        {
           $category = $prop->name;
        }
                    
                    $output .='"'.$id.'","'. $title.'","'. $category.'","'.$selected_category.'","'.$city.'","'.$address.'","'.$address1.'","'.$state.'","'.$country.'","'.$zip.'","'.$description.'","'.$price.'"';
                    $output .="\n";

                }
            }


            $filename = "myFile".time().".csv";
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename='.$filename);
           


            echo $output;
            exit;

            
        }
        // sainding email with attach file
        public function email(){
           //$this->viewBuilder()->layout('admin');
        $this->loadModel("Email");  
        //$this->loadModel("Tenants"); 
        $uid = $this->Auth->user('id');
        $addemail =  $this->Email->newEntity();
        //$title="Add Tenant";
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            if($this->request->data['to'] == ""){
                $this->Flash->error(__('Email can not be null. Please, try again.')); $flag = false;
            }
            
             if($flag){
                $email = $this->Email->patchEntity($addemail, $this->request->data);
                try{
                    
                    //$this->request->data['name']=$name;
                    $this->Email->save($addemail);
                    $this->Flash->success(__('Email has been saved.'));
                    
                } catch (Exception $ex) {
                    
                   $this->Flash->error(__('Email could not be update. Please, try again.'));


                }
                
            }

            return $this->redirect(array("action"=>"index"));
            
        } 
        
        $this->set(compact('addemail'));

        
    }   
            

        

    /**
     * Edit method
     *
     * @param string|null $id Address id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
     public function edit($id = null) {

        //$this->viewBuilder()->layout('admin');
        $this->loadModel("Categories");   
        $title="Edit Property";
        $property =  $this->Properties->get(base64_decode($id));
        $id= base64_decode($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            
                      
            $flag = true;
            $slugExist = $this->Properties
                            ->find()
                            ->where(['title' => $this->request->data['title'],'id !='=>$id])->toArray();         
            
            if($this->request->data['title'] == ""){
                $this->Flash->error(__('Title can not be null. Please, try again.')); $flag = false;
            } 
            if($this->request->data['category_id'] == ""){
                $this->Flash->error(__('Type can not be null. Please, try again.')); $flag = false;
            }   
            if($slugExist){
                $this->Flash->error(__('Diplicate Title not allowed. Please, try again.')); $flag = false;
            } 
            // if($this->request->data['rentable_unit'] == ""){
            //     $this->Flash->error(__('Rentable Unit can not be null. Please, try again.')); $flag = false;
            // }   
            
            if($this->request->data['address'] == ""){
                $this->Flash->error(__('Address can not be null. Please, try again.')); $flag = false;
            }   
            
            if($this->request->data['city'] == ""){
                $this->Flash->error(__('City can not be null. Please, try again.')); $flag = false;
            }   
            if($this->request->data['state'] == ""){
                $this->Flash->error(__('State can not be null. Please, try again.')); $flag = false;
            }   
            if($this->request->data['zip'] == ""){
                $this->Flash->error(__('ZIP can not be null. Please, try again.')); $flag = false;
            }   
            if($this->request->data['description'] == ""){
                $this->Flash->error(__('Description can not be null. Please, try again.')); $flag = false;
            }   
            
            if($this->request->data['price'] == ""){
                $this->Flash->error(__('Price can not be null. Please, try again.')); $flag = false;
            }  
            
             
            
            if($flag){
                $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
                if (!empty($this->request->data['image']['name'])) {
                   $pathpart=pathinfo($this->request->data['image']['name']);
                   $ext=$pathpart['extension'];
                    
                    if (in_array($ext, $arr_ext)) {
                        
                        $uploadFolder = "prop_images/";
                        $uploadPath = WWW_ROOT . $uploadFolder;
                        $filename =uniqid().'.'.$ext;
                        $full_flg_path = $uploadPath . '/' . $filename;
                        move_uploaded_file($this->request->data['image']['tmp_name'],$full_flg_path);                        
                        $this->request->data['image'] = $filename;
                    } else {
                        $flag = false;
                        $this->Flash->error(__('Upload image only jpg,jpeg,png files.'));
                        
                    }
                }   
                else
                {
                    $this->request->data['image']=$property->image;
                }
                
            }             
            
            $address = $this->request->data["address"];

            // Get JSON results from this request
            $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');

            // Convert the JSON to an array
            $geo = json_decode($geo, true);

            if ($geo['status'] == 'OK') {
              // Get Lat & Long
              $latitude = $geo['results'][0]['geometry']['location']['lat'];
              $longitude = $geo['results'][0]['geometry']['location']['lng'];
              $this->request->data["lat"]=$latitude;
              $this->request->data["lang"]=$longitude;
            }
            
           $this->request->data["slug"]=$this->create_slug($this->request->data["title"]);

            
            if($flag){
               // $this->request->data; die;
                $property = $this->Properties->patchEntity($property, $this->request->data);
                if ($this->Properties->save($property)) {
                    $this->Flash->success(__('Property detail has been updated.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('Property detail could not be update. Please, try again.'));
                }
            }
        } 
        $categories=$this->Categories->find("list")->where(["is_active"=>1])->toArray();
        $this->set(compact('property','categories','title'));
        $this->set('_serialize', ['property','categories','title']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Address id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    
     public function delete($id)
    {
        $property = $this->Properties->get($id);
        if ($this->Properties->delete($property)) {
            $this->Flash->success(__('Property has been deleted.'));
        } else {
            $this->Flash->error(__('Property not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
        
    }
    
    
    public function create_slug($string, $ext=''){     
	$replace = '-';         
	$string = strtolower($string);     

	//replace / and . with white space     
	$string = preg_replace("/[\/\.]/", " ", $string);     
	$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);     

	//remove multiple dashes or whitespaces     
	$string = preg_replace("/[\s-]+/", " ", $string);     

	//convert whitespaces and underscore to $replace     
	$string = preg_replace("/[\s_]/", $replace, $string);     

	//limit the slug size     
	$string = substr($string, 0, 200);     

	//slug is generated     
	return ($ext) ? $string.$ext : $string; 
}
    
    
}

    