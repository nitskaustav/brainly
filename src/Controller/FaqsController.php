<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

use Cake\I18n\FrozenDate;
use Cake\Database\Type; 
Type::build('date')->setLocaleFormat('yyyy-MM-dd');


/**
 * Faqs Controller
 *
 * @property \App\Model\Table\FaqsTable $Runs
 */
class FaqsController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['index']); 
    }     
    
    
    public function beforeFilter(Event $event) {

    }

    // Faq Listing Frontend
    public function index() {
        
        $this->viewBuilder()->layout('other_layout');
        $faqs = $this->Faqs->find()->where(['Faqs.cat' => 'general','Faqs.is_active' => 1])->toArray();
        $this->set(compact('faqs'));
        $this->set('_serialize', ['faqs']);
    }
    
    

}
