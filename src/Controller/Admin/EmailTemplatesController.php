<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper;
/**
 * Website Settings Controller
 *
 * @property \App\Model\Table\SiteSettingsTable $Customers
 */
class EmailTemplatesController extends AppController {
    

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    
    public function index() {

        $this->viewBuilder()->layout('admin');
        $this->paginate = [
            'contain' => [],
            'order' => [
            'EmailTemplates.id' => 'desc'
        ]
        ];
        $query = $this->EmailTemplates->find();
        $email_tpls =$this->paginate($query);
        $this->set(compact('email_tpls'));
        $this->set('_serialize', ['email_tpls']);
        

    }
    
    public function edit($id = null) {

        $this->viewBuilder()->layout('admin');
        $email_template = $this->EmailTemplates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $doctor = $this->EmailTemplates->patchEntity($email_template, $this->request->data);
            if ($this->EmailTemplates->save($doctor)) {
                $this->Flash->success(__('Email Template detail has been updated.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Email Template could not be update. Please, try again.'));
            }
        }
        $this->set(compact('email_template'));
        $this->set('_serialize', ['email_template']);
    }
}
