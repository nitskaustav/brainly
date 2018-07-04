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
class FaqsController extends AppController {

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
        $faqs = $this->paginate($this->Faqs);
        $this->set(compact('faqs'));
        $this->set('_serialize', ['faqs']);
    }

    /**
     * View method
     *
     * @param string|null $id Run id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $this->viewBuilder()->layout('admin');
        $faq = $this->Faqs->get($id, [ 'contain' => [] ]);

        $this->set('faq', $faq);
        $this->set('_serialize', ['faq']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $this->viewBuilder()->layout('admin');
        $faq = $this->Faqs->newEntity();
        if ($this->request->is('post')) {
            //echo "<pre>"; print_r($_FILES); echo "<pre>"; print_r($this->request->data); exit;
            $flag = true;
            if($this->request->data['question'] == ""){
                $this->Flash->error(__('Faqs question can not be null. Please, try again.')); $flag = false;
            }
            
            if($this->request->data['answer'] == ""){
                $this->Flash->error(__('Faqs answer can not be null. Please, try again.')); $flag = false;
            }

            if($flag){
                $faq = $this->Faqs->patchEntity($faq, $this->request->data);
                if ($this->Faqs->save($faq)) {
                    $this->Flash->success(__('Faqs has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('Faqs could not be saved. Please, try again.'));
                }
            }
        }
        $this->set(compact('faq'));
        $this->set('_serialize', ['faq']);
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
        $faq = $this->Faqs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //pr($this->request->data); exit;
            $flag = true;
            if($this->request->data['question'] == ""){
                $this->Flash->error(__('Faqs question can not be null. Please, try again.')); $flag = false;
            }
            
            if($this->request->data['answer'] == ""){
                $this->Flash->error(__('Faqs answer can not be null. Please, try again.')); $flag = false;
            }

            if($flag){               
                $faq = $this->Faqs->patchEntity($faq, $this->request->data);
                if ($this->Faqs->save($faq)) {
                    $this->Flash->success(__('Faqs has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('Faqs could not be saved. Please, try again.'));
                }                
            }           

        }
        $this->set(compact('faq'));
        $this->set('_serialize', ['faq']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Run id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        //$this->request->allowMethod(['post', 'delete']);
        $faq = $this->Faqs->get($id);
        if ($this->Faqs->delete($faq)) {
            $this->Flash->success(__('The FAQ has been deleted.'));
        } else {
            $this->Flash->error(__('The FAQ could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    
    public function treatmentindex() {
        //pr($this->request->session()->check('Auth.Admin')); pr($this->request->session()->read('Auth.Admin')); exit;

        $this->viewBuilder()->layout('admin');
        $faqs = $this->paginate($this->Faqs);
        $this->set(compact('faqs'));
        $this->set('_serialize', ['faqs']);
    }


    public function treatmentview($id = null) {
        $this->viewBuilder()->layout('admin');
        $faq = $this->Faqs->get($id, [ 'contain' => [] ]);

        $this->set('faq', $faq);
        $this->set('_serialize', ['faq']);
    }


    public function treatmentadd() {
        $this->viewBuilder()->layout('admin');
        $faq = $this->Faqs->newEntity();
        if ($this->request->is('post')) {
            //echo "<pre>"; print_r($_FILES); echo "<pre>"; print_r($this->request->data); exit;
            $flag = true;
            if($this->request->data['question'] == ""){
                $this->Flash->error(__('Faqs question can not be null. Please, try again.')); $flag = false;
            }
            
            if($this->request->data['answer'] == ""){
                $this->Flash->error(__('Faqs answer can not be null. Please, try again.')); $flag = false;
            }

            if($flag){
                $faq = $this->Faqs->patchEntity($faq, $this->request->data);
                if ($this->Faqs->save($faq)) {
                    $this->Flash->success(__('Faqs has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('Faqs could not be saved. Please, try again.'));
                }
            }
        }
        $this->set(compact('faq'));
        $this->set('_serialize', ['faq']);
    }


    public function treatmentedit($id = null) {
        $this->viewBuilder()->layout('admin');
        $faq = $this->Faqs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            
            $flag = true;
            if($this->request->data['question'] == ""){
                $this->Flash->error(__('Faqs question can not be null. Please, try again.')); $flag = false;
            }
            
            if($this->request->data['answer'] == ""){
                $this->Flash->error(__('Faqs answer can not be null. Please, try again.')); $flag = false;
            }

            if($flag){               
                $faq = $this->Faqs->patchEntity($faq, $this->request->data);
                if ($this->Faqs->save($faq)) {
                    $this->Flash->success(__('Faqs has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('Faqs could not be saved. Please, try again.'));
                }                
            }           

        }
        $this->set(compact('faq'));
        $this->set('_serialize', ['faq']);
    }


    public function treatmentdelete($id = null) {
        //$this->request->allowMethod(['post', 'delete']);
        $faq = $this->Faqs->get($id);
        if ($this->Faqs->delete($faq)) {
            $this->Flash->success(__('The FAQ has been deleted.'));
        } else {
            $this->Flash->error(__('The FAQ could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }   

    
}
