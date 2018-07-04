<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

use Cake\I18n\FrozenDate;
use Cake\Database\Type; 
Type::build('date')->setLocaleFormat('yyyy-MM-dd');


/**
 * Runs Controller
 *
 * @property \App\Model\Table\RunsTable $Runs
 */
class NewsesController extends AppController {
    public $paginate = ['limit' => 10];
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['index','detail']); 
        $this->loadComponent('Paginator');
    }    
    
    public function beforeFilter(Event $event) {

    }
    // Frontend News Listing
    public function index() {
        
        $this->viewBuilder()->layout('default');
        
        $this->loadModel('Newses');
        $this->loadModel('Treatments');
        $this->loadModel('NewsCategories');
        $this->loadModel('Categories');
        $this->set('news', $this->Paginator->paginate($this->Newses, [ 'limit' => 2, 'contain' => ['Treatments', 'NewsCategories', 'NewsCategories.Categories'], 'order' => [ 'id' => 'DESC'], 'conditions' => [ 'Newses.is_active' => 1]]));

    }

    public function detail($slug = null) {
        $this->viewBuilder()->layout('default');
        $this->loadModel('Newses');
        $this->loadModel('Treatments');
        $this->loadModel('NewsCategories');
        $this->loadModel('Categories');        
        
        $newsDetail = $this->Newses->find()
                                      ->contain(['Treatments', 'NewsCategories', 'NewsCategories.Categories'])
                                      ->where(['Newses.slug' => $slug])
                                      ->first()->toArray();        
        
        
        //pr($newsDetail); exit;
        
        $pageSeo['site_meta_title'] = $newsDetail['meta_title'];
        $pageSeo['site_meta_description'] = $newsDetail['meta_description'];
        $pageSeo['site_meta_key'] = $newsDetail['meta_key'];
        
        $this->set(compact('newsDetail','pageSeo'));
        $this->set('_serialize', ['newsDetail']);
    }


}