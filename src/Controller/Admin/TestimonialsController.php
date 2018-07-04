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
class TestimonialsController extends AppController {

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['getcount']);
    }

    public function index() {

        $this->viewBuilder()->layout('admin');

        $this->loadModel('Testimonials');


        $this->paginate = [

            'order' => [ 'id' => 'DESC']
        ];
        $testimonials = $this->paginate($this->Testimonials);
        $this->set(compact('testimonials'));
        $this->set('_serialize', ['testimonials']);
    }

    public function add() {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Testimonials');
        $this->loadModel('Users');

        $users = $this->Users->find()->select(['id', 'first_name'])->where(['utype' => 1])->toArray();
        $testimonial = $this->Testimonials->newEntity();
        if ($this->request->is('post')) {

            //$tableRegObj = TableRegistry::get('Testimonials');
            // Saving User details after validation
            $testimonial = $this->Testimonials->patchEntity($testimonial, $this->request->data);

            if ($s = $this->Testimonials->save($testimonial)) {

                $this->Flash->success('Testimonial added successfully.', ['key' => 'success']);
                $this->redirect(['action' => 'index']);
            }
        }
        $this->set(compact('users', 'testimonial'));
    }

    public function edit($id = null) {
        $this->viewBuilder()->layout('admin');
        $this->loadModel('Testimonials');
        $this->loadModel('Users');

        $users = $this->Users->find()->select(['id', 'full_name'])->where(['utype' => 1])->toArray();
        $testimonial = $this->Testimonials->get($id);

        if ($this->request->is(['post', 'put'])) {
            // pr($this->request->data);
            //exit;
            $testimonial = $this->Testimonials->patchEntity($testimonial, $this->request->data);

            if ($this->Testimonials->save($testimonial)) {
                $this->Flash->success(__('Testimonial has been edited successfully.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Testimonial could not be edit. Please, try again.'));
                //return $this->redirect(['action' => 'listservice',$id]);
            }
        }


        $this->set(compact('users', 'testimonial'));
        $this->set('_serialize', ['users', 'testimonial']);
    }

    public function delete($id = null) {
        $this->loadModel('Testimonials');
        $testimonials = $this->Testimonials->get($id);
        if ($this->Testimonials->delete($testimonials)) {
            $this->Flash->success(__('Product has been deleted.'));
        } else {
            $this->Flash->error(__('Product could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}

//SELECT MONTH(reg_date) , COUNT(reg_date) FROM your_table WHERE reg_date >= NOW() - INTERVAL 1 YEAR GROUP BY MONTH(reg_date)

