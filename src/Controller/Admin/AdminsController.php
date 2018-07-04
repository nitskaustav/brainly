<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

use Cake\Mailer\Email;
use Cake\Routing\Router;

use Cake\I18n\FrozenDate;
use Cake\Database\Type; 
Type::build('date')->setLocaleFormat('yyyy-MM-dd');

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 */
class AdminsController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    /*
      public function beforeFilter(Event $event) {
      if (!$this->request->session()->check('Auth.Admin')) {
      return $this->redirect(
      ['controller' => 'Admins', 'action' => 'index']
      );
      }
      }

     */

    /*
     *  Admins Listing
     */
    public function index() {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Admins');
        
        #$this->paginate = ['conditions' => ['utype' => 'U']];

        //$this->set('disciplines', $this->paginate($this->Admins));
        
        $doctors = $this->paginate($this->Admins);
        
        
        
        
        $this->set(compact('doctors'));
        $this->set('_serialize', ['doctors']);
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $this->viewBuilder()->layout('admin');
        $doctors = $this->Admins->get($id);

        //$results = $customer->toArray(); pr($results); exit;

        $this->set('doctors', $doctors);
        $this->set('_serialize', ['doctors']);
    }

    /**
     * Add Admin With permissions
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $this->viewBuilder()->layout('admin');
        $doctor = $this->Admins->newEntity();
        if ($this->request->is('post')) {
//            if(!empty($this->request->data['allpermissions']))
//            {
//                $this->request->data['permissions'] = implode(',',$this->request->data['allpermissions']);
//            }
            $doctors = $this->Admins->patchEntity($doctor, $this->request->data);
            
            $this->request->data['created'] = gmdate("Y-m-d h:i:s");
            $this->request->data['modified'] = gmdate("Y-m-d h:i:s"); 
           
            if ($this->Admins->save($doctors)) {
                $this->Flash->success(__('The Admin has been saved.'));
                //pr($this->request->data); pr($doctors); exit;
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The Admin could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data['first_name'] = '';
            $this->request->data['last_name'] = '';
            $this->request->data['phone'] = '';
            $this->request->data['username'] = '';
            $this->request->data['email'] = '';
        }
        //$this->loadModel('AdminMenus');
        //$menus = $this->AdminMenus->find()->all();
        $this->set(compact('doctor','menus'));
        $this->set('_serialize', ['doctor']);
    }

    /**
     * Edit Admin With Permissions
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {

        $this->viewBuilder()->layout('admin');
        $doctor = $this->Admins->get($id, [
            'contain' => []
        ]);
        
       
        if ($this->request->is(['patch', 'post', 'put'])) {
            if(empty($this->request->data['password']))
            {
                unset($this->request->data['password']);
            }
//            if(!empty($this->request->data['allpermissions']))
//            {
//                $this->request->data['permissions'] = implode(',',$this->request->data['allpermissions']);
//            }
            $doctor = $this->Admins->patchEntity($doctor, $this->request->data);
            
            $this->request->data['modified'] = gmdate("Y-m-d h:i:s");
            if ($this->Admins->save($doctor)) {
                $this->Flash->success(__('Admin detail has been updated.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Admins detail could not be update. Please, try again.'));
            }
        } else {
            $this->request->data = $doctor->toArray();
            //$this->request->data['allpermissions'] = explode(',',$this->request->data['permissions']);
        }

        
        
        $this->set(compact('doctor','menus'));
        $this->set('_serialize', ['doctor']);
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
        $doctor = $this->Admins->get($id);
        if ($this->Admins->delete($doctor)) {
            $this->Flash->success(__('Admins has been deleted.'));
        } else {
            $this->Flash->error(__('Admins could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
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
    public function docstatus($id = null, $status = null) {
        //echo $id; echo "--"; echo $status; //exit;
        $tableRegObj = TableRegistry::get('Admins');
        $query = $tableRegObj->find('all', [ 'conditions' => ['id' => $id]]);
        $row = $query->first()->toArray();
        //pr($row); exit;
        if($row){
            $subquestion = TableRegistry::get('Admins');
            $query = $subquestion->query();
            if($status == 1){
                $query->update()->set(['status' => 1])->where(['id' => $id])->execute();
                $this->Flash->success(__('Admin has been activated.'));
            } else if($status == 0){
                $query->update()->set(['status' => 0])->where(['id' => $id])->execute(); 
                $this->Flash->success(__('Admin has been suspended.'));
            }
        } else {
            $this->Flash->error(__('Admin Not Found.'));
        }        
        return $this->redirect(['action' => 'index']);
    }
}