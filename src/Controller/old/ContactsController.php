<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Runs Controller
 *
 * @property \App\Model\Table\RunsTable $Runs
 */
class ContactsController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
     
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['index']); 
    }    
    
    
    
   public function beforeFilter(Event $event) {
       /*
       if (!$this->request->session()->check('Auth.Admin')) {
          return $this->redirect(
               ['controller' => 'Users', 'action' => 'index']
           );
       } */
   }     

    // Saving Contact Request From Frontend
    public function index() {
        //pr($this->request->session()->check('Auth.Admin')); pr($this->request->session()->read('Auth.Admin')); exit;
			
        $this->viewBuilder()->layout('default');
        $contact = $this->Contacts->newEntity();
        
        if ($this->request->is('post')) {
            
            //pr($this->request->data); exit;
            
            $flag = true;

            if($this->request->data['name'] == ""){
                $this->Flash->error(__('Name can not be null. Please, try again.')); $flag = false;
            }            
            
            if($flag){
                if($this->request->data['email'] == ""){
                    $this->Flash->error(__('Email can not be null. Please, try again.')); $flag = false;
                }            
            }            

            if($flag){
                if($this->request->data['msg'] == ""){
                    $this->Flash->error(__('Message can not be null. Please, try again.')); $flag = false;
                }            
            }            

            if($flag){
                $this->request->data['sendon'] = gmdate("Y-m-d h:i:s");

                $contact = $this->Contacts->patchEntity($contact, $this->request->data);
                if ($this->Contacts->save($contact)) {
                    $this->Flash->success(__('Your Query Registered Successfully.'));
                    $this->redirect(['controller'=>'Contacts']);
                }
            }
        }
        
        $this->set(compact('contact'));
        $this->set('_serialize', ['contact']);        
        
    }



}
