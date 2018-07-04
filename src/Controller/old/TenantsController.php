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
class TenantsController extends AppController
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
       $this->loadModel("Properties");  
       $title="Tenants"; 
       $uid = $this->Auth->user('id');
       $conditions["Tenants.user_id"]=$uid;
       
       if ($this->request->is('get')) 
       {
           
           $filter=array("page");
           //print_r($this->request->query); die;
           foreach ($this->request->query as $key =>$val)
           {
               if(!in_array($key, $filter))
               {
                    if(!empty($val))
                    {
                         if($key=="property_id")
                         {
                            $conditions["Tenants.".$key]=$val; 
                         }

                         else
                         {
                            $conditions["Tenants.".$key." LIKE "]='%'.$val.'%'; 

                         }
                    }
                    $this->request->data[$key]=$val;
               }
               
               
           }
           
       }
       $options=[   
       "limit"=>10,
       "contain"=>"Properties",
        "order" => [
            'Tenants.id' => 'desc'
        ],    
       "conditions"=>$conditions    
       ];
      // print_r($options);die;
       $tenants = $this->paginate($this->Tenants,$options);
     //  print_r($tenants);die;
       $props=$this->Properties->find("all")->where(["is_active"=>1,'user_id'=>$uid])->toArray();
       foreach ($props as $prop)
       {
          $properties[$prop->id]= $prop->title;
       }
       $this->set(compact('properties','title','tenants'));
       $this->set('_serialize', ['properties','title']); 

    }
    //export
    public function export(){
        $uid = $this->Auth->user('id');
            //$events = $this->User->find('all',array('conditions' => array('User.is_paid' => 1)));
            $this->loadModel('Tenants');
             $this->loadModel('Properties');
            $events = $this->Tenants->find()->where(['user_id' => $uid])->toArray();
            

            //print_r($events);
            //$this->layout = false;
            $output='';
            $output .='Id,Property,FirstName,LastName,Email,Phone,Address, add_date';
            $output .="\n";

            if(!empty($events))
            {
                //print_r($events);die;
                foreach($events as $event)
                {   
                    $id = $event->id;
                    //echo$id; die;
                     $address = $event['address'];
                     //print_r($address);die;
                   // $bank_details = $event['bank_details'];
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
                    
                    $output .='"'.$id.'","'.$properties.'","'.$first_name.'","'.$last_name.'","'.$email.'","'.$phone.'","'.$address.'","'.$add_date.'"';
                    $output .="\n";
                }
            }


            $filename = "myFile".time().".csv";
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename='.$filename);
            echo $output;
            exit;

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
        $tenant = $this->Tenants->find()->where(['Tenants.property_id' => $id])->first();
        if(!empty($tenant))
        {
            $data=array("Ack"=>1,"id"=>$tenant->id,"email"=>$tenant->email,
                        "name"=>$tenant->name,"phone"=>$tenant->phone,"address"=>$tenant->address);
        }
        else
        {
             $data=array("Ack"=>0);
        }
        
        echo json_encode($data);exit;
        
        
    }
    
    
    public function view2($id = null)
    {
        $tenant = $this->Tenants->get($id);
        if(!empty($tenant))
        {
            $data=array("Ack"=>1,"id"=>$tenant->id,"company_name"=>$tenant->company_name,"email"=>$tenant->email,
                        "first_name"=>$tenant->first_name,"last_name"=>$tenant->last_name,"phone"=>$tenant->phone,"property_id"=>$tenant->property_id);
        }
        else
        {
             $data=array("Ack"=>0);
        }
        
        echo json_encode($data);exit;
        
        
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
      public function add() {

        //$this->viewBuilder()->layout('admin');
        $this->loadModel("Properties");  
        $this->loadModel("Tenants"); 
        $uid = $this->Auth->user('id');
        $tenant =  $this->Tenants->newEntity();
        $title="Add Tenant";
        if ($this->request->is(['patch', 'post', 'put'])) {
            if(!empty($this->request->data["id"]))
            {
             $tenant =  $this->Tenants->get($this->request->data["id"]);
            }
            else{
             $property =  $this->Tenants->newEntity();
             $this->request->data["add_date"]= gmdate("Y-m-d H:i:s");

            }
            $this->request->data["user_id"]= $uid;
            $flag = true;
            if($this->request->data['first_name'] == ""){
                $this->Flash->error(__('First Name can not be null. Please, try again.')); $flag = false;
            } 
            if($this->request->data['last_name'] == ""){
                $this->Flash->error(__('Last Name can not be null. Please, try again.')); $flag = false;
            }            
             if($this->request->data['property_id'] == ""){
                $this->Flash->error(__('Property can not be null. Please, try again.')); $flag = false;
            }
            if($this->request->data['address'] == ""){
                $this->Flash->error(__('Address can not be null. Please, try again.')); $flag = false;
            }
            
            if($this->request->data['email'] == ""){
                $this->Flash->error(__('Email can not be null. Please, try again.')); $flag = false;
            }
            
            
            if($this->request->data['phone'] == ""){
                $this->Flash->error(__('Phone can not be null. Please, try again.')); $flag = false;
            }
            
            
            
            if($flag){
                $fname = $this->request->data['first_name'];
                    $lname = $this->request->data['last_name'];
                    $this->request->data['name']=$fname.''.$lname;
                $tenant = $this->Tenants->patchEntity($tenant, $this->request->data);
                try{
                    
                    //$this->request->data['name']=$name;
                    $this->Tenants->save($tenant);
                    $this->Flash->success(__('Tenant has been saved.'));
                    
                } catch (Exception $ex) {
                    
                   $this->Flash->error(__('Tenant could not be update. Please, try again.'));


                }
                
            }

            return $this->redirect(array("action"=>"index"));
            
        } 
        $props=$this->Properties->find("all")->where(["is_active"=>1,'user_id'=>$uid])->toArray();
        foreach ($props as $prop)
        {
           $properties[$prop->id]= $prop->address;
        }
        $this->set(compact('properties','tenant','title'));

        
    }   
      public function edit($id=null) {

        //$this->viewBuilder()->layout('admin');
        $this->loadModel("Properties");  
        $this->loadModel("Tenants"); 
        $uid = $this->Auth->user('id');
        $tenant =  $this->Tenants->get(base64_decode($id));
        $title="Edit Tenant";
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $flag = true;
            if($this->request->data['first_name'] == ""){
                $this->Flash->error(__('First Name can not be null. Please, try again.')); $flag = false;
            }   
            if($this->request->data['last_name'] == ""){
                $this->Flash->error(__('Last Name can not be null. Please, try again.')); $flag = false;
            }            
             if($this->request->data['property_id'] == ""){
                $this->Flash->error(__('Property can not be null. Please, try again.')); $flag = false;
            }
            if($this->request->data['address'] == ""){
                $this->Flash->error(__('Address can not be null. Please, try again.')); $flag = false;
            }
            
            if($this->request->data['email'] == ""){
                $this->Flash->error(__('Email can not be null. Please, try again.')); $flag = false;
            }
            
            
            if($this->request->data['phone'] == ""){
                $this->Flash->error(__('Phone can not be null. Please, try again.')); $flag = false;
            }
            
            
            
            if($flag){
                $tenant = $this->Tenants->patchEntity($tenant, $this->request->data);
                try{
                    
                    $this->Tenants->save($tenant);
                    $this->Flash->success(__('Tenant has been saved.'));
                    
                } catch (Exception $ex) {
                    
                   $this->Flash->error(__('Tenant could not be update. Please, try again.'));


                }
                
            }

            return $this->redirect(array("action"=>"index"));
            
        } 
        $props=$this->Properties->find("all")->where(["is_active"=>1,'user_id'=>$uid,"id"=>$tenant->property_id])->toArray();
        foreach ($props as $prop)
        {
           $properties[$prop->id]= $prop->title;
        }
        $this->set(compact('properties','tenant','title'));

        
    }     
    
    
    
    

    /**
     * Edit method
     *
     * @param string|null $id Address id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

    /**
     * Delete method
     *
     * @param string|null $id Address id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    
     public function delete($id)
    {
        $property = $this->Tenants->get($id);
        if ($this->Tenants->delete($property)) {
            $this->Flash->success(__('Tenant has been deleted.'));
        } else {
            $this->Flash->error(__('Tenant not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
        
    }
    
    
    
    
    
}

    