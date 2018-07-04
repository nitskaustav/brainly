<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

class ColoursController extends AppController {

    public function index() {
        $this->loadModel('Colours');

        $colour = $this->paginate($this->Colours);
        
        $this->set(compact('colour'));
    }

    public function add() {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Colours');
        $colour = $this->Colours->newEntity();

        $lastid = '';
        if ($this->request->is(['post', 'put'])) {

            // echo "<pre>";
            // print_r($this->request->data);exit;

            $flag = true;

            if ($this->request->data['name'] == "") {
                $this->Flash->error(__('Please provide colour name'));
                $flag = false;
            }

            if ($this->request->data['hexcode'] == "") {
                $this->Flash->error(__('Please provide colour hexcode'));
                $flag = false;
            }


            if ($flag) {

                $colour = $this->Colours->patchEntity($colour, $this->request->data);
                $save = $this->Colours->save($colour);
                if ($save) {
                    $this->Flash->success(__('Colour has been saved.'));
                    return $this->redirect(['action' => 'index']);
                  
                } else {
                    $this->Flash->error(__('Colour not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('Some fields are empty. Please, try again.'));
            }

        }
        
    }

    public function edit($id = null) {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Users');
        $this->loadModel('Colours');
        $colour = $this->Colours->get($id);
        if ($this->request->is(['post', 'put'])) {           
            $flag = true;            
            if ($this->request->data['name'] == "") {
                $this->Flash->error(__('Please provide colour name.'));
                $flag = false;
            }

            if ($this->request->data['hexcode'] == "") {
                $this->Flash->error(__('Please provide colour hexcode.'));
                $flag = false;
            }

            if ($flag) {

                $colour = $this->Colours->patchEntity($colour, $this->request->data);
                if ($this->Colours->save($colour)) {
                    
                } else {
                    $this->Flash->error(__('Colour could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('Some fields are empty. Please, try again.'));
            }


            if ($flag) {
                $this->Flash->success(__('Colour has been edited successfully.'));
            }
            //return $this->redirect(['action' => 'index']);
        }        
        $this->set(compact('colour'));
        //$this->set(compact('products'));
    }

    public function delete($id = null) {
        $this->loadModel('Colours');
        $colour = $this->Colours->get($id);
        if ($this->Colours->delete($colour)) {
            $this->Flash->success(__('Colour has been deleted.'));
        } else {
            $this->Flash->error(__('Colour could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function chstatus($colour_id,$status){
        //echo $color_id." ".$status;die;
        $this->loadModel('Colours');
        $colour_data = $this->Colours->get($colour_id);
        $colour['status'] = $status;
        $colour_update_data = $this->Colours->patchEntity($colour_data, $colour);
        if ($rs=$this->Colours->save($colour_update_data)){
            $this->Flash->success(__('Status changed'));
            $this->redirect($this->referer());
        }
    }

}
