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

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

use Cake\I18n\FrozenDate;
use Cake\Database\Type; 
Type::build('date')->setLocaleFormat('yyyy-MM-dd');



/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['display','index','home','cms','checkout','checklogin']); 
    }     
    
    


    public function home() {
        $this->viewBuilder()->layout('home_header');
        $this->loadModel('Easydownloads');
        $easydownloads = $this->Easydownloads->find()->order(['id' => 'ASC'])->all();
        $this->loadModel('Homecontents');
        $homecontent = $this->Homecontents->get(1);
        
        $this->loadModel('Goals');
        $goals = $this->Goals->find()->order(['position' => 'asc'])->all();
        
        
        $this->loadModel('Screenshots');
        $screenshots = $this->Screenshots->find()->order(['position' => 'asc'])->all();
        
        $this->set(compact('easydownloads','homecontent','goals','screenshots'));
        
        
        
        /*
          pj($this->request->session()->check('Auth.User'));
          pj($this->request->session()->read('Auth.User'));
          pr($this->request->session()->check('Auth.User'));
          pr($this->request->session()->read('Auth.User'));

          echo "qq"; exit;
         */

        //$this->layout = 'default';
        //$this->Flash->success(__('Patient has been deleted.'));
        //$this->Flash->error(__('Patient could not be deleted. Please, try again.'));
    }

    public function cms($pagename)
    {
        $this->loadModel('Contents');
        $details = $this->Contents->find()->where(['page_slug' => $pagename])->first();
        $this->set(compact('details'));
    }
}
