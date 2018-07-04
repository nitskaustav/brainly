<?php

namespace App\Controller\Admin;

use App\Controller\AppController;

class MakesController extends AppController {

    public function index() {
        $this->loadModel('Makes');

        $make = $this->paginate($this->Makes);
        
        $this->set(compact('make'));
    }

    public function add() {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Makes');
        $makes = $this->Makes->newEntity();

        $lastid = '';
        if ($this->request->is(['post', 'put'])) {
            $flag = true;
            if ($this->request->data['make_name'] == "") {
                $flag = false;
            }


            if ($flag) {

                $makes = $this->Makes->patchEntity($makes, $this->request->data);
                $save = $this->Makes->save($makes);
                if ($save) {
                    $this->Flash->success(__('Make has been saved.'));
                return $this->redirect(['action' => 'index']);
                  
                } else {
                    $this->Flash->error(__('Make could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('Some fields are empty. Please, try again.'));
            }
        }
        
    }

    public function edit($id = null) {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Users');
        $this->loadModel('Makes');
        $make = $this->Makes->get($id);
        if ($this->request->is(['post', 'put'])) {           
            $flag = true;
            $flag = true;
            if ($this->request->data['make_name'] == "") {
                $flag = false;
            }

            if ($flag) {

                $make = $this->Makes->patchEntity($make, $this->request->data);
                if ($this->Makes->save($make)) {
                    
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
        $this->set(compact('make'));
        //$this->set(compact('products'));
    }

    public function delete($id = null) {
        $this->loadModel('Makes');
        $make = $this->Makes->get($id);
        if ($this->Makes->delete($make)) {
            $this->Flash->success(__('Make has been deleted.'));
        } else {
            $this->Flash->error(__('Make could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
