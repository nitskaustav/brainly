<?php

namespace App\Controller\Admin;

use App\Controller\AppController;

class EngineSizesController extends AppController {

    public function index() {
        $this->loadModel('EngineSizes');

        $make = $this->paginate($this->EngineSizes);
        
        $this->set(compact('make'));
    }

    public function add() {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('EngineSizes');
        $engine = $this->EngineSizes->newEntity();

        $lastid = '';
        if ($this->request->is(['post', 'put'])) {
            $flag = true;
            if ($this->request->data['size'] == "") {
                $flag = false;
            }


            if ($flag) {

                $engine = $this->EngineSizes->patchEntity($engine, $this->request->data);
                $save = $this->EngineSizes->save($engine);
                if ($save) {

                  
                } else {
                    $this->Flash->error(__('Engine size could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('Some fields are empty. Please, try again.'));
            }


            if ($flag) {
                $this->Flash->success(__('Make has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
        }
        
    }

    public function edit($id = null) {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Users');
        $this->loadModel('EngineSizes');
        $engine = $this->EngineSizes->get($id);
        if ($this->request->is(['post', 'put'])) {           
            $flag = true;
            $flag = true;
            if ($this->request->data['size'] == "") {
                $flag = false;
            }

            if ($flag) {

                $engine = $this->EngineSizes->patchEntity($engine, $this->request->data);
                if ($this->EngineSizes->save($engine)) {
                    
                } else {
                    $this->Flash->error(__('Make could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('Some fields are empty. Please, try again.'));
            }


            if ($flag) {
                $this->Flash->success(__('Make has been saved.'));
            }
            //return $this->redirect(['action' => 'index']);
        }        
        $this->set(compact('engine'));
        //$this->set(compact('products'));
    }

    public function delete($id = null) {
        $this->loadModel('EngineSizes');
        $engine = $this->EngineSizes->get($id);
        if ($this->EngineSizes->delete($engine)) {
            $this->Flash->success(__('Engine size has been deleted.'));
        } else {
            $this->Flash->error(__('Engine size could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
