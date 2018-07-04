<?php

namespace App\Controller\Admin;

use App\Controller\AppController;

class CategoriesController extends AppController {

    public function index() {
        $this->loadModel('Categories');

        $category = $this->paginate($this->Categories);
        //echo '<pre>';
        //print_r($category);
        //exit;
        //$models = $this->Category->find()->where(['status' => 1])->toArray();
        $this->set(compact('category'));
    }

    public function add() {
        $this->viewBuilder()->layout('admin');

        $this->loadModel('Categories');

        $categories = $this->Categories->newEntity();

        $lastid = '';
        if ($this->request->is(['post', 'put'])) {

            $flag = true;
            if ($this->request->data['name'] == "") {
                $flag = false;
            }



            //--------------------------------------------------------------------------------

            $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
            if (!empty($this->request->data['image']['name'])) {
                $file = $this->request->data['image']; //put the data into a var for easy use
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                $fileName = time() . "." . $ext;
                if (in_array($ext, $arr_ext)) {

                    if ($categories->path != "" && $categories->path != $fileName) {
                        $filePathDel = WWW_ROOT . 'user_img' . DS . $categories->path;
                        if (file_exists($filePathDel)) {
                            unlink($filePathDel);
                        }
                    }
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'category_img' . DS . $fileName);
                    $file = $fileName;
                    $this->request->data['path'] = $fileName;
                } else {
                    $flag = false;
                    $this->Flash->error(__('Upload image only jpg,jpeg,png files.'));
                }
            } else {
                $this->request->data['path'] = $categories->path;
            }

            //--------------------------------------------------------------------------------


            if ($flag) {

                $categories = $this->Categories->patchEntity($categories, $this->request->data);
                $save = $this->Categories->save($categories);
                if ($save) {

                    //$lastid = $this->Category->getInsertID();
                    //$productsimages = $this->Categoryimages->newEntity();
                    //$products = $this->Category->patchEntity($products, $this->request->data); 
                    //$this->Flash->success(__('Category has been saved.'));
                } else {
                    $this->Flash->error(__('Category could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('Some fields are empty. Please, try again.'));
            }


            if ($flag) {
                $this->Flash->success(__('Category has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->loadModel('Bikemodels');
        $result = $this->Bikemodels->find('all');
        $this->set(compact('result'));
    }

    public function edit($id = null) {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Users');
        $this->loadModel('Categories');
        $category = $this->Categories->get($id);



        //$products = $this->Category->newEntity();
        //$productsimg = $this->Categoryimages->newEntity();
        if ($this->request->is(['post', 'put'])) {
            //print_r($this->request->data);
            //exit;
            $flag = true;
            $flag = true;
            if ($this->request->data['name'] == "") {
                $flag = false;
            }



            //--------------------------------------------------------------------------------

            $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
            if (!empty($this->request->data['image']['name'])) {
                $file = $this->request->data['image']; //put the data into a var for easy use
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                $fileName = time() . "." . $ext;
                if (in_array($ext, $arr_ext)) {

                    if ($category->path != "" && $category->path != $fileName) {
                        $filePathDel = WWW_ROOT . 'user_img' . DS . $category->path;
                        if (file_exists($filePathDel)) {
                            unlink($filePathDel);
                        }
                    }
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'category_img' . DS . $fileName);
                    $file = $fileName;
                    $this->request->data['path'] = $fileName;
                } else {
                    $flag = false;
                    $this->Flash->error(__('Upload image only jpg,jpeg,png files.'));
                }
            } else {
                $this->request->data['path'] = $category->path;
            }

            if ($flag) {

                $category = $this->Categories->patchEntity($category, $this->request->data);
                if ($this->Categories->save($category)) {
                    
                } else {
                    $this->Flash->error(__('Category could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('Some fields are empty. Please, try again.'));
            }


            if ($flag) {
                $this->Flash->success(__('Category has been saved.'));
            }
            //return $this->redirect(['action' => 'index']);
        }
        //$this->loadModel('Bikemodels');
        //echo $id;
        //$category = $this->Categories->find('all')->where(['Categories.id' => $id])->toArray();
        //print_r($all_image);
        // exit;
        //$result = $this->Bikemodels->find('all');
        $this->set(compact('category'));
        //$this->set(compact('products'));
    }

    public function delete($id = null) {
        $this->loadModel('Categories');
        $categories = $this->Categories->get($id);
        if ($this->Categories->delete($categories)) {
            $this->Flash->success(__('Category has been deleted.'));
        } else {
            $this->Flash->error(__('Category could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
