<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Runs Controller
 *
 * @property \App\Model\Table\RunsTable $Runs
 */
class CmssController extends AppController {

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
        $runs = $this->paginate($this->Runs);
        $this->set(compact('runs'));
        $this->set('_serialize', ['runs']);
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
     * Edit method
     *
     * @param string|null $id Run id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $this->viewBuilder()->layout('admin');
        $run = $this->Runs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
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
