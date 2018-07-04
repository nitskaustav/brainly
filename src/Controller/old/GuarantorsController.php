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
class GuarantorsController extends AppController
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
       $this->loadModel("Tenants");  
       $title="Guarantors"; 
       $uid = $this->Auth->user('id');
       $conditions["Guarantors.user_id"]=$uid;
       
       if ($this->request->is('get')) 
       {
           
           $filter=array("page");
           foreach ($this->request->query as $key =>$val)
           {
               if(!in_array($key, $filter))
               {
                    if(!empty($val))
                    {
                         if($key=="tenant_id")
                         {
                            $conditions["Guarantors.".$key]=$val; 
                         }

                         else
                         {
                            $conditions["Guarantors.".$key." LIKE "]='%'.$val.'%'; 

                         }
                    }
                    $this->request->data[$key]=$val;
               }
               
               
           }
           
       }
       $options=[
       "limit"=>10,
       "contain"=>"Tenants",
        "order" => [
            'Guarantors.id' => 'desc'
        ],    
       "conditions"=>$conditions    
       ];
       $guarantors = $this->paginate($this->Guarantors,$options);
       $tenants=$this->Tenants->find("list")->where(['user_id'=>$uid])->toArray();
       
       $this->set(compact('tenants','title','guarantors'));
       $this->set('_serialize', ['properties','title']); 

    }
    //export details

    /**
     * View method
     *
     * @param string|null $id Address id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $guarantor = $this->Guarantors->find()->where(['Guarantors.property_id' => $id])->first();
        if(!empty($guarantor))
        {
            $data=array("Ack"=>1,"id"=>$guarantor->id,"company_name"=>$guarantor->company_name,"email"=>$guarantor->email,
                        "first_name"=>$guarantor->first_name,"last_name"=>$guarantor->last_name,"phone"=>$guarantor->phone);
        }
        else
        {
             $data=array("Ack"=>0);
        }
        
        echo json_encode($data);exit;
        
        
    }
    
    
    public function view2($id = null)
    {
        $guarantor = $this->Guarantors->get($id);
        if(!empty($guarantor))
        {
            $data=array("Ack"=>1,"id"=>$guarantor->id,"company_name"=>$guarantor->company_name,"email"=>$guarantor->email,
                        "first_name"=>$guarantor->first_name,"last_name"=>$guarantor->last_name,"phone"=>$guarantor->phone,"property_id"=>$guarantor->property_id);
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
        $this->loadModel("Guarantors");   
        if ($this->request->is(['patch', 'post', 'put'])) {
            if(!empty($this->request->data["id"]))
            {
             $property =  $this->Guarantors->get($this->request->data["id"]);
            }
            else{
             $property =  $this->Guarantors->newEntity();
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
                $property = $this->Guarantors->patchEntity($property, $this->request->data);
                try{
                    
                    $this->Guarantors->save($property);
                    $this->Flash->success(__('Guarantor has been saved.'));
                    
                } catch (Exception $ex) {
                    
                   $this->Flash->error(__('Guarantor could not be update. Please, try again.'));


                }
                
            }

            
            
        } 
        
              $this->redirect( Router::url( $this->referer(), true ) );
    }   
      public function addGuarantor() {

        //$this->viewBuilder()->layout('admin');
        $this->loadModel("Guarantors"); 
        $this->loadModel("Tenants");
        $title="Add Guarantor";
        $uid = $this->Auth->user('id');
        $guarantor =  $this->Guarantors->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $this->request->data["add_date"]= gmdate("Y-m-d H:i:s");
            $this->request->data["user_id"]= $uid;
            $flag = true;
            if($this->request->data['first_name'] == ""){
                $this->Flash->error(__('Primary Contact can not be null. Please, try again.')); $flag = false;
            }            
             if($this->request->data['last_name'] == ""){
                $this->Flash->error(__('Primary Contact can not be null. Please, try again.')); $flag = false;
            }
            if($flag){
                $guarantor = $this->Guarantors->patchEntity($guarantor, $this->request->data);
                try{
                    
                    $this->Guarantors->save($guarantor);
                    $this->Flash->success(__('Guarantor has been saved.'));
                    
                } catch (Exception $ex) {
                    
                   $this->Flash->error(__('Guarantor could not be update. Please, try again.'));


                }
                
            }

            return $this->redirect(['action' => 'index']);
            
        } 
        $props=$this->Tenants->find("all")->where(['user_id'=>$uid])->toArray();
       // echo '<pre>'; print_r($tenants);die;
         //$props=$this->Properties->find("all")->where(["is_active"=>1,'user_id'=>$uid])->toArray();

        foreach ($props as $prop)
        {
           $tenants[$prop->id]= $prop->name;
        }
        
        
        
        $this->set(compact('tenants','guarantor','title'));
        
        
    } 



      public function edit($id=null) {

        //$this->viewBuilder()->layout('admin');
        $this->loadModel("Guarantors"); 
        $this->loadModel("Tenants");
        $title="Add Guarantor";
        $uid = $this->Auth->user('id');
        $guarantor =  $this->Guarantors->get(base64_decode($id));

        if ($this->request->is(['patch', 'post', 'put'])) {
            
            
            $flag = true;
            if($this->request->data['first_name'] == ""){
                $this->Flash->error(__('Primary Contact can not be null. Please, try again.')); $flag = false;
            }            
             if($this->request->data['last_name'] == ""){
                $this->Flash->error(__('Primary Contact can not be null. Please, try again.')); $flag = false;
            }
            if($flag){
                $guarantor = $this->Guarantors->patchEntity($guarantor, $this->request->data);
                try{
                    
                    $this->Guarantors->save($guarantor);
                    $this->Flash->success(__('Guarantor has been saved.'));
                    
                } catch (Exception $ex) {
                    
                   $this->Flash->error(__('Guarantor could not be update. Please, try again.'));


                }
                
            }

            return $this->redirect(['action' => 'index']);
            
        } 
        $tenants=$this->Tenants->find("list")->where(['user_id'=>$uid])->toArray();
        
        
        
        $this->set(compact('tenants','guarantor','title'));
        
        
    }
    public function exportdetails(){
        
         $uid = $this->Auth->user('id');
         //echo "$uid"; die;
            //$events = $this->User->find('all',array('conditions' => array('User.is_paid' => 1)));
            $this->loadModel('Guarantors');
             $this->loadModel('Tenants');
            $events = $this->Guarantors->find()->where(['user_id' => $uid])->toArray();
            

            //print_r($events);
            //$this->layout = false;
            $output='';
            $output .='Id,Tenants,Company, Email,FirstName,LastName,Phone, AddDate';
            $output .="\n";

            if(!empty($events))
            {
               // print_r($events);die;
                foreach($events as $event)
                {   
                    $id = $event->id;
                    $tenant_id = $event->tenant_id;
                    //echo $id; die;
                    $company_name = $event->company_name;
                     //$address = $event['address'];
                     //print_r($address);die;
                     $email = $event['email'];
                    $first_name=$event['first_name'];
                   // print_r($first_name);die;
                    $last_name=$event['last_name'];
                    $phone=$event['phone'];
                    //print_r($phone);die;
                    $add_date=$event['add_date'];
                   // print_r($add_date);die;
                    $props=$this->Tenants->find("all")->where(['id'=>$tenant_id])->toArray();
                    //echo "<pre>"; print_r($props); die;
        foreach ($props as $prop)
        {
           $tenants = $prop->name;
        }
                    
                    $output .='"'.$id.'","'.$tenants.'","'.$company_name.'","'.$email.'","'.$first_name.'","'.$last_name.'","'.$phone.'","'.$add_date.'"';
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
        $property = $this->Guarantors->get($id);
        if ($this->Guarantors->delete($property)) {
            $this->Flash->success(__('Guarantor has been deleted.'));
        } else {
            $this->Flash->error(__('Guarantor not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
        
    }
    
    
    
    
    
}

    