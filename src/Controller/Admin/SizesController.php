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

class SizesController extends AppController {

	public function addsize() {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Sizes');
        $user = $this->Sizes->newEntity();
        if ($this->request->is('post')) {
            
            /*echo "<pre>";
            print_r($this->request->data); 
            echo "</pre>";exit;*/

            $flag = true;
            
            if ($this->request->data['size'] == "") {
                $this->Flash->error(__('Size can not be null. Please, try again.'));
                $flag = false;
            }

            $tableRegObj = TableRegistry::get('Sizes');

            if ($flag) {

                $size = $this->request->data['size'];
                $user = $this->Sizes->patchEntity($user, $this->request->data);
                           
                

                if ($rs = $this->Sizes->save($user)) {

                    $this->Flash->success('Size added successfully.', ['key' => 'success']);

                    //pr($this->request->data); pr($user); exit;
                    $this->redirect(['action' => 'listsize']);
                }
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function listsize() {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Sizes');
        //$conditions = ['Sliders.is_active' => 1];

        $this->paginate = [
            //'conditions' => $conditions,
            'order' => [ 'id' => 'DESC']
        ];
        $user = $this->paginate($this->Sizes);

        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function editsize($id = null) {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Sizes');
        $user = $this->Sizes->get($id);
        if ($this->request->is(['post', 'put'])) {
            //pr($this->request->data); exit;
            $flag = true;

            if ($this->request->data['size'] == "") {
                $this->Flash->error(__('Size can not be null. Please, try again.'));
                $flag = false;
            }

            if ($flag) {

                $user = $this->Sizes->patchEntity($user, $this->request->data);
                //$user['modified'] = gmdate("Y-m-d H:i:s");
                if ($this->Sizes->save($user)) {
                    $this->Flash->success(__('Size has been edited successfully.'));
                    return $this->redirect(['action' => 'listsize']);
                } else {
                    $this->Flash->error(__('Size could not be edited. Please, try again.'));
                    return $this->redirect(['action' => 'listsize']);
                }
            } else {
                return $this->redirect(['action' => 'listsize']);
            }
        }

        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function sizedelete($id = null) {
        $this->loadModel('Sizes');
        $users = $this->Sizes->get($id);
        if ($this->Sizes->delete($users)) {
            $this->Flash->success(__('Size has been deleted.'));
        } else {
            $this->Flash->error(__('Size could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'listsize']);
    }
}

?>