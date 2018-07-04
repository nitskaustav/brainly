<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Routing\Router;
//use Cake\I18n\FrozenDate; 
use Cake\Database\Type;

//use Cake\I18n\Time;
//use Cake\I18n\Date;
//Type::build('date')->setLocaleFormat('yyyy-MM-dd');
// Admin Users Management
class ReviewsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['index', 'downloadfile']);
    }

    public $uses = array('User', 'Booking', 'Service');

    public function listreview() {

        $this->viewBuilder()->layout('admin');
        $this->loadModel('Reviews');
        $this->loadModel('Users');
        $this->loadModel('Services');
        $this->loadModel('ServiceTypes');
        $conditions = NULL;

        if (!empty($_REQUEST['title'])) {
            $conditions['and']['Users.utype'] = 1;
            $conditions['and']['Users.full_name LIKE'] = '%' . $_REQUEST['title'] . '%';
        }

        if (!empty($_REQUEST['sname'])) {
            $conditions['and']['Companies.utype'] = 2;
            $conditions['and']['Companies.full_name LIKE'] = '%' . $_REQUEST['sname'] . '%';
        }
        if (!empty($_REQUEST['location'])) {
            $conditions['and']['Users.address LIKE'] = '%' . $_REQUEST['location'] . '%';
        }
        if (!empty($_REQUEST['stype'])) {
            $conditions['and']['Services.service_type_id LIKE'] = '%' . $_REQUEST['stype'] . '%';
        }
        if (isset($_REQUEST['status']) && $_REQUEST['status'] != '') {
            $conditions['and']['Reviews.is_active'] = $_REQUEST['status'];
        }
        $this->paginate = [
            'conditions' => $conditions,
            'order' => [ 'Reviews.id' => 'DESC']
        ];
        $service = $this->paginate($this->Reviews, ['contain' => ['Users', 'Services', 'Companies']]);
        //pr($service);
        $countreview_nonverified = $this->Reviews->find()->where(['Reviews.is_active' => 0])->group('Reviews.id')->count();
        $countreview_verified = $this->Reviews->find()->where(['Reviews.is_active' => 1])->group('Reviews.id')->count();
        $countreview = $this->Reviews->find()->group('Reviews.id')->count();


        $stypes = $this->ServiceTypes->find()->where(['ServiceTypes.status' => 1])->toArray();

        $this->set(compact('service', 'countreview', 'countreview_verified', 'countreview_nonverified', 'stypes'));
        $this->set('_serialize', ['service']);
    }

    public function listreview_new() {

        $this->viewBuilder()->layout('admin');
        $this->loadModel('Reviews');
        $this->loadModel('Users');
        $this->loadModel('Services');
        $this->loadModel('ServiceTypes');
        $conditions = [ 'Reviews.moderation' => 0];

        if (!empty($_REQUEST['title'])) {
            $conditions['and']['Users.utype'] = 1;
            $conditions['and']['Users.full_name LIKE'] = '%' . $_REQUEST['title'] . '%';
        }

        if (!empty($_REQUEST['sname'])) {
            $conditions['and']['Companies.utype'] = 2;
            $conditions['and']['Companies.full_name LIKE'] = '%' . $_REQUEST['sname'] . '%';
        }
        if (!empty($_REQUEST['location'])) {
            $conditions['and']['Users.address LIKE'] = '%' . $_REQUEST['location'] . '%';
        }
        if (!empty($_REQUEST['stype'])) {
            $conditions['and']['Services.service_type_id LIKE'] = '%' . $_REQUEST['stype'] . '%';
        }

        $this->paginate = [
            'conditions' => $conditions,
            'order' => [ 'Reviews.id' => 'DESC']
        ];
        $service = $this->paginate($this->Reviews, ['contain' => ['Users', 'Services', 'Companies']]);
        //pr($service);
        $countreview_nonverified = $this->Reviews->find()->where(['Reviews.is_active' => 0])->group('Reviews.id')->count();
        $countreview_verified = $this->Reviews->find()->where(['Reviews.is_active' => 1])->group('Reviews.id')->count();
        $countreview = $this->Reviews->find()->where(['Reviews.moderation' => 0])->group('Reviews.id')->count();


        $stypes = $this->ServiceTypes->find()->where(['ServiceTypes.status' => 1])->toArray();

        $this->set(compact('service', 'countreview', 'countreview_verified', 'countreview_nonverified', 'stypes'));
        $this->set('_serialize', ['service']);
    }

    public function reviewview($id = null) {

        $this->viewBuilder()->layout('admin');
        $this->loadModel('Reviews');
        $this->loadModel('ReviewImages');
        $users = $this->Reviews->get($id, ['contain' => ['Users', 'Services', 'Companies']]);
//pr($users);
        //$results = $customer->toArray(); 
        //pr($users); exit;
        $rimages = $this->ReviewImages->find('all', array('conditions' => array('ReviewImages.review_id' => $id)));

        $this->set('users', $users);
        $this->set(compact('users', 'rimages'));
        $this->set('_serialize', ['users']);
    }

    public function editreview($id = null) {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Reviews');
        $this->loadModel('ReviewImages');

        $user = $this->Reviews->get($id);
        if ($this->request->is(['post', 'put'])) {
            //pr($this->request->data); exit;
            $flag = true;
            if ($this->request->data['review'] == "") {
                $this->Flash->error(__('Review can not be null. Please, try again.'));
                $flag = false;
            }



            if ($flag) {

                $this->request->data['moderation'] = 1;
                $user = $this->Reviews->patchEntity($user, $this->request->data);

                if ($this->Reviews->save($user)) {

                    if ($this->request->data['image'] != '') {
                        $file_image_name = explode(",", $this->request->data['image']);
                        //print_r($file_image_name);exit;
                        foreach ($file_image_name as $img) {


                            $this->request->data['review_id'] = $id;
                            $this->request->data['image_name'] = $img;
                            $spimage = $this->ReviewImages->newEntity();
                            $spimage = $this->ReviewImages->patchEntity($spimage, $this->request->data);

                            $this->ReviewImages->save($spimage);
                        }
                    }




                    $this->Flash->success(__('Review has been edited successfully.'));
                    //return $this->redirect(['action' => 'listreview']);
                } else {
                    $this->Flash->error(__('Reviews could not be edit. Please, try again.'));
                    //return $this->redirect(['action' => 'listservice',$id]);
                }
            } else {
                return $this->redirect(['action' => 'listreview']);
            }
        }

        $all_image = $this->ReviewImages->find()->where(['ReviewImages.review_id' => $id])->toArray();

        $this->set(compact('user', 'all_image'));
        $this->set('_serialize', ['user']);
    }

    public function upload_photo_add() {


        //$this->viewBuilder()->autoRender(false);
        $this->viewBuilder()->layout(false);
        $filen = '';
        //print_r($_FILES);
        if (!empty($_FILES['files']['name'])) {

            $no_files = count($_FILES["files"]['name']);

            //echo $no_files;exit;
            if ($no_files <= 6) {

                for ($i = 0; $i < $no_files; $i++) {
                    if ($_FILES["files"]["error"][$i] > 0) {
                        echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
                        //echo 'a';exit;
                    } else {

                        $pathpart = pathinfo($_FILES["files"]["name"][$i]);
                        //echo $pathpart;exit;
                        $ext = $pathpart['extension'];
                        $uploadFolder = "review_img/";
                        $uploadPath = WWW_ROOT . $uploadFolder;
                        $filename = uniqid() . '.' . $ext;
                        $full_flg_path = $uploadPath . '/' . $filename;
                        if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $full_flg_path)) {


                            $file = array('filename' => $filename, 'last_id' => $i + 1);

                            if ($filen == '') {
                                $filen = $filename;
                            } else {
                                $filen = $filen . ',' . $filename;
                            }
                        }
                        $file_details[] = $file;
                    }
                }
            }
            $data = array('Ack' => 1, 'data' => $file_details, 'image_name' => $filen);
        } else {

            $data = array('Ack' => 0);
        }
        echo json_encode($data);
        exit();
    }

    public function delete_image() {

        $this->viewBuilder()->layout(false);
        $this->loadModel('ReviewImages');
        $imageid = $this->ReviewImages->get($_REQUEST['id']);

        if ($this->ReviewImages->delete($imageid)) {
            $data = array('Ack' => 1);
        } else {
            $data = array('Ack' => 0);
        }
        echo json_encode($data);
        exit();
    }

    public function reviewdelete($id = null) {
        $this->loadModel('Reviews');
        $services = $this->Reviews->get($id);
        if ($this->Reviews->delete($services)) {
            $this->Flash->success(__('Review has been deleted.'));
        } else {
            $this->Flash->error(__('Review could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'listreview']);
    }

    public function reviewstatus($id = null, $status = null) {

        $this->loadModel('Reviews');
        $tableRegObj = TableRegistry::get('Reviews');
        $query = $tableRegObj->find('all', [ 'conditions' => ['id' => $id]]);
        $row = $query->first()->toArray();
        //pr($row); exit;
        if ($row) {
            $subquestion = TableRegistry::get('Reviews');
            $query = $subquestion->query();
            if ($status == 1) {
                $query->update()->set(['is_active' => 1, 'moderation' => 1])->where(['id' => $id])->execute();
                $this->Flash->success(__('Review has been approved.'));
            } else if ($status == 0) {
                $query->update()->set(['is_active' => 0])->where(['id' => $id])->execute();
                $this->Flash->success(__('Review has been suspended.'));
            }
        } else {
            $this->Flash->error(__('Review Not Found.'));
        }
        return $this->redirect(['action' => 'listreview']);
    }

    public function serviceprovider_review($id) {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Reviews');

        $conditions = ['Reviews.service_provider_id' => $id];

        $this->paginate = [
            'conditions' => $conditions,
            'order' => [ 'id' => 'DESC']
        ];
        $service = $this->paginate($this->Reviews, ['contain' => ['Users', 'Services', 'Companies']]);
        //pr($user->toArray());
        $this->set(compact('service', 'id'));
        $this->set('_serialize', ['service', 'id']);
    }

    // for individual


    public function serviceprovider_editreview($id = null, $sid = null) {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Reviews');


        $user = $this->Reviews->get($id);
        if ($this->request->is(['post', 'put'])) {
            //pr($this->request->data); exit;
            $flag = true;
            if ($this->request->data['review'] == "") {
                $this->Flash->error(__('Review can not be null. Please, try again.'));
                $flag = false;
            }
            if ($flag) {

                $user = $this->Reviews->patchEntity($user, $this->request->data);

                if ($this->Reviews->save($user)) {
                    $this->Flash->success(__('Review has been edited successfully.'));
                    return $this->redirect(['action' => 'serviceprovider_review', $sid]);
                } else {
                    $this->Flash->error(__('Reviews could not be edit. Please, try again.'));
                    //return $this->redirect(['action' => 'listservice',$id]);
                }
            } else {
                return $this->redirect(['action' => 'serviceprovider_review', $sid]);
            }
        }



        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function serviceprovider_reviewdelete($id = null, $sid) {
        $this->loadModel('Reviews');
        $services = $this->Reviews->get($id);
        if ($this->Reviews->delete($services)) {
            $this->Flash->success(__('Review has been deleted.'));
        } else {
            $this->Flash->error(__('Review could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'serviceprovider_review', $sid]);
    }

    public function serviceprovider_reviewstatus($id = null, $status = null, $sid) {

        $this->loadModel('Reviews');
        $tableRegObj = TableRegistry::get('Reviews');
        $query = $tableRegObj->find('all', [ 'conditions' => ['id' => $id]]);
        $row = $query->first()->toArray();
        //pr($row); exit;
        if ($row) {
            $subquestion = TableRegistry::get('Reviews');
            $query = $subquestion->query();
            if ($status == 1) {
                $query->update()->set(['is_active' => 1,])->where(['id' => $id])->execute();
                $this->Flash->success(__('Review has been approved.'));
            } else if ($status == 0) {
                $query->update()->set(['is_active' => 0])->where(['id' => $id])->execute();
                $this->Flash->success(__('Review has been suspended.'));
            }
        } else {
            $this->Flash->error(__('Review Not Found.'));
        }
        return $this->redirect(['action' => 'serviceprovider_review', $sid]);
    }

    public function listserviceprovider() {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('ServiceTypes');
        $this->loadModel('Users');
        //$user = $this->Users->find();
        $conditions = ['Users.utype' => 2, 'Users.check_by_admin' => 0];
        if (!empty($_REQUEST['title'])) {
            $conditions['OR']['full_name LIKE'] = '%' . $_REQUEST['title'] . '%';

            $conditions['OR']['email LIKE'] = '%' . $_REQUEST['title'] . '%';
        }
        if (!empty($_REQUEST['location'])) {
            $conditions['and']['address LIKE'] = '%' . $_REQUEST['location'] . '%';
        }
        if (!empty($_REQUEST['stype'])) {
            $conditions['and']['service_type_id LIKE'] = '%' . $_REQUEST['stype'] . '%';
        }




        $this->paginate = [
            'conditions' => $conditions,
            'order' => [ 'id' => 'DESC']
        ];
        $user = $this->paginate($this->Users);
        $stypes = $this->ServiceTypes->find()->where(['ServiceTypes.status' => 1])->toArray();

        $countprovider = $this->Users->find()->where([$conditions])->group('Users.id')->count();

        $this->set(compact('user', 'stypes', 'countprovider'));
        $this->set('_serialize', ['user']);
    }

    public function serviceproviderview($id = null) {

        $this->viewBuilder()->layout('admin');
        $this->loadModel('ServiceTypes');
        $this->loadModel('Makes');
        $this->loadModel('Features');
        $this->loadModel('ServiceProviderImages');
        //$this->loadModel('ServiceProviderDocuments');
        $this->loadModel('Users');
        $users = $this->Users->get($id);

        $stid = explode(',', $users->service_type_id);
        $sfid = explode(',', $users->service_feature_id);
        $stagid = explode(',', $users->service_make_id);

        $stname = $this->ServiceTypes->find('all', array('conditions' => array('ServiceTypes.id IN' => $stid)));
        $sfname = $this->Features->find('all', array('conditions' => array('Features.id IN' => $sfid)));
        $stagname = $this->Makes->find('all', array('conditions' => array('Makes.id IN' => $stagid)));

        $spimages = $this->ServiceProviderImages->find('all', array('conditions' => array('ServiceProviderImages.serviceprovider_id' => $id)));

        //$spdocs=$this->ServiceProviderDocuments->find('all', array('conditions' => array('ServiceProviderDocuments.serviceprovider_id' =>$id))); 


        $this->set('users', $users);
        $this->set(compact('stname', 'spimages', 'stagname', 'spdocs', 'sfname'));
        $this->set('_serialize', ['users', 'spimages']);
    }

    public function serviceproviderverified($id = null, $status = null) {
        //echo $id; echo "--"; echo $status; //exit;
        $this->loadModel('Users');
        $tableRegObj = TableRegistry::get('Users');
        $query = $tableRegObj->find('all', [ 'conditions' => ['id' => $id]]);
        $row = $query->first()->toArray();
        //pr($row); exit;
        if ($row) {
            $subquestion = TableRegistry::get('Users');
            $query = $subquestion->query();
            if ($status == 'Y') {
                $query->update()->set(['is_active' => 1, 'check_by_admin' => 1, 'check_verified' => 'Y', 'verified_date' => gmdate("Y-m-d h:i:s")])->where(['id' => $id])->execute();
                $this->Flash->success(__('Seller has been Verified.'));
            } else if ($status == 'N') {
                $query->update()->set(['is_active' => 0, 'check_by_admin' => 1, 'check_verified' => 'N', 'verified_date' => gmdate("Y-m-d h:i:s")])->where(['id' => $id])->execute();
                $this->Flash->success(__('Seller has been suspended.'));
            }
        } else {
            $this->Flash->error(__('Seller Not Found.'));
        }
        return $this->redirect(['action' => 'listserviceprovider']);
    }

    public function companydelete($id = null) {
        //$this->request->allowMethod(['post', 'delete']);
        $this->loadModel('Users');
        $users = $this->Users->get($id);
        if ($this->Users->delete($users)) {
            $this->Flash->success(__('Company has been deleted.'));
        } else {
            $this->Flash->error(__('Company could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'listserviceprovider']);
    }

    public function downloadfile($id = NULL) {

        $ext = strstr($id, '.');
        //echo $ext;exit;

        $file_path = WWW_ROOT . 'user_doc' . DS . $id;
        $this->response->file($file_path, array(
            'download' => true,
            'name' => 'document' . $ext,
        ));
        return $this->response;
    }

    public function addratingtext() {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('RatingTexts');
        $this->loadModel('RatingTypes');
        $rating = $this->RatingTexts->newEntity();
        if ($this->request->is('post')) {

            $flag = true;

            $tableRegObj = TableRegistry::get('RatingTexts');

            // Validating Form
            if ($this->request->data['type_id'] == "") {
                $this->Flash->error(__('Type Name can not be null. Please, try again.'));
                $flag = false;
            }
            if ($this->request->data['rating_value'] == "") {
                $this->Flash->error(__('Rating can not be null. Please, try again.'));
                $flag = false;
            }
            if ($this->request->data['rating_text'] == "") {
                $this->Flash->error(__('Rating text can not be null. Please, try again.'));
                $flag = false;
            }

            if ($flag) {

                // Saving User details after validation
                $rating = $this->RatingTexts->patchEntity($rating, $this->request->data);
                if ($this->RatingTexts->save($rating)) {

                    $this->Flash->success('Rating Text added successfully.', ['key' => 'success']);

                    //pr($this->request->data); pr($user); exit;
                    $this->redirect(['action' => 'listratingtext']);
                }
            }
        }

        $ratingtype = $this->RatingTypes->find()->where(['is_active' => 1])->toArray();
        $this->set(compact('rating', 'ratingtype'));
        $this->set('_serialize', ['rating']);
    }

    public function editratingtext($id = null) {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('RatingTexts');
        $this->loadModel('RatingTypes');
        $user = $this->RatingTexts->get($id);
        if ($this->request->is(['post', 'put'])) {
            //pr($this->request->data); exit;
            $flag = true;
            if ($this->request->data['type_id'] == "") {
                $this->Flash->error(__('Type Name can not be null. Please, try again.'));
                $flag = false;
            }
            if ($this->request->data['rating_value'] == "") {
                $this->Flash->error(__('Rating can not be null. Please, try again.'));
                $flag = false;
            }
            if ($this->request->data['rating_text'] == "") {
                $this->Flash->error(__('Rating text can not be null. Please, try again.'));
                $flag = false;
            }

            if ($flag) {

                $user = $this->RatingTexts->patchEntity($user, $this->request->data);

                if ($this->RatingTexts->save($user)) {
                    $this->Flash->success(__('Rating Text has been edited successfully.'));
                    return $this->redirect(['action' => 'listratingtext']);
                } else {
                    $this->Flash->error(__('Rating Text could not be edit. Please, try again.'));
                    //return $this->redirect(['action' => 'listservice',$id]);
                }
            } else {
                return $this->redirect(['action' => 'listratingtext']);
            }
        }
        $ratingtype = $this->RatingTypes->find()->where(['is_active' => 1])->toArray();
        $this->set(compact('user', 'ratingtype'));
        $this->set('_serialize', ['user']);
    }

    public function listratingtext() {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('RatingTexts');
        $this->loadModel('RatingTypes');

        $conditions = ['RatingTexts.is_active' => 1];

        $this->paginate = [

            'order' => [ 'id' => 'DESC']
        ];
        $rating = $this->paginate($this->RatingTexts, ['contain' => ['RatingTypes']]);
        //pr($user->toArray());
        $this->set(compact('rating'));
        $this->set('_serialize', ['rating']);
    }

    public function ratingtextdelete($id = null) {
        $this->loadModel('RatingTexts');
        $services = $this->RatingTexts->get($id);
        if ($this->RatingTexts->delete($services)) {
            $this->Flash->success(__('Rating text has been deleted.'));
        } else {
            $this->Flash->error(__('Rating text could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'listratingtext']);
    }

    public function ratingtextstatus($id = null, $status = null) {

        $this->loadModel('RatingTexts');
        $tableRegObj = TableRegistry::get('RatingTexts');
        $query = $tableRegObj->find('all', [ 'conditions' => ['id' => $id]]);
        $row = $query->first()->toArray();
        //pr($row); exit;
        if ($row) {
            $subquestion = TableRegistry::get('RatingTexts');
            $query = $subquestion->query();
            if ($status == 1) {
                $query->update()->set(['is_active' => 1,])->where(['id' => $id])->execute();
                $this->Flash->success(__('Rating text has been activated.'));
            } else if ($status == 0) {
                $query->update()->set(['is_active' => 0])->where(['id' => $id])->execute();
                $this->Flash->success(__('Rating text has been suspended.'));
            }
        } else {
            $this->Flash->error(__('Rating text Not Found.'));
        }
        return $this->redirect(['action' => 'listratingtext']);
    }

    public function listwish() {

        $this->viewBuilder()->layout('admin');
        $this->loadModel('Favourites');
        $this->loadModel('Users');
        $this->loadModel('Services');
        $this->loadModel('ServiceTypes');
        $conditions = NULL;

        if (!empty($_REQUEST['title'])) {
            $conditions['and']['Users.utype'] = 1;
            $conditions['and']['Users.full_name LIKE'] = '%' . $_REQUEST['title'] . '%';
        }

        if (!empty($_REQUEST['sname'])) {
            $conditions['and']['Companies.utype'] = 2;
            $conditions['and']['Companies.full_name LIKE'] = '%' . $_REQUEST['sname'] . '%';
        }
        if (!empty($_REQUEST['location'])) {
            $conditions['and']['Users.address LIKE'] = '%' . $_REQUEST['location'] . '%';
        }
        if (!empty($_REQUEST['stype'])) {
            $conditions['and']['Services.service_type_id LIKE'] = '%' . $_REQUEST['stype'] . '%';
        }

        $this->paginate = [
            'conditions' => $conditions,
            'order' => [ 'Favourites.id' => 'DESC']
        ];
        $service = $this->paginate($this->Favourites, ['contain' => ['Users', 'Services', 'Companies']]);
        //pr($service);

        $countreview = $this->Favourites->find()->group('Favourites.id')->count();


        $stypes = $this->ServiceTypes->find()->where(['ServiceTypes.status' => 1])->toArray();

        $this->set(compact('service', 'countreview', 'stypes'));
        $this->set('_serialize', ['service']);
    }

}
