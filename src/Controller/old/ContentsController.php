<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;


class ContentsController extends AppController {
    public $paginate = ['limit' => 15];
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['index','reviews']); 
        $this->loadComponent('Paginator');
    }    
    
    public function beforeFilter(Event $event) {

    }

    // CMS page in Fronend
    public function index($slug = null) {
        $this->viewBuilder()->layout('other_layout');
        $mData = $this->Contents->find()->where(['Contents.page_slug' => $slug])->first()->toArray();
        //pr($mData); exit;
        
        $pageSeo['site_meta_title'] = $mData['meta_title'];
        $pageSeo['site_meta_description'] = $mData['meta_description'];
        $pageSeo['site_meta_key'] = $mData['meta_key'];        
        
        
        $this->set(compact('mData','pageSeo'));     
        $this->render($slug);
    }

    // Reviews Listing in Frontend
    public function reviews($slug = null) {
        $this->viewBuilder()->layout('default');
        
        $this->loadModel('Reviews');
        $this->loadModel('Users');
        $this->set('review', $this->Paginator->paginate($this->Reviews, [ 'limit' => 15, 'contain' => ['Users'], 'order' => [ 'id' => 'DESC'], 'conditions' => [ 'Reviews.is_active' => 1]]));   

    }
    
    

}
