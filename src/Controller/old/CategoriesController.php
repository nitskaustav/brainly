<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 */
class CategoriesController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    /*
      public function beforeFilter(Event $event) {
      if (!$this->request->session()->check('Auth.Admin')) {
      return $this->redirect(
      ['controller' => 'Users', 'action' => 'index']
      );
      }
      }

     */

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['detail']); 
    }    
    
    
    // Treatment Listing for Category
    public function detail($slug=null) {
       
        $this->loadModel('Categories');
        $this->loadModel('TreatmentCategories');
        $this->viewBuilder()->layout('default');
        $data = $this->Categories->find()
                ->hydrate(false)                                
                ->where(['Categories.slug' => $slug])   
                ->contain(['TreatmentCategories.Treatments' => function($q) {
                        return $q->select(['Treatments.id', 'Treatments.name', 'Treatments.slug', 'Treatments.category_id', 'Treatments.image', 'Treatments.sort_descriptiion']);
                    }])
                ->limit(10000)->first();
        //pr($data); exit;
                    
        $others = $this->TreatmentCategories->find()
                ->where(['TreatmentCategories.catid != ' => $slug])
                ->order('rand()')
                ->contain(['Treatments'])
                ->limit(5)->all()->toArray();
        
        
        $pageSeo['site_meta_title'] = $data['meta_title'];
        $pageSeo['site_meta_description'] = $data['meta_description'];
        $pageSeo['site_meta_key'] = $data['meta_key'];        

        $this->set(compact('data', 'pageSeo','others'));
        $this->set('_serialize', ['data']); 

    }


}

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    


        

