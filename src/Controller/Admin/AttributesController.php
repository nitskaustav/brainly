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

class AttributesController extends AppController {

	public function addattribute() {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Attributes');
        $this->loadModel('Categories');
        $this->loadModel('Brands');
        $this->loadModel('Sizes');
        
        $user = $this->Attributes->newEntity();

        $categories = $this->paginate($this->Categories);
        $brands = $this->paginate($this->Brands);
        $sizes = $this->paginate($this->Sizes);

        $this->set(compact('sizes', 'brands', 'categories'));

        /*echo "<pre>";
        print_r($user);die;*/

        if ($this->request->is('post')) {
            /*echo "<pre>";
            print_r($this->request->data); 
            echo "</pre>";*/

            $flag = true;
            
            $size_separated = '';
            $brand_separated = '';


            $category_id = $this->request->data['category_id'];
            $brands_checked = $this->request->data['brand_ids'];
            $size_checked = $this->request->data['size_ids'];

            $category_exist_check = $this->Attributes->find()->where(['category_id' => $category_id])->toArray();
            

            if(!empty($category_exist_check)){
            	$this->Flash->error(__('Category already exists. Please, provide different category.'));
                return $this->redirect(['action' => 'listattribute']);
            }

            foreach($brands_checked as $brand_val){
                $brand_separated .= $brand_val.",";
            }
            $brand_separated = rtrim($brand_separated,',');

            foreach($size_checked as $size_val){
                $size_separated .= $size_val.",";
            }
            $size_separated = rtrim($size_separated,',');

            $this->request->data['brand_ids'] = $brand_separated;
            $this->request->data['size_ids'] = $size_separated;

                     
            /*if (sizeof($this->request->data['brandcheck']) == "") {
                $this->Flash->error(__('Please, select brand.'));
                $flag = false;
            }

            if (sizeof($this->request->data['sizecheck']) == "") {
                $this->Flash->error(__('Please, select size.'));
                $flag = false;
            }*/

            //$tableRegObj = TableRegistry::get('Sizes');

            if ($flag) {
                $user = $this->Attributes->patchEntity($user, $this->request->data);
                
                

                if ($rs = $this->Attributes->save($user)) {

                    $this->Flash->success('Attribute added successfully.', ['key' => 'success']);
                    

                    //pr($this->request->data); pr($user); exit;
                    $this->redirect(['action' => 'listattribute']);
                }
                else{
                	$this->Flash->error(__('Attributes could not be added. Please, try again.'));
                    return $this->redirect(['action' => 'listattribute']);
                }
            }
            else{
            	return $this->redirect(['action' => 'listattribute']);
            }
        }

        $this->set(compact('user'));
        $this->set('_serialize', ['user']);

    }

    public function listattribute() {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Attributes');
        $this->loadModel('Categories');
        //$conditions = ['Sliders.is_active' => 1];

        $this->paginate = [
            'contain' => ['Categories'],
            'order' => [ 'id' => 'DESC']
        ];
        $user = $this->paginate($this->Attributes);
        
        /*$conn = ConnectionManager::get('default');
        $user = $conn->execute("select attr.id, attr.category_id, attr.status, ca.name from categories ca, attributes attr where attr.category_id=ca.id")->fetchAll('assoc');*/
        
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function attributedelete($id = null) {
        $this->loadModel('Attributes');
        $users = $this->Attributes->get($id);
        if ($this->Attributes->delete($users)) {
            $this->Flash->success(__('Attribute deleted.'));
        } else {
            $this->Flash->error(__('Attribute could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'listattribute']);
    }

    public function editattribute($id = null) {
        $this->viewBuilder()->layout('admin');

        $this->loadModel('Attributes');
        $this->loadModel('Categories');
        $this->loadModel('Brands');
        $this->loadModel('Sizes');

        $user = $this->Attributes->get($id);
        $categories = $this->paginate($this->Categories);
        $brands = $this->paginate($this->Brands);
        $sizes = $this->paginate($this->Sizes);

        $this->set(compact('user','sizes', 'brands', 'categories'));

        /*echo "<pre>";
        print_r($user);die;*/

        if ($this->request->is(['post', 'put'])) {
            //pr($this->request->data); exit;
            $flag = true;
            $brand_separated = '';
            $size_separated = '';
            

            $brands_checked = $this->request->data['brand_ids'];
            $size_checked = $this->request->data['size_ids'];

            foreach($brands_checked as $brand_val){
                $brand_separated .= $brand_val.",";
            }
            $brand_separated = rtrim($brand_separated,',');

            foreach($size_checked as $size_val){
                $size_separated .= $size_val.",";
            }
            $size_separated = rtrim($size_separated,',');

            $this->request->data['brand_ids'] = $brand_separated;
            $this->request->data['size_ids'] = $size_separated;

            /*
            if (sizeof($this->request->data['brandcheck']) == "") {
                $this->Flash->error(__('Please, select brand.'));
                $flag = false;
            }

            if (sizeof($this->request->data['sizecheck']) == "") {
                $this->Flash->error(__('Please, select size.'));
                $flag = false;
            }*/

            if ($flag) {
                $user = $this->Attributes->patchEntity($user, $this->request->data);
                
                if ($this->Attributes->save($user)) {

                    $this->Flash->success('Attribute edited successfully.', ['key' => 'success']);
                    
                    //pr($this->request->data); pr($user); exit;
                    $this->redirect(['action' => 'listattribute']);
                }
                else {
                    $this->Flash->error(__('Attributes could not be edited. Please, try again.'));
                    return $this->redirect(['action' => 'listattribute']);
                }
            }
            else{
            	return $this->redirect(['action' => 'listattribute']);
            }


        }

        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }
}
?>