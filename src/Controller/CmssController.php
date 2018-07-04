<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Routing\Router;
use Cake\I18n\FrozenDate;
use Cake\Database\Type;
use Cake\Network\Session\DatabaseSession;

Type::build('date')->setLocaleFormat('yyyy-MM-dd');

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
/*
 * Users Controller
 * Frontend User Management
 */

class CmssController extends AppController {

	public $paginate = ['limit' => 2];

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['aboutus','privacypolicy','termsandcondition']);
        $this->loadComponent('Paginator');
    }

    public function aboutus(){
    	$this->viewBuilder()->layout('default');
    	$this->loadModel('Contents');

    	$aboutus = $this->Contents->find()->select('content')->where(['page_title' => 'About Us'])->toArray();
    	$this->set(compact('aboutus'));
    }

    public function privacypolicy(){
    	$this->viewBuilder()->layout('default');
    	$this->loadModel('Contents');

    	$privacypolicy = $this->Contents->find()->select('content')->where(['page_title' => 'Privacy Policy'])->toArray();
    	$this->set(compact('privacypolicy'));
    }

    public function termsandcondition(){
    	$this->viewBuilder()->layout('default');
    	$this->loadModel('Contents');

    	$terms = $this->Contents->find()->select('content')->where(['page_title' => 'Terms And Condition'])->toArray();
    	$this->set(compact('terms'));
    }

}