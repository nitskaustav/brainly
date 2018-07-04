<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;

use Cake\I18n\FrozenDate;
use Cake\Database\Type; 
Type::build('date')->setLocaleFormat('yyyy-MM-dd');

/**
 * Runs Controller
 *
 * @property \App\Model\Table\RunsTable $Runs
 */
class ContentsController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function beforeFilter(Event $event) {
        if (!$this->request->session()->check('Auth.Admin')) {
            return $this->redirect(
                            ['controller' => 'Users', 'action' => 'index']
            );
        }
    }

    public function index() {
        //pr($this->request->session()->check('Auth.Admin')); pr($this->request->session()->read('Auth.Admin')); exit;

        $this->viewBuilder()->layout('admin');
        $contents = $this->paginate($this->Contents);
        $this->set(compact('contents'));
        $this->set('_serialize', ['contents']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Run id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $this->viewBuilder()->layout('admin');
        $content = $this->Contents->get($id, [ 'contain' => [] ]);

        // echo "<pre>";
        // print_r($content);die;
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //pr($this->request->data); exit;
            

            $flag = true;
            if($this->request->data['meta_title'] == ""){
                $this->Flash->error(__('Meta Title can not be null. Please, try again.')); $flag = false;
            }
            
            if($this->request->data['meta_key'] == ""){
                $this->Flash->error(__('Meta Key can not be null. Please, try again.')); $flag = false;
            }

            if($this->request->data['meta_description'] == ""){
                $this->Flash->error(__('Meta Description can not be null. Please, try again.')); $flag = false;
            }
            
            if($this->request->data['content'] == ""){
                $this->Flash->error(__('Content can not be null. Please, try again.')); $flag = false;
            }            
            
            if($flag){  
                $content = $this->Contents->patchEntity($content, $this->request->data);
                if ($this->Contents->save($content)) {
                    $this->Flash->success(__('The Content has been updated.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The Content could not be updated. Please, try again.'));
                }              
            }             
        }
        $this->set(compact('content'));
        $this->set('_serialize', ['content']);
    }    
    
    
    
    
    
    /**
     * View method
     *
     * @param string|null $id Run id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null){
        $this->viewBuilder()->layout('admin');
        $run = $this->Runs->get($id, [
            'contain' => ['Addresses', 'Orders']
        ]);

        $this->set('run', $run);
        $this->set('_serialize', ['run']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add(){
        $this->viewBuilder()->layout('admin');
        //$run = $this->Runs->newEntity();
        $run = "";
        if ($this->request->is('post')) {
            $run = $this->Runs->patchEntity($run, $this->request->data);
            if ($this->Runs->save($run)) {
                $this->Flash->success(__('The run has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The run could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('run'));
        $this->set('_serialize', ['run']);
    }


    public function addnew(){
        $this->viewBuilder()->layout('admin');
        //$run = $this->Runs->newEntity();
        $run = "";
        if ($this->request->is('post')) {
            $run = $this->Runs->patchEntity($run, $this->request->data);
            if ($this->Runs->save($run)) {
                $this->Flash->success(__('The run has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The run could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('run'));
        $this->set('_serialize', ['run']);
    }    

    public function addvalidation(){
        $this->viewBuilder()->layout('admin');
        //$run = $this->Runs->newEntity();
        $run = "";
        if ($this->request->is('post')) {
            $run = $this->Runs->patchEntity($run, $this->request->data);
            if ($this->Runs->save($run)) {
                $this->Flash->success(__('The run has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The run could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('run'));
        $this->set('_serialize', ['run']);
    }  


    public function datatable(){
        $this->viewBuilder()->layout('admin');
        //$run = $this->Runs->newEntity();
        $run = "";
        if ($this->request->is('post')) {
            $run = $this->Runs->patchEntity($run, $this->request->data);
            if ($this->Runs->save($run)) {
                $this->Flash->success(__('The run has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The run could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('run'));
        $this->set('_serialize', ['run']);
    } 


    /**
     * Delete method
     *
     * @param string|null $id Run id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $run = $this->Runs->get($id);
        if ($this->Runs->delete($run)) {
            $this->Flash->success(__('The run has been deleted.'));
        } else {
            $this->Flash->error(__('The run could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
