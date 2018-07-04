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
class LandlordsController extends AppController
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
       $title="Landlords"; 
       $uid = $this->Auth->user('id');
       $conditions["Landlords.user_id"]=$uid;
       
       if ($this->request->is('get')) 
       {
           
           $filter=array("page");
           foreach ($this->request->query as $key =>$val)
           {
               if(!in_array($key, $filter))
               {
                    if(!empty($val))
                    {
                         if($key=="property_id")
                         {
                            $conditions["Landlords.".$key]=$val; 
                         }

                         else
                         {
                            $conditions["Landlords.".$key." LIKE "]='%'.$val.'%'; 

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
            'Landlords.id' => 'desc'
        ],    
       "conditions"=>$conditions    
       ];
       $landlords = $this->paginate($this->Landlords,$options);
       $props=$this->Properties->find("all")->where(["is_active"=>1,'user_id'=>$uid])->toArray();
       foreach ($props as $prop)
       {
          $properties[$prop->id]= $prop->title;
       }
       $this->set(compact('properties','title','landlords'));
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
        $lanlord = $this->Landlords->find()->where(['Landlords.property_id' => $id])->first();
        if(!empty($lanlord))
        {
            $data=array("Ack"=>1,"id"=>$lanlord->id,"company_name"=>$lanlord->company_name,"email"=>$lanlord->email,
                        "first_name"=>$lanlord->first_name,"last_name"=>$lanlord->last_name,"phone"=>$lanlord->phone
                        ,"address"=>$lanlord->address,"bank_details"=>$lanlord->bank_details);
        }
        else
        {
             $data=array("Ack"=>0);
        }
        
        echo json_encode($data);exit;
        
        
    }
    
    
    public function view2($id = null)
    {
        $lanlord = $this->Landlords->get($id);
        if(!empty($lanlord))
        {
            $data=array("Ack"=>1,"id"=>$lanlord->id,"company_name"=>$lanlord->company_name,"email"=>$lanlord->email,
                        "first_name"=>$lanlord->first_name,"last_name"=>$lanlord->last_name,"phone"=>$lanlord->phone,""
                . "     property_id"=>$lanlord->property_id,"address"=>$lanlord->address,"bank_details"=>$lanlord->bank_details);
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
        $this->loadModel("Landlords");   
        if ($this->request->is(['patch', 'post', 'put'])) {
            if(!empty($this->request->data["id"]))
            {
             $property =  $this->Landlords->get($this->request->data["id"]);
            }
            else{
             $property =  $this->Landlords->newEntity();
             $this->request->data["add_date"]= gmdate("Y-m-d H:i:s");

            }
            $uid = $this->Auth->user('id');
            $this->request->data["user_id"]= $uid;
            $flag = true;
            if($this->request->data['first_name'] == ""){
                $this->Flash->error(__('Primary Contact can not be null. Please, try again.')); $flag = false;
            }            
             if($this->request->data['last_name'] == ""){
                $this->Flash->error(__('Primary Contact can not be null. Please, try again.')); $flag = false;
            }
            if($flag){
                $property = $this->Landlords->patchEntity($property, $this->request->data);
                try{
                    
                    $this->Landlords->save($property);
                    $this->Flash->success(__('Landlord has been saved.'));
                    
                } catch (Exception $ex) {
                    
                   $this->Flash->error(__('Landlord could not be update. Please, try again.'));


                }
                
            }

            
            
        } 
        
              $this->redirect( Router::url( $this->referer(), true ) );
    }
    
     public function addLandlord() {

        //$this->viewBuilder()->layout('admin');
        $this->loadModel("Landlords"); 
        $this->loadModel("Properties");
        $title="Add Landlord";
        $landlord =  $this->Landlords->newEntity();
        $uid = $this->Auth->user('id');
        if ($this->request->is(['patch', 'post', 'put'])) {
            if(!empty($this->request->data["id"]))
            {
             $landlord =  $this->Landlords->get($this->request->data["id"]);
            }
            else{
             $this->request->data["add_date"]= gmdate("Y-m-d H:i:s");

            }
            $this->request->data["user_id"]= $uid;
            $flag = true;
            if($this->request->data['first_name'] == ""){
                $this->Flash->error(__('Primary Contact can not be null. Please, try again.')); $flag = false;
            }            
             if($this->request->data['last_name'] == ""){
                $this->Flash->error(__('Primary Contact can not be null. Please, try again.')); $flag = false;
            }
            
             if($this->request->data['address'] == ""){
                $this->Flash->error(__('Address can not be null. Please, try again.')); $flag = false;
            }
            
             if($this->request->data['bank_details'] == ""){
                $this->Flash->error(__('Bank Details can not be null. Please, try again.')); $flag = false;
            }
            
            if($flag){
                $landlord = $this->Landlords->patchEntity($landlord, $this->request->data);
                try{
                    
                    $this->Landlords->save($landlord);
                    $this->Flash->success(__('Landlord has been saved.'));
                    
                } catch (Exception $ex) {
                    
                   $this->Flash->error(__('Landlord could not be update. Please, try again.'));


                }
                
            }

            return $this->redirect(['action' => 'index']);

            
        } 
        $props=$this->Properties->find("all")->where(["is_active"=>1,'user_id'=>$uid])->toArray();
        foreach ($props as $prop)
        {
           $properties[$prop->id]= $prop->address;
        }
        
        
        $this->set(compact('properties','landlord','title'));

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
        $property = $this->Landlords->get($id);
        if ($this->Landlords->delete($property)) {
            $this->Flash->success(__('Landlord has been deleted.'));
        } else {
            $this->Flash->error(__('Landlord not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
        
    }
    
    
    
    
    
}

    